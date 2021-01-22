<?php

namespace App\Http\Controllers\Admin\Directory;

use App\Http\Controllers\Admin\AdminController;
use App\Models\AppointmentCategory;
use App\Models\AvailableWeekday;
use App\Models\DirectoryPackage;
use App\Models\PurchaseFollowupEmail;
use App\Models\PurchaseFollowupForm;
use Illuminate\Http\Request;
use Validator;

class PackageController extends AdminController
{
    public function __construct(DirectoryPackage $model)
    {
        $this->model = $model;
        $this->sortModel = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $items = $this->model->with(['media', 'approvedPrices'])
                ->latest()
                ->get();
            $activeItems = $items->where('status', 1);
            $inactiveItems = $items->where('status', 0);

            $all = view('components.admin.directoryPackage', [
                'items' => $items,
                'selector' => 'datatable-all',
            ])->render();
            $active = view('components.admin.directoryPackage', [
                'items' => $activeItems,
                'selector' => 'datatable-active',
            ])->render();
            $inactive = view('components.admin.directoryPackage', [
                'items' => $inactiveItems,
                'selector' => 'datatable-inactive',
            ])->render();

            $count['all'] = $items->count();
            $count['active'] = $activeItems->count();
            $count['inactive'] = $inactiveItems->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'directory.package');
    }

    public function create()
    {
        return view(self::$viewDir.'directory.packageCreate');
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->storeRule($request));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = $this->model->storeItem($request);
            $route = route('admin.directory.package.edit', $item->id).'#/price';

            return response()->json([
                'status' => 1,
                'data' => $route,
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
        if (request()->wantsJson()) {
            $prices = $this->model->findorfail($id)->prices;
            $data = view('components.admin.packagePrice', compact('prices'))->render();

            return response()->json([
                'status' => 1,
                'data' => $data,
            ]);
        }
        $item = $this->model->with('media', 'purchaseForm', 'purchaseEmail')
            ->where('id', $id)
            ->firstorfail();

        $followEmails = PurchaseFollowupEmail::whereStatus(1)
            ->get(['id', 'title', 'content']);

        $followForms = PurchaseFollowupForm::whereStatus(1)
            ->get(['id', 'name', 'content']);

        $appCats = AppointmentCategory::where('status', 1)
            ->get(['id', 'name']);

        $meetingSet = $item->meetingSet;

        $availableWeek = new AvailableWeekday();
        $data = $availableWeek->getData(get_class($this->model), $item->id);
        $weekArray = AvailableWeekday::weekArray;

        return view(self::$viewDir.'directory.packageEdit', compact('item', 'followEmails', 'followForms', 'appCats', 'data', 'weekArray', 'meetingSet'));
    }

    public function update(Request $request, $id)
    {
        try {
            info(json_encode($request->all()));
            $validation = Validator::make($request->all(), $this->model->storeRule($request));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = $this->model->findorfail($id)->updateItem($request);

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
}
