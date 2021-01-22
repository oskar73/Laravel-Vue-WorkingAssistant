<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Page;
use Illuminate\Http\Request;
use Validator;

class HeaderController extends AdminController
{
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $pages = $this->model->orderBy('order')
                ->where('status', 1)
                ->get(['id', 'parent_id', 'name', 'type', 'url', 'order', 'header', 'footer', 'status']);

            $headers = $pages->where('header', 1);
            $others = $pages->where('header', '!=', 1);

            return response()->json([
                'status' => 1,
                'data' => view('components.admin.contentHeader', compact('headers', 'others'))->render(),
            ]);
        }

        return view(self::$viewDir.'content.header');
    }

    public function switchItem(Request $request)
    {
        $page = $this->model->where('status', 1)
            ->whereId($request->id)
            ->firstorfail();

        $page->header = $page->header == 1 ? 0 : 1;
        $page->save();

        if ($page->header == 0 && $page->subPages->count()) {
            $page->subPages()->update(['header' => 0, 'parent_id' => 0]);
        }

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function updateOrder(Request $request)
    {
        $data = json_decode($request->result);

        $this->saveHeader($data);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function saveHeader($data, $parent_id = 0)
    {
        $page_ids = $this->model->where('status', 1)->pluck('id')->toArray();

        foreach ($data as $key => $item) {
            if (! in_array($item->id, $page_ids)) {
                abort(404);
            }

            $this->model->whereId($item->id)->update([
                'parent_id' => $parent_id,
                'order' => $key,
            ]);
            if (isset($item->children)) {
                $this->saveHeader($item->children, $item->id);
            }
        }

        return true;
    }

    public function rule($request)
    {
        if ($request->menu_id) {
            $rule['menu_id'] = 'required|exists:pages,id,web_id,'.tenant('id').',type,custom';
        }
        $rule['name'] = 'required|max:45';
        $rule['link'] = 'nullable|max:255';

        return $rule;
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), $this->rule($request));
        if ($validation->fails()) {
            return response()->json(['status' => 0, 'data' => $validation->errors()]);
        }
        if ($request->menu_id) {
            $menu = $this->model->findorfail($request->menu_id);
        } else {
            $menu = new Page();
            $menu->type = 'custom';
            $menu->header = 1;
            $menu->order = 100;
        }
        $menu->name = $request->name;
        $menu->url = $request->link;
        $menu->save();

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function edit(Request $request)
    {
        $menu = $this->model->where('type', 'custom')->whereId($request->id)->firstorfail(['name', 'url', 'id']);

        return response()->json([
            'status' => 1,
            'data' => $menu,
        ]);
    }

    public function delete(Request $request)
    {
        $menu = $this->model->where('type', 'custom')
            ->whereId($request->id)
            ->firstorfail();
        if ($menu->subPages->count()) {
            $menu->subPages()->update([
                'parent_id' => 0,
            ]);
        }
        $menu->delete();

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
