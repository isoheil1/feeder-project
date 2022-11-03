<?php

namespace App\Services;

use App\Contracts\FeedBuilder;
use App\Contracts\FeedFormatter;
use Illuminate\Database\Eloquent\Collection;

class ProductFeedBuilder
{

    private FeedFormatter $formatter;
    private FeedBuilder $builder;
    private Collection $products;

    public function __construct(FeedBuilder $builder, FeedFormatter $formatter)
    {
        $this->builder = $builder;
        $this->formatter = $formatter;
    }

    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    public function build()
    {
        // $items = $this->formatter->format($products);
    }
}
