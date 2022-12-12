<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke(?Category $category)
    {
        $categories = Category::query()
            ->select(['id', 'title', 'slug'])
            ->has('products')
            ->get();

        $products = Product::search(request('s'))
            ->query(function (\Illuminate\Database\Eloquent\Builder $query) use ($category) {

                $query->select(['id', 'title', 'slug', 'price', 'thumbnail'])
                    ->when($category->exists, function (\Illuminate\Database\Eloquent\Builder $query) use($category){
                        $query->whereRelation(
                            'categories',
                            'categories.id',
                            '=',
                            $category->id);
                    })
                    //вариант без scout
                    /*    ->when(request('s'), function(\Illuminate\Database\Eloquent\Builder $query){
                            $query->whereFullText(['title','text'], request('s'));
                    })*/
                    ->filtered()
                    ->sorted();

            })
            //->with('brand')
            ->paginate(6);

        /*$brands = Brand::query()
            ->select(['id', 'title'])
            ->has('products')
            ->get();*/

        return view('catalog.index',
           [
               'products' => $products,
               'categories' => $categories,
               //'brands' => $brands,
               'category' => $category,
           ]
        );
    }
}
