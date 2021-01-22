<?php

namespace App\Models;

use App\Traits\WebRowTrait;
use Illuminate\Database\Eloquent\Model;
use Storage;

class StaticBaseModel extends Model
{
    use WebRowTrait;

    public function scopeMy($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeWebRow($query)
    {
        return $query->where('web_id', tenant('id'));
    }

    public function findBySlug($slug)
    {
        return $this->where('slug', $slug)->firstorfail();
    }

    public static function fileUpload($file, $name, $path = null)
    {
        if (tenant()->isStorageLimited()) {
            abort(403);
        }

        if ($path == null) {
            Storage::putFileAs('', $file, $name);
            $file_url = $name;
        } else {
            if (! Storage::exists($path)) {
                Storage::makeDirectory($path);
            }
            Storage::putFileAs($path, $file, $name);
            $file_url = $path.'/'.$name;
        }

        return Storage::url($file_url);
    }

    public function getLinks()
    {
        if ($this->links !== null) {
            return json_decode($this->links);
        } else {
            return [];
        }
    }

    public function nameToUserProduct($item)
    {
        if ($item == 'blog') {
            return \App\Models\UserBlogPackage::class;
        } elseif ($item == 'blogPackage') {
            return \App\Models\UserBlogPackage::class;
        } elseif ($item == 'directoryPackage') {
            return \App\Models\UserDirectoryPackage::class;
        } elseif ($item == 'blogAds') {
            return \App\Models\BlogAdsListing::class;
        } elseif ($item == 'siteAds') {
            return \App\Models\SiteAdsListing::class;
        } elseif ($item == 'directoryAds') {
            return \App\Models\DirectoryAdsListing::class;
        } elseif ($item == 'ecommerce') {
            return \App\Models\UserEcommerceProduct::class;
        }
    }

    public function userModelToName($item)
    {
        if ($item == \App\Models\UserBlogPackage::class) {
            return 'Blog package';
        } elseif ($item == \App\Models\UserDirectoryPackage::class) {
            return 'Directory Package';
        } else {
            return '';
        }
    }
}
