<?php

namespace App\Providers;


use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use Carbon\Laravel\ServiceProvider;
use Domain\Catalog\Filters\FilterManager;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FilterManager::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter(),
        ]);
    }

}