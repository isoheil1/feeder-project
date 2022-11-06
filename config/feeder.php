<?php

use App\Enums\FeedFormats;
use App\Enums\FeedMerchants;

return [

    /**
     * The list of supported builders
     */
    'builders' => [
        [FeedFormats::JSON, App\Services\Feeder\Builders\JSONFeedBuilder::class],
        [FeedFormats::XML, App\Services\Feeder\Builders\XMLFeedBuilder::class]
    ],

    /**
     * The list of supported formatters
     */
    'formatters' => [
        [FeedMerchants::Google, App\Services\Feeder\Formatters\GoogleFeedFormatter::class],
        [FeedMerchants::Facebook, App\Services\Feeder\Formatters\FacebookFeedFormatter::class],
    ],

];
