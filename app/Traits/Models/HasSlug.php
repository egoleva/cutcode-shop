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
            $item->slug = $item->slug
                ?? str($item->{self::slugFrom()})
                    ->append(time())
                    ->slug();
        });
    }

    public static function slugFrom():string
    {
        return 'title';
    }
}