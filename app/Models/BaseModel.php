<?php

namespace App\Models;

use App\Traits\WebRowTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BaseModel extends Model
{
    use Cachable;
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
        $storage = Storage::disk('s3-pub-bizinasite');

        if ($path == null) {
            $storage->putFileAs('', $file, $name);
            $file_url = $name;
        } else {
            if (! $storage->exists($path)) {
                $storage->makeDirectory($path);
            }
            $storage->putFileAs($path, $file, $name);
            $file_url = $path.'/'.$name;
        }

        return $storage->url($file_url);
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
