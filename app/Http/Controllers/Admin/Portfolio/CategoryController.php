<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\AdminController;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends AdminController
{
    public function __construct(PortfolioCategory $model)
    {
        $this->model = $model;
        $this->sortModel = $this->model->where('parent_id', 0);
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $categories = $this->model->where('parent_id', 0)
                ->with('media')
                ->withCount('subcategories')
                ->get();

            $activeCats = $categories->where('status', 1);
            $inactiveCats = $categories->where('status', 0);

            $subcategories = $this->model->where('parent_id', '!=', 0)
                ->with('media')
                ->with('category')
                ->get();

            $all = view('components.admin.portfolioCategory', [
                'categories' => $categories,
                'selector' => 'datatable-all',
            ])->render();
            $active = view('components.admin.portfolioCategory', [
                'categories' => $activeCats,
                'selector' => 'datatable-active',
            ])->render();
            $inactive = view('components.admin.portfolioCategory', [
                'categories' => $inactiveCats,
                'selector' => 'datatable-inactive',
            ])->render();
            $subcategory = view('components.admin.portfolioCategory', [
                'categories' => $subcategories,
                'selector' => 'datatable-subcategory',
            ])->render();

            $parents = '<option value="0">Set as Parent Category</option>';
            foreach ($categories as $category) {
                $parents .= "<option value='".$category->id."'>".$category->name.'</option>';
            }
            $count['all'] = $categories->count();
            $count['active'] = $activeCats->count();
            $count['inactive'] = $inactiveCats->count();
            $count['subcategory'] = $subcategories->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'parents' => $parents,
                'subcategory' => $subcategory,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'portfolio.category');
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
            if ($request->category_id == null) {
                $category = $this->model->storeItem($request);
            } else {
                $category = $this->model->findorfail($request->category_id)
                    ->storeItem($request);

                if ($request->parent_id !== 0) {
                    $category->subcategories()->update(['parent_id' => $request->parent_id]);
                }
            }

            return response()->json(['status' => 1, 'data' => $category]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
