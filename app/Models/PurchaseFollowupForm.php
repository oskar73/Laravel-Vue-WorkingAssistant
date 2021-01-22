<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class PurchaseFollowupForm extends BaseModel
{
    use Sluggable;

    protected $table = 'purchase_followup_forms';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function storeForm($request)
    {
        if ($request->id) {
            $form = $this->findorfail($request->id);
        } else {
            $form = $this;
        }
        $form->name = $request->name;
        $form->content = $request->form_builder_json;
        $form->status = $request->status == 1 ? 1 : 0;
        $form->save();

        return $form;
    }
}
