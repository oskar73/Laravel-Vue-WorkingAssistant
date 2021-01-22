<?php

namespace App\Models;

class ProductCoupon extends BaseModel
{
    protected $connection = 'mysql2';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault()->withoutGlobalScopes();
    }

    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id')->withoutGlobalScopes();
    }
}
