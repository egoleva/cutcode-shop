<?php

namespace App\Providers;

use Domain\Catalog\Providers\CatalogServiceProvider;
use Illuminate\Support\ServiceProvider;
use Domain\Auth\Providers\AuthServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register():void
    {
        $this->app->register(CatalogServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
    }

}
