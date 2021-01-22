<?php

namespace App\Traits;

use App\Models\PurchaseFollowupEmail;
use App\Models\PurchaseFollowupForm;

trait Formable
{
    public static $updateFormValidationCustomMessage = [

    ];

    public function getUpdateFormValidatoinCustomMessgae()
    {
        return self::$updateFormValidationCustomMessage;
    }

    public function getForm()
    {
        return $this->belongsTo(PurchaseFollowupForm::class, 'form_id')->withDefault();
    }

    public function getEmail()
    {
        return $this->belongsTo(PurchaseFollowupEmail::class, 'email_id')->withDefault();
    }

    public function updateFormRule($request)
    {
        $rule = [];
        if ($request->form) {
            $rule['followupEmail'] = 'required|integer';
            $rule['followupForm'] = 'required|integer';
        }

        return $rule;
    }

    public function updateForm($request)
    {
        $item = $this;
        $item->form = $request->form ? 1 : 0;
        if ($request->form) {
            $item->email_id = $request->followupEmail;
            $item->form_id = $request->followupForm;
        } else {
            $item->email_id = null;
            $item->form_id = null;
        }
        $item->save();

        return $item;
    }
}
