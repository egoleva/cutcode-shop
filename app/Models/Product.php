<?php

namespace App\Models;

use Domain\Catalog\Models\Category;
use Illuminate\Pipeline\Pipeline;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'price',
        'brand_id',
        'on_home_page',
        'sorting',
        'text',
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    #[SearchUsingPrefix(['id'])]
    #[SearchUsingFullText(['title', 'text'])]
    public function toSearchableArray()
    {
        return [
            //'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
        ];
    }

    /**
     * @param Builder $query
     */
    public function scopeFiltered(Builder $query)
    {
        /* Filter scope realization
        $query->when(request('filters.brands'), function(Builder $q){

                $q->whereIn('brand_id', request('filters.brands'));

            })
            ->when(request('filters.price'), function(Builder $q){

                $q->whereBetween('price', [
                        request('filter.price.from', 0) * 100,
                        request('filter.price.to', 100000) * 100
                    ]
                );

        });*/

        //2 вариант
        /*foreach (filters() as $filter)
        {
            $query = $filter->apply($query);
        }*/

        return app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();
    }

    /**
     * @param Builder $query
     */
    public function scopeSorted(Builder $query)
    {
        $query->when(request('sort'), function(Builder $q){

            $column = request()->str('sort');

            if($column->contains(['price', 'title']))
            {
                $direction = $column->contains('-') ? 'DESC' : 'ASC';
                $q->orderBy((string) $column->remove('-'), $direction);
            }
        });
    }

    /**
     * @param Builder $query
     */
    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(10);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    protected function thumbnailDir(): string
    {
        return 'products';
    }
}
