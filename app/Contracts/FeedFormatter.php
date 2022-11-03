<?php

namespace App\Contracts;

interface FeedFormatter
{
    public function format(array $items);
}
