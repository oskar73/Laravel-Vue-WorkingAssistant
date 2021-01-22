<?php

namespace App\Models\Module;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EcommerceOrder extends BaseModel
{
    use HasFactory;

    protected $table = 'ecommerce_orders';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function items()
    {
        return $this->hasMany(EcommerceOrderItem::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(EcommerceCustomer::class);
    }

    public function payment()
    {
        return $this->belongsTo(EcommercePayment::class, 'order_id');
    }
}
