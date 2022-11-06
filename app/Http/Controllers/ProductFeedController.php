<?php

namespace App\Http\Controllers;

use App\Enums\FeedFormats;
use App\Enums\FeedMerchants;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Contracts\FeedBuilder;
use App\Contracts\ProductRepositoryInterface;
use App\Services\Feeder\Formatters\FeedFormatterBase;
use App\Services\Feeder\ProductFeeder;

class ProductFeedController extends Controller
{

    private $repository;


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
     * @return \Illuminate\Http\Response
     */
    public function export(string $merchant, string $fileFormat): Response
    {
        if ($this->validateRequest($merchant, $fileFormat) == false) {
            return ResponseHelper::fail(code: Response::HTTP_BAD_REQUEST, message: trans('errors.400'));
        }

        $builder = $this->parseBuilder($fileFormat);
        $formatter  = $this->parseFormatter($merchant);

        $productFeeder = new ProductFeeder($builder, $formatter);

        $productFeeder->setProducts($this->repository->paginate(10)->getCollection()->toArray());
        $feed = $productFeeder->build();

        return response($feed, Response::HTTP_OK, ['Content-Type' => $builder->getContentType()]);
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

    /**
     * Validate route parameters
     *
     * @param string $merchant
     * @param string $fileFormat
     * @return bool
     */
    private function validateRequest(string $merchant, string $fileFormat)
    {
        $merchantFlag = false;
        $fileFormatFlag = false;

        // check merchant supported
        foreach (FeedMerchants::cases() as $m) {
            if ($merchant == $m->value) {
                $merchantFlag = true;
                break;
            }
        }

        // check file format supported
        foreach (FeedFormats::cases() as $f) {
            if ($fileFormat == $f->value) {
                $fileFormatFlag = true;
                break;
            }
        }

        return $fileFormatFlag && $merchantFlag;
    }
}
