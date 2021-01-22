<?php

namespace App\Models;

class SiteAdsType extends BaseModel
{
    protected $table = 'site_ads_types';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function storeRule()
    {
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'max:6000';
        $rule['width'] = 'required|integer|min:50|max:2048';
        $rule['height'] = 'required|integer|min:50|max:2048';
        $rule['title_char'] = 'required|integer|max:255';
        $rule['text_char'] = 'required|integer|max:255';

        return $rule;
    }

    public function storeItem($request)
    {
        $type = $this;
        $type->name = $request->name;
        $type->description = $request->description;
        $type->width = $request->width;
        $type->height = $request->height;
        $type->title_char = $request->title_char;
        $type->text_char = $request->text_char;
        $type->status = $request->status ? 1 : 0;
        $type->save();

        return $type;
    }

    public function checkInit()
    {
        $siteAds = option('siteAds', null);

        if (optional($siteAds)['type'] != 1) {
            $types = \DB::table('site_ads_types')->where('web_id', 0)->where('status', 1)->get();
            foreach ($types as $type) {
                self::create(collect($type)->toArray());
            }
            $siteAds['type'] = 1;
            option(['siteAds' => $siteAds]);
        }

        return $this;
    }

    public function spots()
    {
        return $this->hasMany(SiteAdsSpot::class, 'type_id');
    }
}
