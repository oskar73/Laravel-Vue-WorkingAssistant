<?php

namespace App\Models\Module;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EcommerceColor extends BaseModel
{
    use HasFactory;

    protected $table = 'ecommerce_colors';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];
}
