<?php

namespace App\Http\Controllers\User;

use App\Models\DirectoryCategory;
use App\Models\DirectoryListing;
use App\Models\DirectoryTag;
use App\Models\UserDirectoryPackage;
use Illuminate\Http\Request;
use Validator;

class DirectoryController extends UserController
{
    public function __construct(DirectoryListing $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getUserDataTable();
        }

        return view(self::$viewDir.'directory.index');
    }

    public function select()
    {
        $setting = optional(option('directory'));
        if ($setting['permission'] == null || $setting['permission'] == 'not') {
            return back()->with('info', 'Sorry we are not accepting any directory listing at this time.');
        }

        $packages = UserDirectoryPackage::where('user_id', user()->id)
            ->orderBy('status')
            ->get(['id', 'listing_number', 'current_number', 'item', 'status']);

        $free_count = user()->directoryListings->whereNull('purchase_id')->count();

        return view(self::$viewDir.'directory.select', compact('packages', 'setting', 'free_count'));
    }

    public function create($id)
    {
        $setting = optional(option('directory'));
        if ($setting['permission'] == null || $setting['permission'] == 'not') {
            return back()->with('info', 'Sorry we are not accepting any directory listing at this time.');
        }

        if ($id == 0) {
            if ($setting['permission'] == 'paid') {
                return back()->with('info', 'Sorry we are accepting only paid listings now.');
            } else {
                $free_count = user()->directoryListings->whereNull('purchase_id')->count();

                if ($setting['listing_number'] != -1 && ($setting['listing_number'] - $free_count) < 1) {
                    return back()->with('info', 'Sorry you are going to exceed free listing limit. Please purchase package for more listings.');
                }

                $property['thumbnail'] = $setting['thumbnail'];
                $property['social'] = $setting['social'];
                $property['featured'] = $setting['featured'];
                $property['image'] = $setting['image'];
                $property['links'] = $setting['links'];
                $property['videos'] = $setting['videos'];
                $property['tracking'] = $setting['tracking'];
            }
        } else {
            $package = UserDirectoryPackage::where('user_id', user()->id)
                ->whereId($id)
                ->firstorfail();
            if (! $package->isPossibleforListing()) {
                return back()->with('error', 'Well, this package status is not active.');
            }

            $packageProperty = $package->getProperty();
            $property['thumbnail'] = $packageProperty->thumbnail;
            $property['social'] = $packageProperty->social;
            $property['featured'] = $packageProperty->featured;
            $property['image'] = $packageProperty->image;
            $property['links'] = $packageProperty->links;
            $property['videos'] = $packageProperty->videos;
            $property['tracking'] = $packageProperty->tracking;
        }
        $categories = DirectoryCategory::where('parent_id', 0)
            ->with('approvedSubCategories.approvedTags', 'approvedTags')
            ->status(1)
            ->get(['id', 'name']);

        $tags = DirectoryTag::whereStatus(1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view(self::$viewDir.'directory.create', compact('property', 'id', 'categories', 'tags'));
    }

    public function store(Request $request, $id)
    {
        $setting = optional(option('directory'));
        if ($setting['permission'] == null || $setting['permission'] == 'not') {
            return $this->jsonError(['Sorry we are accepting only paid listings now.']);
        }

        if ($id == 0) {
            if ($setting['permission'] == 'paid') {
                return $this->jsonError(['Sorry we are accepting only paid listings now. You are trying to post as a free listing.']);
            } else {
                $free_count = user()->directoryListings->whereNull('purchase_id')->count();

                if ($setting['listing_number'] != -1 && ($setting['listing_number'] - $free_count) < 1) {
                    return $this->jsonError(['Sorry you are going to exceed free listing limit. Please purchase package for more listings.']);
                }

                $property['thumbnail'] = $setting['thumbnail'];
                $property['social'] = $setting['social'];
                $property['featured'] = $setting['featured'];
                $property['image'] = $setting['image'];
                $property['links'] = $setting['links'];
                $property['videos'] = $setting['videos'];
                $property['tracking'] = $setting['tracking'];
            }
        } else {
            $package = UserDirectoryPackage::where('user_id', user()->id)
                ->whereId($id)
                ->firstorfail();
            if (! $package->isPossibleforListing()) {
                return back()->with('error', 'Well, this package status is not active.');
            }

            $packageProperty = $package->getProperty();
            $property['thumbnail'] = $packageProperty->thumbnail;
            $property['social'] = $packageProperty->social;
            $property['featured'] = $packageProperty->featured;
            $property['image'] = $packageProperty->image;
            $property['links'] = $packageProperty->links;
            $property['videos'] = $packageProperty->videos;
            $property['tracking'] = $packageProperty->tracking;
        }

        $validation = Validator::make(
            $request->all(),
            $this->model->storeUserRule($property),
            $this->model::CUSTOM_VALIDATION_MESSAGE
        );
        if ($validation->fails()) {
            return $this->jsonError($validation->errors());
        }

        $item = $this->model->storeUserItem($request, $property, $setting['listing_approve'], $id);

        //send notification here.
        return $this->jsonSuccess();
    }

    public function edit($slug)
    {
        $listing = $this->model->where('slug', $slug)
            ->where('user_id', user()->id)
            ->firstorfail();

        $categories = DirectoryCategory::where('parent_id', 0)
            ->with('approvedSubCategories.approvedTags', 'approvedTags')
            ->status(1)
            ->get(['id', 'name']);

        $tags = DirectoryTag::whereStatus(1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view(self::$viewDir.'directory.edit', compact('categories', 'listing', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $listing = $this->model->whereId($id)
            ->my()
            ->firstorfail();

        $validation = Validator::make(
            $request->all(),
            $listing->updateUserRule(),
            $this->model::CUSTOM_VALIDATION_MESSAGE
        );
        if ($validation->fails()) {
            return $this->jsonError($validation->errors());
        }

        $setting = optional(option('directory'));

        $item = $listing->updateUserItem($request, $setting['listing_approve']);

        return $this->jsonSuccess();
    }
}
