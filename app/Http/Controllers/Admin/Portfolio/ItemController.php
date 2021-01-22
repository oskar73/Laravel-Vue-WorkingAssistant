<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Validator;

class ItemController extends AdminController
{
    public function __construct(Portfolio $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $items = $this->model->with(['media', 'category.category'])
                ->latest()
                ->get(['id', 'title', 'status', 'featured', 'new', 'created_at', 'category_id']);
            $activeItems = $items->where('status', 1);
            $inactiveItems = $items->where('status', 0);

            $all = view('components.admin.portfolioItem', [
                'items' => $items,
                'selector' => 'datatable-all',
            ])->render();

            $active = view('components.admin.portfolioItem', [
                'items' => $activeItems,
                'selector' => 'datatable-active',
            ])->render();

            $inactive = view('components.admin.portfolioItem', [
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

        return view(self::$viewDir.'portfolio.item');
    }

    public function create()
    {
        $categories = PortfolioCategory::where('parent_id', 0)
            ->with('approvedSubCategories')
            ->status(1)
            ->get(['id', 'name']);

        return view(self::$viewDir.'portfolio.itemCreate', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->storeRule($request));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = $this->model->storeItem($request);

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

    public function edit($id)
    {
        $item = $this->model->with('media')
            ->where('id', $id)
            ->firstorfail();

        $categories = PortfolioCategory::where('parent_id', '==', 0)
            ->with('approvedSubCategories')
            ->status(1)
            ->get(['id', 'name']);

        return view(self::$viewDir.'portfolio.itemEdit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->storeRule($request));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = $this->model->find($id)->updateItem($request);

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
