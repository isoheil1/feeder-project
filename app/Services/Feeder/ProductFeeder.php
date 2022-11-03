<?php

namespace App\Services\Feeder;

use App\Contracts\FeedBuilder;
use App\Services\Feeder\Formatters\FeedFormatterBase;

class ProductFeeder
{

    private FeedFormatterBase $formatter;
    private FeedBuilder $builder;
    private array $products;

    public function __construct(FeedBuilder $builder, FeedFormatterBase $formatter)
    {
        $this->builder = $builder;
        $this->formatter = $formatter;
    }

    /**
     * Set products list
     * 
     * @param array $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * Build feeder
     */
    public function build()
    {
        $items = $this->formatter->format($this->products);
        dd($items);
    }
}
