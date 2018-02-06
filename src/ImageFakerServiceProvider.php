<?php

namespace Waynestate\ImageFaker;

use Waynestate\ImageFaker\ImageFaker;
use Illuminate\Support\ServiceProvider;

class ImageFakerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/image-faker.php', 'image-faker');

        $this->app->bind(ImageFaker::class, function ($app) {
            return new ImageFaker(config('image-faker'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__.'/../config/image-faker.php' => config_path('image-faker.php'),
        ], 'image-faker');
    }
}
