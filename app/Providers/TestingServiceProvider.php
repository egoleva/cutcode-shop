<?php
/**
 * Created by PhpStorm.
 * User: egoleva
 * Date: 04.11.22
 * Time: 5:49
 */

namespace App\Providers;

use \Support\Testing\FakerImageProvider;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;


class TestingServiceProvider extends ServiceProvider
{
    public function register():void
    {
        $this->app->singleton(Generator::class, function()
        {
            $faker = Factory::create();
            $faker->addProvider(new FakerImageProvider($faker));

            return $faker;
        });
    }

    public function boot():void
    {

    }

}