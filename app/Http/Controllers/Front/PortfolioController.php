<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Portfolio();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->model->filterItem($request);

            return response()->json($result);
        }

        $categories = PortfolioCategory::with('approvedSubCategories')
            ->isParent()
            ->status(1)
            ->orderBy('order')
            ->get(['id', 'slug', 'name', 'parent_id']);

        return view('frontend.portfolio.index', [
            'categories'    =>  $categories,
            'modules'    =>  tenant()->getBuilderModules()
        ]);
    }

    public function detail($slug)
    {
        $item = $this->model->where('slug', $slug)
            ->with('media')
            ->status(1)
            ->firstorfail();

        return view('frontend.portfolio.detail', [
            'item'  =>  $item,
            'modules'    =>  tenant()->getBuilderModules()
        ]);
    }
}
