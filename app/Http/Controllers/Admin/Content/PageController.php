<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Page;
use Illuminate\Http\Request;
use Validator;

class PageController extends AdminController
{
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $pages = $this->model->with('parent:id,name')
                ->whereIn('type', ['box', 'builder'])
                ->get(['id', 'name', 'url', 'type', 'status', 'parent_id', 'created_at']);

            $activePages = $pages->where('status', 1);
            $inactivePages = $pages->where('status', 0);

            $all = view('components.admin.pageTable', [
                'pages' => $pages,
                'selector' => 'datatable-all',
            ])->render();

            $active = view('components.admin.pageTable', [
                'pages' => $activePages,
                'selector' => 'datatable-active',
            ])->render();

            $inactive = view('components.admin.pageTable', [
                'pages' => $inactivePages,
                'selector' => 'datatable-inactive',
            ])->render();

            $count['all'] = $pages->count();
            $count['active'] = $activePages->count();
            $count['inactive'] = $inactivePages->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'content.page');
    }

    public function create()
    {
        $limit = $this->model->whereIn('type', ['box', 'builder'])->count();
        if (tenant('page_limit') != -1 && tenant('page_limit') <= $limit) {
            $msg = 'Sorry, You can create up to '.$limit.' pages. Please upgrade plan to create more pages';

            return back()->with('info', $msg);
        }

        return view(self::$viewDir.'content.pageCreate');
    }

    public function store(Request $request)
    {
        $limit = $this->model->whereIn('type', ['box', 'builder'])->count();

        if (tenant('page_limit') != -1 && tenant('page_limit') <= $limit) {
            $msg = 'Sorry, You can create up to '.$limit.' pages. Please upgrade plan to create more pages';

            return response()->json([
                'status' => 0,
                'data' => [$msg],
            ]);
        }

        $validation = Validator::make($request->all(), $this->model->pageStoreRule());

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }
        $page = $this->model->storeItem($request);

        return response()->json([
            'status' => 1,
            'data' => route('admin.content.page.editContent', ['id' => $page->id, 'type' => $page->type]),
        ]);
    }

    public function edit($id)
    {
        $page = $this->model->whereIn('type', ['box', 'builder'])
            ->whereId($id)
            ->firstorfail();

        $seo = optional($page->data);

        return view(self::$viewDir.'content.pageEdit', compact('page', 'seo'));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), $this->model->pageStoreRule($id));

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }

        $page = $this->model->whereIn('type', ['box', 'builder'])
            ->whereId($id)
            ->firstorfail()
            ->updateItem($request);

        return response()->json([
            'status' => 1,
            'data' => $page,
        ]);
    }

    public function editContent($id, $type)
    {
        if (! in_array($type, ['box', 'builder'])) {
            abort(404);
        }
        $page = $this->model->findorfail($id);
        $data = optional($page->data);

        if ($type === 'box') {
            return view(self::$viewDir.'content.boxPage', compact('page', 'data'));
        } else {
            return view(self::$viewDir.'content.builderPage', compact('page', 'data'));
        }
    }

    public function rule($type)
    {
        if ($type == 'box') {
            $rule['sHTML'] = 'required';
        } else {
            $rule['inpHtml'] = 'required';
        }

        return $rule;
    }

    public function updateContent(Request $request, $id, $type)
    {
        try {
            $validation = Validator::make($request->all(), $this->rule($type));

            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }

            if (! in_array($type, ['box', 'builder'])) {
                abort(404);
            }

            $page = $this->model->findorfail($id);
            $page->type = $type;
            if ($type == 'box') {
                $page->mainCss = $request->sMainCss;
                $page->sectionCss = $request->sSectionCss;
                $page->content = $request->sHTML;
            } else {
                $page->content = $request->inpHtml;
                $data = $page->data;

                if ($request->fullWidth) {
                    $data['width'] = '100%';
                } else {
                    $data['width'] = $request->maxWidth;
                }
                $data['back_color'] = $request->back_color;

                $page->mainCss = null;
                $page->sectionCss = null;
                $page->data = $data;
            }
            $page->save();

            return response()->json(['status' => 1, 'page' => $page]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
