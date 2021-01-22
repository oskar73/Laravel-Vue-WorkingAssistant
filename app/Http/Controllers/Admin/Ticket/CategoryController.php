<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Admin\AdminController;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends AdminController
{
    public function __construct(TicketCategory $model)
    {
        $this->model = $model;
        $this->sortModel = $this->model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $categories = $this->model->get();

            $activeCats = $categories->where('status', 1);
            $inactiveCats = $categories->where('status', 0);

            $all = view('components.admin.ticketCategory', [
                'categories' => $categories,
                'selector' => 'datatable-all',
            ])->render();
            $active = view('components.admin.ticketCategory', [
                'categories' => $activeCats,
                'selector' => 'datatable-active',
            ])->render();
            $inactive = view('components.admin.ticketCategory', [
                'categories' => $inactiveCats,
                'selector' => 'datatable-inactive',
            ])->render();
            $count['all'] = $categories->count();
            $count['active'] = $activeCats->count();
            $count['inactive'] = $inactiveCats->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'ticket.category');
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
            $category = $this->model->storeItem($request);

            return response()->json(['status' => 1, 'data' => $category]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
