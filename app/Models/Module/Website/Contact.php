<?php

namespace App\Models\Module\Website;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
