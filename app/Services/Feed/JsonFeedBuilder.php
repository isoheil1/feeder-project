<?php

namespace App\Services\Feed;

use App\Contracts\FeedBuilderStrategy;

class JsonFeedBuilder implements FeedBuilderStrategy
{

    public function addItems(array $items): void
    {
    }

    public function setDescription(string $description): void
    {
    }

    public function setTitle(string $title): void
    {
    }

    public function setURL(string $url): void
    {
    }

    public function export(): mixed
    {
    }
}
