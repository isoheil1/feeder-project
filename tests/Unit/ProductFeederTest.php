<?php

namespace Tests\Unit;

use Tests\TestCase;

class ProductFeederTest extends TestCase
{

    public function test_product_feed_pages()
    {
        $response = $this->get(route('feeds.export', ['merchant' => 'google', 'fileFormat' => 'json']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => ["pages", "merchant", "fileFormat", "perPage", "total"],
            "success"
        ]);
    }

    public function test_product_feed_google_json()
    {
        $response = $this->get(route('feeds.export', ['merchant' => 'google', 'fileFormat' => 'json', 'page' => 1]));
        $response->assertStatus(200);
    }

    public function test_product_feed_google_xml()
    {
        $response = $this->get(route('feeds.export', ['merchant' => 'google', 'fileFormat' => 'xml', 'page' => 1]));
        $response->assertHeader('content-type', 'application/xml');
        $response->assertStatus(200);
    }

    public function test_product_feed_facebook_json()
    {
        $response = $this->get(route('feeds.export', ['merchant' => 'facebook', 'fileFormat' => 'json', 'page' => 1]));
        $response->assertStatus(200);
    }

    public function test_product_feed_facebook_xml()
    {
        $response = $this->get(route('feeds.export', ['merchant' => 'facebook', 'fileFormat' => 'xml', 'page' => 1]));
        $response->assertHeader('content-type', 'application/xml');
        $response->assertStatus(200);
    }
}
