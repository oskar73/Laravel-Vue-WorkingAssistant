<?php

namespace App\Http\Controllers\Admin\Directory;

use App\Http\Controllers\Admin\AdminController;
use App\Models\DirectoryCategory;
use App\Models\DirectoryListing;
use App\Models\DirectoryTag;
use Illuminate\Http\Request;
use Validator;

class ListingController extends AdminController
{
    public function __construct(DirectoryListing $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'), request()->get('user'));
        }

        return view(self::$viewDir.'directory.listing');
    }

    public function create()
    {
        $categories = DirectoryCategory::where('parent_id', 0)
            ->with('approvedSubCategories.approvedTags', 'approvedTags')
            ->status(1)
            ->get(['id', 'name']);

        $tags = DirectoryTag::whereStatus(1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view(self::$viewDir.'directory.listingCreate', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->storeRule($request),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );

            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            if ($request->listing_id) {
                $item = $this->model->findorfail($request->listing_id)
                    ->updateItem($request);
            } else {
                $item = $this->model->storeItem($request);
            }

            return response()->json([
                'status' => 1,
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function edit($slug)
    {
        $listing = $this->model->where('slug', $slug)->firstorfail();
        $categories = DirectoryCategory::where('parent_id', 0)
            ->with('approvedSubCategories.approvedTags', 'approvedTags')
            ->status(1)
            ->get(['id', 'name']);

        $tags = DirectoryTag::whereStatus(1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view(self::$viewDir.'directory.listingEdit', compact('categories', 'listing', 'tags'));
    }
}
