<?php

namespace App\Providers;

use App\Routing\AppRegistrar;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Routing\AuthRegistrar;
use Whoops\Exception\ErrorException;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    protected $registrars = [
            AppRegistrar::class,
            AuthRegistrar::class,
    ];

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function (Registrar $router){
            $this->mapRoutes($router, $this->registrars);
        });

        /*$this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });*/
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapRoutes(Registrar $router, array $registrars):void
    {
        foreach ($registrars as $registrar)
        {
            //TODO
            //TODO RuntimeException
           /* if(!class_exists($registrar) || !is_subclass_of($registrar, RouteRegistrar::class))
            {
               // print $registrar;die();
                throw new ErrorException(sprintf(
                    'Cannot map routes \'%s\', it is not valid routes class',
                    $registrar
                ));
            }*/

            (new $registrar)->map($router);
        }
    }
}
