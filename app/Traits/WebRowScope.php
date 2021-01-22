<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WebRowScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getTable().'.web_id', tenant('id') ?? 0);
    }
}
