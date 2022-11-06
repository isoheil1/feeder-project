<?php

namespace App\Services\Feeder\Formatters;

use App\Services\Feeder\Formatters\FeedFormatterBase;

class FacebookFeedFormatter extends FeedFormatterBase
{
    protected array $required = [
        'id',
        'title',
        'description',
        'sku',
        'condition',
        'image_link',
        'availability',
        'availability_date',
        'price',
    ];

    protected array $optional = [
        'brand',
        'sale_price'
    ];

    protected array $rename = [
        'description' => 'details'
    ];
}
