<?php

namespace Domain\Catalog\ViewModels;


use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CategoryViewModel
{
    use Makeable;

    public function homePage()
    {
        return Cache::tags['category']->rememberForever('category_home_page', function (){
             Category::query()
                ->homePage()
                ->get();
        });

    }

}