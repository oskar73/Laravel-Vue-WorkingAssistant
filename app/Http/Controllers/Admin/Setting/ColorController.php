<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Color;
use Illuminate\Http\Request;
use Validator;

class ColorController extends AdminController
{
    public function __construct(Color $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $colors = $this->model->get();

            $themeColors = $colors->where('type', 'theme');
            $menuColors = $colors->where('type', 'menu');

            $theme = view('components.admin.colorTheme', [
                'themeColors' => $themeColors,
                'selector' => 'datatable-theme',
            ])->render();

            $menu = view('components.admin.colorMenu', [
                'menuColors' => $menuColors,
                'selector' => 'datatable-menu',
            ])->render();
            $count['theme'] = $themeColors->count();
            $count['menu'] = $menuColors->count();

            return response()->json([
                'status' => 1,
                'theme' => $theme,
                'menu' => $menu,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'setting.color');
    }

    public function create($type)
    {
        if (! in_array($type, ['theme', 'menu'])) {
            abort(404);
        }

        if ($type == 'theme') {
            return view(self::$viewDir.'setting.colorThemeCreate', compact('type'));
        } else {
            return view(self::$viewDir.'setting.colorMenuCreate', compact('type'));
        }
    }

    public function store(Request $request, $type)
    {
        if (! in_array($type, ['theme', 'menu'])) {
            abort(404);
        }
        $validation = Validator::make($request->all(), $this->model->storeRule($type));

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'data' => $validation->errors()]);
        }

        $this->model->storeItem($request, $type);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function edit($id)
    {
        $color = $this->model->findorfail($id);

        if ($color->type == 'theme') {
            return view(self::$viewDir.'setting.colorThemeEdit', compact('color'));
        } else {
            return view(self::$viewDir.'setting.colorMenuEdit', compact('color'));
        }
    }

    public function update(Request $request, $id)
    {
        $color = $this->model->findorfail($id);
        $validation = Validator::make($request->all(), $this->model->storeRule($color->type));

        if ($validation->fails()) {
            return response()->json(['status' => 0, 'data' => $validation->errors()]);
        }

        $color->storeItem($request, $color->type);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function switchItem(Request $request)
    {
        $action = $request->action;
        if ($action === 'current') {
            $type = $request->type;
            $item = $this->model->whereIn('id', $request->ids)->where('type', $type)->first();
            $item->default = 1;
            $item->save();

            $this->model->where('type', $type)
                ->where('id', '!=', $item->id)
                ->get()
                ->each
                ->update(['default' => 0]);
        } elseif ($action === 'delete') {
            $items = $this->model->whereIn('id', $request->ids)->get();
            $items->each->delete();
        }

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
