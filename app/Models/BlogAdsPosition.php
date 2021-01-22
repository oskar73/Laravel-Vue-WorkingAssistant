<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class BlogAdsPosition extends BaseModel
{
    use Sluggable;

    protected $table = 'blog_ads_positions';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function getTypeNameAttribute()
    {
        if ($this->type == 'home') {
            return 'Blog Home Page';
        } elseif ($this->type == 'category') {
            return 'Category & Tag Home Page';
        } elseif ($this->type == 'detail') {
            return 'Blog Detail Page';
        }
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function storeRule()
    {
        $rule['name'] = 'required|max:191';
        $rule['position_id'] = 'required';
        $rule['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240';

        return $rule;
    }

    public function storeItem($request)
    {
        $position = $this;
        $position->name = $request->name;
        if ($request->image) {
            $path = config('custom.storage_name.blogAds');

            $imgName = "blog-ads-position-{$this->position_id}.".$request->image->getClientOriginalExtension();

            $position->image = BaseModel::fileUpload($request->image, $imgName, $path);
        }
        $position->status = $request->status ? 1 : 0;
        $position->save();

        return $position;
    }

    public function checkInit()
    {
        $blogAds = option('blogAds', null);

        if (optional($blogAds)['position'] != 1) {
            $types = \DB::table('blog_ads_positions')->where('web_id', 0)->where('status', 1)->get();
            foreach ($types as $type) {
                self::create(collect($type)->toArray());
            }
            $blogAds['position'] = 1;
            option(['blogAds' => $blogAds]);
        }

        return $this;
    }
}
