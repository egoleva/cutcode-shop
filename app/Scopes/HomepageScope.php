<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HomepageScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $model->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(10);
    }
}
