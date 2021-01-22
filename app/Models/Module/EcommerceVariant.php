<?php

namespace App\Models\Module;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EcommerceVariant extends BaseModel
{
    use HasFactory;

    protected $table = 'ecommerce_variants';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];
}
