<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Category
 * @method static Category|CategoryQueryBuilder query()
 * @package Domain\Catalog\Models
 */
class Category extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'on_home_page',
        'sorting',
    ];

    public function newCollection(array $models = [])
    {
        return new CategoryCollection($models);
    }

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
