<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class StripeAccount extends BaseModel
{
    use HasFactory;

    protected $table = 'stripe_accounts';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
