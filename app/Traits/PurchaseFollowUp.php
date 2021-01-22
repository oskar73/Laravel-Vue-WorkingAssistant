<?php

namespace App\Traits;

use App\Models\PurchaseFollowupEmail;
use App\Models\PurchaseFollowupForm;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait PurchaseFollowUp
{
    public function purchaseEmail(): BelongsTo
    {
        return $this->belongsTo(PurchaseFollowupEmail::class, 'email_id')
            ->withDefault();
    }

    public function purchaseForm(): BelongsTo
    {
        return $this->belongsTo(PurchaseFollowupForm::class, 'form_id')
            ->withDefault();
    }
}
