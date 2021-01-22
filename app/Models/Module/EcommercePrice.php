<?php

namespace App\Models\Module;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EcommercePrice extends BaseModel
{
    use HasFactory;

    protected $table = 'ecommerce_prices';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];
}
