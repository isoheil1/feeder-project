<?php

namespace App\Http\Controllers;

use App\Contracts\FeedBuilder;
use App\Contracts\FeedFormatter;
use App\Enums\FeedFormats;
use App\Enums\FeedMerchants;
use App\Helpers\ResponseHelper;
use App\Models\Product;
use App\Services\Feed\XMLFeedBuilder;
use App\Services\Feeder\Builders\JSONFeedBuilder;
use App\Services\Feeder\Formatters\FacebookFeedFormatter;
use App\Services\Feeder\Formatters\GoogleFeedFormatter;
use Illuminate\Http\Response;

class ProductFeedController extends Controller
{

    /**
     * Export product feed 
     */
    public function export(string $merchant, string $fileFormat)
    {
        if ($this->validateRequest($merchant, $fileFormat) == false) {
            return ResponseHelper::fail(code: Response::HTTP_BAD_REQUEST, message: trans('errors.400'));
        }

        dd('Hello');

        $formatter = $this->parseFormatter($merchant);
        $builder = $this->parseBuilder($fileFormat);
    }

    /**
     * Parse feed formatter 
     * 
     * @param string $merchant
     * @return App\Contracts\FeedFormatter
     */
    private function parseFormatter(string $merchant): FeedFormatter
    {
        return match ($merchant) {
            FeedMerchants::Google => new GoogleFeedFormatter,
            FeedMerchants::Facebook => new FacebookFeedFormatter,
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
            FeedFormats::JSON => new JSONFeedBuilder,
            FeedFormats::XML => new XMLFeedBuilder
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
