<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke(Product $product)
    {
        $product->load(['optionValues.option']);

        $options = $product->optionValues->mapToGroups(function ($item){
            return [$item->option->title => $item];
        });

        $also = (session()->get('also'))
            ? Product::query()
                ->where(function ($q) use ($product){
                    $q->whereIn('id', session('also'))
                        ->where('id', '!=', $product->id);
                })
                ->get()
            : null;

        session()->put('also.' . $product->id, $product->id);

        return view(
        'product.show',
               [
                   'product' => $product,
                   'options' => $options,
                   'also' => $also,
               ]
            );
    }
}
