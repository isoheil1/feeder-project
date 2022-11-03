<?php

namespace App\Providers;

use App\Contracts\FeedBuilder;
use App\Services\Feed\JsonFeedBuilder;
use App\Services\Feed\XMLFeedBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(FeedBuilder::class, JsonFeedBuilder::class);
        // $this->app->bind(FeedBuilder::class, XMLFeedBuilder::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
