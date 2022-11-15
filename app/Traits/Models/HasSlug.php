<?php
/**
 * Created by PhpStorm.
 * User: egoleva
 * Date: 24.10.22
 * Time: 8:30
 */

namespace App\Traits\Models;


use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
        });
    }

    protected function makeSlug():void
    {
        if(!$this->{$this->slugColumn()})
        {
            $slug = $this->slugUnique(
                str($this->{self::slugFrom()})
                    ->slug()
                    ->value()
            );

            $this->{$this->slugColumn()} = $this->{$this->slugColumn()} ?? $slug;
        }
    }

    public static function slugFrom():string
    {
        return 'title';
    }

    protected function slugColumn():string
    {
        return 'slug';
    }

    private function slugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 0;

        while($this->isSlugExists($slug))
        {
            $i++;
            $slug = $originalSlug . '-' . $i;
        }
        return $slug;
    }

    private function isSlugExists(string $slug): bool
    {
        $query = $this->newQuery()
            ->where(self::slugColumn(), $slug)
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->withoutGlobalScopes();

        return $query->exists();
    }
}