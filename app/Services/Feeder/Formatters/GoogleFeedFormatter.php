<?php

namespace App\Services\Feeder\Formatters;

use App\Services\Feeder\Formatters\FeedFormatterBase;

class GoogleFeedFormatter extends FeedFormatterBase
{
    protected array $required = [
        'id',
        'title',
        'description',
        'image_link',
        'availability',
        'availability_date',
        'price',
    ];

    protected array $optional = [
        'brand',
    ];

    protected array $rename = [
        //
    ];
}
