<?php

namespace App\Models\Module;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EcommerceCustomer extends BaseModel
{
    use HasFactory;

    protected $table = 'ecommerce_customers';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function orders()
    {
        return $this->hasMany(EcommerceOrder::class, 'customer_id');
    }

    public function payments()
    {
        return $this->hasMany(EcommercePayment::class, 'customer_id');
    }
}
