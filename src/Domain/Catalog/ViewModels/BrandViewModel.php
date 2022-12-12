<?php

namespace Domain\Catalog\ViewModels;


use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class BrandViewModel
{
    use Makeable;

    public function homePage()
    {
        //куда то делся кеш
        return Brand::query()
            ->homePage()
            ->get();
        //tags not found in this version return Cache::tags['category']->rememberForever('category_home_page', function (){
        return Cache::rememberForever('brand_home_page', function (){
             Brand::query()
                ->homePage()
                ->get();
        });

    }

}