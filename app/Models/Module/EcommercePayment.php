<?php

namespace App\Models\Module;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EcommercePayment extends BaseModel
{
    use HasFactory;

    protected $table = 'ecommerce_payments';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo(EcommerceOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(EcommerceCustomer::class);
    }
}
