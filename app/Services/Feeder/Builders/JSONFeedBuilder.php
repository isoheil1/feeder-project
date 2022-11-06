<?php

namespace App\Services\Feeder\Builders;

use App\Contracts\FeedBuilder;

class JSONFeedBuilder implements FeedBuilder
{
    private array $items;

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function getContentType(): string
    {
        return "application/json";
    }

    public function build(): mixed
    {
        return json_encode($this->items);
    }
}
