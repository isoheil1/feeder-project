<?php

namespace App\Http\Controllers;

use App\Enums\FeedFormats;
use App\Enums\FeedMerchants;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Contracts\FeedBuilder;
use App\Contracts\ProductRepositoryInterface;
use App\Services\Feeder\Builders\JSONFeedBuilder;
use App\Services\Feeder\Builders\XMLFeedBuilder;
use App\Services\Feeder\Formatters\FacebookFeedFormatter;
use App\Services\Feeder\Formatters\FeedFormatterBase;
use App\Services\Feeder\Formatters\GoogleFeedFormatter;
use App\Services\Feeder\ProductFeeder;

class ProductFeedController extends Controller
{

    private $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Export product feed 
     */
    public function export(string $merchant, string $fileFormat)
    {
        if ($this->validateRequest($merchant, $fileFormat) == false) {
            return ResponseHelper::fail(code: Response::HTTP_BAD_REQUEST, message: trans('errors.400'));
        }

        $productFeeder = new ProductFeeder(
            $this->parseBuilder($fileFormat),
            $this->parseFormatter($merchant)
        );
        $productFeeder->setProducts($this->repository->paginate(10)->getCollection()->toArray());
        $feed = $productFeeder->build();
    }

    /**
     * Parse feed formatter 
     * 
     * @param string $merchant
     * @return App\Services\Feeder\Formatters\FeedFormatterBase
     */
    private function parseFormatter(string $merchant): FeedFormatterBase
    {
        return match ($merchant) {
            FeedMerchants::Google->value => new GoogleFeedFormatter,
            FeedMerchants::Facebook->value => new FacebookFeedFormatter,
        };
    }

    /**
     * Parse feed builder
     * 
     * @param string $fileFormat
     * @return App\Contracts\FeedBuilder
     */
    private function parseBuilder(string $fileFormat): FeedBuilder
    {
        return match ($fileFormat) {
            FeedFormats::JSON->value => new JSONFeedBuilder,
            FeedFormats::XML->value => new XMLFeedBuilder
        };
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
