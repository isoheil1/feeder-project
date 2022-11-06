<?php

namespace App\Contracts;

interface FeedBuilder
{
    public function setItems(array $items);

    public function getContentType(): string;

    public function build(): mixed;
}
