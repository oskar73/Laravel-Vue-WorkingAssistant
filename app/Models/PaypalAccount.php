<?php

namespace App\Models;

class PaypalAccount extends BaseModel
{
    protected $table = 'paypal_accounts';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
