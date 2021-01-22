<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class PurchaseFollowupEmail extends BaseModel
{
    use Sluggable;

    protected $table = 'purchase_followup_emails';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function storeRule()
    {
        $rule['title'] = 'required|max:191';
        $rule['content'] = 'required|max:6000';
        $rule['email_id'] = 'nullable|integer';

        return $rule;
    }

    public function storeEmail($request)
    {
        $status = $request->status ? 1 : 0;
        if ($request->email_id == null) {
            $email = $this;
        } else {
            $email = $this->find($request->email_id);
        }
        $email->title = $request->title;
        $email->content = $request->content;
        $email->status = $status;
        $email->save();

        return $email;
    }
}
