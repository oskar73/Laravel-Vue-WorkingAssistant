<?php

namespace App\Http\Controllers\Admin\BlogAds;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BlogAdsPosition;
use App\Models\BlogAdsSpot;
use App\Models\BlogAdsType;
use App\Models\BlogTag;
use App\Models\Module\BlogCategory;
use Illuminate\Http\Request;
use Validator;

class SpotController extends AdminController
{
    public function __construct(BlogAdsSpot $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $spots = $this->model->with('position', 'approvedPrices', 'blogCategory', 'blogTag')->get();

            $activeSpots = $spots->where('status', 1);
            $inactiveSpots = $spots->where('status', 0);

            $all = view('components.admin.blogAdsSpot', [
                'spots' => $spots,
                'selector' => 'datatable-all',
            ])->render();

            $active = view('components.admin.blogAdsSpot', [
                'spots' => $activeSpots,
                'selector' => 'datatable-active',
            ])->render();

            $inactive = view('components.admin.blogAdsSpot', [
                'spots' => $inactiveSpots,
                'selector' => 'datatable-inactive',
            ])->render();

            $count['all'] = $spots->count();
            $count['active'] = $activeSpots->count();
            $count['inactive'] = $inactiveSpots->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'blogAds.spot');
    }

    public function create()
    {
        $categories = BlogCategory::whereStatus(1)
            ->select('id', 'name')
            ->get();

        $tags = BlogTag::whereStatus(1)
            ->select('id', 'name')
            ->get();

        $types = BlogAdsType::whereStatus(1)
            ->get();

        return view(self::$viewDir.'blogAds.spotCreate', [
            'categories' => $categories,
            'tags' => $tags,
            'types' => $types,
        ]);
    }

    public function rulePosition($request)
    {
        $rule['type'] = 'required|in:home,category,tag,detail';
        if ($request->type !== 'home') {
            $rule['page'] = 'required';
        }

        return $rule;
    }

    public function getPosition(Request $request)
    {
        try {
            $type = $request->type;
            $page = $request->page;

            $validation = Validator::make($request->all(), $this->rulePosition($request));

            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            if ($type == 'category' || $type == 'tag') {
                $positions = BlogAdsPosition::whereType('category')
                    ->select('id', 'name', 'image')
                    ->whereStatus(1)
                    ->get();
            } else {
                $positions = BlogAdsPosition::whereType($type)
                    ->select('id', 'name', 'image')
                    ->whereStatus(1)
                    ->get();
            }

            if ($type === 'home') {
                $position_ids = $this->model->where('page', 'home')
                    ->pluck('position_id')
                    ->toArray();
            } else {
                $position_ids = $this->model->where('page', $type)
                    ->where('page_id', $page)
                    ->pluck('position_id')
                    ->toArray();
            }

            foreach ($positions as $position) {
                if (in_array($position->id, $position_ids)) {
                    $position->setAttribute('available', 0);
                } else {
                    $position->setAttribute('available', 1);
                }
            }

            return $this->jsonSuccess($positions);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->createRule($request),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );

            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $spot = $this->model->storeItem($request);
            $url = route('admin.blogAds.spot.edit', $spot->id).'#/price';

            return $this->jsonSuccess($url);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function edit($id)
    {
        $spot = $this->model->findorfail($id);

        if (request()->wantsJson()) {
            $prices = $spot->prices;
            $view = view('components.admin.blogAdsPrice', compact('prices'))->render();

            return $this->jsonSuccess($view);
        }
        $categories = BlogCategory::whereStatus(1)
            ->select('id', 'name')
            ->get();

        $tags = BlogTag::whereStatus(1)
            ->select('id', 'name')
            ->get();

        $types = BlogAdsType::whereStatus(1)
            ->get();

        return view(self::$viewDir.'blogAds.spotEdit', [
            'spot' => $spot,
            'categories' => $categories,
            'tags' => $tags,
            'types' => $types,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->createRule($request),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );
            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $spot = $this->model->findorfail($id)->storeItem($request);
            $url = route('admin.blogAds.spot.edit', $spot->id).'#/price';

            return $this->jsonSuccess($url);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function createPrice(Request $request, $id)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->createPriceRule($request)
            );
            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $price = $this->model->findorfail($id)
                ->createPrice($request);

            return $this->jsonSuccess($price);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function deletePrice(Request $request, $id)
    {
        try {
            $price = $this->model->find($id)
                ->prices()
                ->where('id', $request->id)
                ->firstorfail();

            $price->delete();

            return $this->jsonSuccess($id);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function updateListing(Request $request, $id)
    {
        try {
            $spot = $this->model->findorfail($id);

            $validation = Validator::make(
                $request->all(),
                $spot->updateListingRule($request)
            );

            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $spot->updateListing($request);

            return $this->jsonSuccess();
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function switchSpot(Request $request)
    {
        try {
            $action = $request->action;

            if ($action === 'active') {
                $this->model->whereIn('id', $request->ids)->update(['status' => 1]);
            } elseif ($action === 'inactive') {
                $this->model->whereIn('id', $request->ids)->update(['status' => 0]);
            } elseif ($action === 'featured') {
                $this->model->whereIn('id', $request->ids)->update(['featured' => 1]);
            } elseif ($action === 'unfeatured') {
                $this->model->whereIn('id', $request->ids)->update(['featured' => 0]);
            } elseif ($action === 'visible') {
                $this->model->whereIn('id', $request->ids)->update(['sponsored_visible' => 1]);
            } elseif ($action === 'invisible') {
                $this->model->whereIn('id', $request->ids)->update(['sponsored_visible' => 0]);
            } elseif ($action === 'new') {
                $this->model->whereIn('id', $request->ids)->update(['new' => 1]);
            } elseif ($action === 'undonew') {
                $this->model->whereIn('id', $request->ids)->update(['new' => 0]);
            } elseif ($action === 'delete') {
                $this->model->whereIn('id', $request->ids)->get()->each->delete();
            }

            return $this->jsonSuccess();
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
}
