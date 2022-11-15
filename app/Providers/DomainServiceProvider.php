<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Auth\Providers;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register():void
    {
        $this->app->register(Providers\AuthServiceProvider::class);
        $this->app->register(Providers\ActionsServiceProvider::class);
    }

}
