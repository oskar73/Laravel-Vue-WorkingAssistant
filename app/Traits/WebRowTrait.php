<?php

namespace App\Traits;

trait WebRowTrait
{
    public static function bootWebRowTrait()
    {
        static::addGlobalScope(new WebRowScope());
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($obj) {
            $obj->web_id = tenant('id') ?? 0;
        });
    }
}
