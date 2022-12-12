<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Support\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Brand
 * @method static Brand|BrandQueryBuilder query()
 * @package Domain\Catalog\Models
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'title',
        'thumbnail',
        'slug',
        'on_home_page',
        'sorting',
    ];

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected function thumbnailDir(): string
    {
        return 'brands';
    }
}
