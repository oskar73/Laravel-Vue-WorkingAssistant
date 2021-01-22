<?php

namespace App\Models;

class ProductAdditionalPrice extends BaseModel
{
    protected $connection = 'mysql2';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function additionals()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }
}
