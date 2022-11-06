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
     * The list of keys which need to rename
     *
     * @var array
     */
    protected array $rename;

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


    /**
     * Format Keys
     *
     * @param array $items
     * @return array
     */
    public function format(array $items)
    {
        $this->items = $items;

        self::checkRequiredItems();
        self::fiterItems();

        return $this->formattedItems;
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
    private function fiterItems(): void
    {
        $allKeys = array_merge($this->required, $this->optional);

        foreach ($this->items as $item) {

            $formatted_item = array();

            foreach ($item as $key => $value) {
                if (in_array($key, $allKeys)) {
                    $key = $this->needToRename($key) ? $this->rename[$key] : $key;
                    $formatted_item[$key] = $value;
                }
            }

            $this->formattedItems[] = $formatted_item;
        }
    }


    /**
     * Determine if the given key need to rename
     *
     * @param string $key
     * @return bool
     */
    private function needToRename($key): bool
    {
        return array_key_exists($key, $this->rename);
    }
}
