<?php

namespace App\Http\Controllers\Admin\DirectoryAds;

use App\Http\Controllers\Admin\AdminController;
use App\Models\DirectoryAdsPosition;
use App\Models\DirectoryAdsSpot;
use App\Models\DirectoryAdsType;
use App\Models\DirectoryCategory;
use App\Models\DirectoryTag;
use Illuminate\Http\Request;
use Validator;

class SpotController extends AdminController
{
    public function __construct(DirectoryAdsSpot $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $spots = $this->model->with('position', 'approvedPrices', 'directoryCategory', 'directoryTag')->get();

            $activeSpots = $spots->where('status', 1);
            $inactiveSpots = $spots->where('status', 0);

            $all = view('components.admin.directoryAdsSpot', [
                'spots' => $spots,
                'selector' => 'datatable-all',
            ])->render();

            $active = view('components.admin.directoryAdsSpot', [
                'spots' => $activeSpots,
                'selector' => 'datatable-active',
            ])->render();

            $inactive = view('components.admin.directoryAdsSpot', [
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

        return view(self::$viewDir.'directoryAds.spot');
    }

    public function create()
    {
        $categories = DirectoryCategory::where('parent_id', 0)
            ->with('approvedSubCategories')
            ->status(1)
            ->get(['id', 'name']);

        $tags = DirectoryTag::where('status', 1)
            ->get(['id', 'name']);

        $types = DirectoryAdsType::whereStatus(1)
            ->get();

        return view(self::$viewDir.'directoryAds.spotCreate', [
            'categories' => $categories,
            'tags' => $tags,
            'types' => $types,
        ]);
    }

    public function rulePosition($request)
    {
        $rule['position_type'] = 'required|in:fixed,perpage';
        if ($request->position_type == 'fixed') {
            return $rule;
        }

        $rule['type'] = 'required|in:home,category,tag,detail';
        if ($request->type == 'home') {
            return $rule;
        }

        $rule['page'] = 'required';

        return $rule;
    }

    public function getPosition(Request $request)
    {
        try {
            $position_type = $request->position_type;
            $type = $request->type;
            $page = $request->page;
            $item_id = $request->item_id;

            $validation = Validator::make($request->all(), $this->rulePosition($request));
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }

            if ($position_type == 'fixed') {
                $exclude_ids = $this->model->where('id', '!=', $item_id)
                    ->groupBy('position_id')
                    ->pluck('position_id')
                    ->toArray();

                $positions = DirectoryAdsPosition::whereStatus(1)
                    ->get(['id', 'name', 'image']);
            } else {
                if ($type === 'detail') {
                    $positions = DirectoryAdsPosition::whereType('ads')
                        ->whereStatus(1)
                        ->get(['id', 'name', 'image']);
                } else {
                    $positions = DirectoryAdsPosition::whereStatus(1)
                        ->get(['id', 'name', 'image']);
                }
                if ($type === 'home') {
                    $position_ids = $this->model->where('id', '!=', $item_id)
                        ->where('page', 'home')
                        ->pluck('position_id')
                        ->toArray();
                } else {
                    $position_ids = $this->model->where('id', '!=', $item_id)
                        ->where('page', $type)
                        ->where('page_id', $page)
                        ->pluck('position_id')
                        ->toArray();
                }
                $fixed_ids = $this->model->where('fixed_position', 1)
                    ->groupBy('position_id')
                    ->pluck('position_id')
                    ->toArray();

                $exclude_ids = array_merge($position_ids, $fixed_ids);
            }

            foreach ($positions as $position) {
                if (in_array($position->id, $exclude_ids)) {
                    $position->setAttribute('available', 0);
                } else {
                    $position->setAttribute('available', 1);
                }
            }

            return response()->json([
                'status' => 1,
                'data' => $positions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
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
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $spot = $this->model->storeItem($request);
            $url = route('admin.directoryAds.spot.edit', $spot->id).'#/price';

            return response()->json([
                'status' => 1,
                'data' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function edit($id)
    {
        $spot = $this->model->findorfail($id);

        if (request()->wantsJson()) {
            $prices = $spot->prices;
            $view = view('components.admin.directoryAdsPrice', compact('prices'))->render();

            return response()->json([
                'status' => 1,
                'data' => $view,
            ]);
        }

        $categories = DirectoryCategory::where('parent_id', 0)
            ->with('approvedSubCategories')
            ->status(1)
            ->get(['id', 'name']);

        $tags = DirectoryTag::where('status', 1)
            ->get(['id', 'name']);

        $types = DirectoryAdsType::whereStatus(1)
            ->get();

        return view(self::$viewDir.'directoryAds.spotEdit', [
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
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $spot = $this->model->findorfail($id)->storeItem($request);
            $url = route('admin.directoryAds.spot.edit', $spot->id).'#/price';

            return response()->json([
                'status' => 1,
                'data' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
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
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $price = $this->model->findorfail($id)
                ->createPrice($request);

            return response()->json([
                'status' => 1,
                'data' => $price,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
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

            return response()->json([
                'status' => 1,
                'data' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
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
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $spot->updateListing($request);

            return response()->json([
                'status' => 1,
                'data' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
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

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
