<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirectoryAdsPosition extends BaseModel
{
    use Sluggable;
    use HasFactory;

    protected $table = 'directory_ads_positions';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

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
            $path = config('custom.storage_name.directoryAds');

            $imgName = "directory-ads-position-{$this->position_id}.".$request->image->getClientOriginalExtension();

            $position->image = BaseModel::fileUpload($request->image, $imgName, $path);
        }
        $position->status = $request->status ? 1 : 0;
        $position->save();

        return $position;
    }

    public function checkInit()
    {
        $blogAds = option('directoryAds', null);

        if (optional($blogAds)['position'] != 1) {
            $types = \DB::table('directory_ads_positions')->where('web_id', 0)->where('status', 1)->get();
            foreach ($types as $type) {
                self::create(collect($type)->toArray());
            }
            $blogAds['position'] = 1;
            option(['directoryAds' => $blogAds]);
        }

        return $this;
    }
}
