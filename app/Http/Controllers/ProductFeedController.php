<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Contracts\FeedBuilder;
use App\Contracts\ProductRepositoryInterface;
use App\Http\Requests\ProductFeedRequest;
use App\Services\Feeder\Formatters\FeedFormatterBase;
use App\Services\Feeder\ProductFeeder;
use Illuminate\Http\JsonResponse;
use Cache;

class ProductFeedController extends Controller
{

    private $repository;

    private const PER_PAGE = 12;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Export and show product feeds
     *
     * @param string $merchant
     * @param string $fileFormat
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function export(ProductFeedRequest $request, string $merchant, string $fileFormat): Response|JsonResponse
    {
        if ($request->has('page') == false)
            return $this->showPages($merchant, $fileFormat);

        $builder = $this->parseBuilder($fileFormat);
        $formatter  = $this->parseFormatter($merchant);

        $productFeeder = new ProductFeeder($builder, $formatter);

        // load products from cache
        $products = Cache::tags(['products'])->rememberForever('product-feed-' . $request->input('page'), function () {
            return $this->repository->paginate(self::PER_PAGE)->getCollection()->toArray();
        });

        $productFeeder->setProducts($products);
        $feed = $productFeeder->build();

        return response($feed, Response::HTTP_OK, ['Content-Type' => $builder->getContentType()]);
    }

    /**
     * Show feed pages
     *
     * @param string $merchant
     * @param string $fileFormat
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function showPages(string $merchant, string $fileFormat): JsonResponse
    {
        $productsCount = $this->repository->count();
        $pagesCount = ceil($productsCount / self::PER_PAGE);

        $data = [
            'pages' => [],
            'merchant' => $merchant,
            'fileFormat' => $fileFormat,
            'perPage' => self::PER_PAGE,
            'total' => $productsCount
        ];

        if ($pagesCount > 0) {
            foreach (range(1, $pagesCount) as $page) {
                $data['pages'][] = route('feeds.export', [
                    'page' => $page,
                    'merchant' => $merchant,
                    'fileFormat' => $fileFormat
                ]);
            }
        }

        return ResponseHelper::success(Response::HTTP_OK, $data);
    }

    /**
     * Parse feed formatter
     *
     * @param string $merchant
     * @return \App\Services\Feeder\Formatters\FeedFormatterBase
     */
    private function parseFormatter(string $merchant): FeedFormatterBase
    {
        foreach (config('feeder.formatters') as $formatter) {
            if ($formatter[0]->value == $merchant) return new $formatter[1];
        }
    }

    /**
     * Parse feed builder
     *
     * @param string $fileFormat
     * @return \App\Contracts\FeedBuilder
     */
    private function parseBuilder(string $fileFormat): FeedBuilder
    {
        foreach (config('feeder.builders') as $builder) {
            if ($builder[0]->value == $fileFormat) return new $builder[1];
        }
    }
}
