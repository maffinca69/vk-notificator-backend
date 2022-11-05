<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;
use Laravel\Lumen\Application;
use Psr\Container\ContainerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Translator::class, static function (Application $app) {
            return $app->make('translator');
        });

        $this->app->bind(ContainerInterface::class, Container::class);
    }
}
