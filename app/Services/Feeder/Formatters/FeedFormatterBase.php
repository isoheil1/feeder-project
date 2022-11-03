<?php

namespace App\Services\Feeder\Formatters;

use App\Exceptions\Feeder\ValidationException;

abstract class FeedFormatterBase
{

    /**
     * The list of required keys
     *
     * @var array
     */
    protected array $required;

    /**
     * The list of optional keys
     *
     * @var array
     */
    protected array $optional;

    /**
     * The list of formatted items
     *
     * @var array
     */
    private $formattedItems = [];

    /**
     * The list of items
     *
     * @var array
     */
    public $items;


    public function format(array $items)
    {
        $this->items = $items;

        self::checkRequiredItems();
        self::fiterItems();
    }

    /**
     * Check needed keys 
     * 
     * @throws \App\Exceptions\Feeder\ValidationException
     */
    private function checkRequiredItems(): void
    {
        foreach ($this->items as $item) {
            foreach ($this->required as $require) {
                if (array_key_exists($require, $item) == false) {
                    throw new ValidationException("The $require field is required.");
                }
            }
        }
    }

    /**
     * Filter and rename keys
     */
    private function fiterItems()
    {
    }
}
