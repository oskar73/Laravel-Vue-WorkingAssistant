<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuickTour extends BaseModel
{
    use HasFactory;

    protected $table = 'quick_tours';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [
        'targetID.required' => 'The targetID field is required.',
    ];

    public function storeRule()
    {
        $rule['title'] = 'required|string|max:45';
        $rule['description'] = 'required|max:600';
        $rule['targetID'] = 'required|string|max:45';

        return $rule;
    }

    public function storeItem($request)
    {
        if ($request->item_id == null) {
            $item = $this;
        } else {
            $item = $this->findorfail($request->item_id);
        }
        $item->title = $request->title;
        $item->description = $request->description;
        $item->targetID = $request->targetID;
        $item->order = $item->order ?? ($this->max('order') + 1); // Get max order value and increase it by 1
        $item->status = $request->status ? 1 : 0;
        $item->save();

        return $item;
    }

    public function getTargetIDs()
    {
        return [
            'my-todo-list' => 'My Todo List',
            'dashboard' => 'Dashboard',
            'blog-posts' => 'Blog Posts',
            'blog-ads-listings' => 'Blog Ads Listings',
            'site-ads-listings' => 'Site Ads Listings',
            'directory-listings' => 'Directory Listings',
            'directory-ads-listings' => 'Directory Ads Listings',
            'ecommerce-products' => 'Ecommerce Products',
            'appointments' => 'Appointments',
            'tickets' => 'Tickets',
            'purchase-management' => 'Purchase Management',
            'log-out' => 'Log Out',
        ];
    }
}
