<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use App\Models\Product;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        $categories = CategoryViewModel::make()->homePage();

        $brands = BrandViewModel::make()->homePage();

        $products = Product::query()
            ->homePage()
            ->get();

        return view('index',
            compact(
                'categories',
                'brands',
                'products'
            ));
    }
}
