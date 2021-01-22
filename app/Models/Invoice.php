<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends BaseModel
{
    use HasFactory;

    protected $table = 'invoices';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id')->withDefault();
    }

    public function sendNotification()
    {
        \Log::info('invoice-notification');
    }
}
