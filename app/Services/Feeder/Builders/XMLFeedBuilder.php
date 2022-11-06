<?php

namespace App\Services\Feeder\Builders;

use App\Contracts\FeedBuilder;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

class XMLFeedBuilder implements FeedBuilder
{
    private array $items;

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function getContentType(): string
    {
        return "application/xml";
    }

    public function build(): mixed
    {
        $xml = simplexml_load_string('<?xml version="1.0"?><rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"><channel></channel></rss>');

        foreach ($this->items as $item) {

            $xmlItem = $xml->channel->addChild("item");

            foreach ($item as $key => $value) {
                $xmlItem->addChild("xmlns:g:$key", $value);
            }
        }

        return $xml->asXML();
    }
}
