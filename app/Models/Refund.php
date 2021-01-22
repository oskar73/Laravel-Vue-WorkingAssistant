<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refund extends BaseModel
{
    use HasFactory;

    protected $table = 'refunds';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
