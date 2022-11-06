<?php

namespace App\Services\Feeder\Formatters;

use App\Services\Feeder\Formatters\FeedFormatterBase;

class GoogleFeedFormatter extends FeedFormatterBase
{
    protected array $required = [
        'title',
        'description',
        'sku',
        'image_link',
    ];

    protected array $optional = [
        'brand',
    ];

    protected array $rename = [
        'description' => 'details'
    ];
}
