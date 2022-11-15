<?php

namespace Domain\Auth\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Actions\RegisterNewUserAction;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
            RegisterNewUserContract::class => RegisterNewUserAction::class
        ];
}
