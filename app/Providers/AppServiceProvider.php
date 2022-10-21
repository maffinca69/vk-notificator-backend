<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
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
        $this->app->bind(ContainerInterface::class, Container::class);
    }
}
