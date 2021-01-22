<?php

namespace App\Http\Controllers\Admin\Email;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BizinaEmailTemplate;
use App\Models\EmailCategory;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Validator;

class TemplateController extends AdminController
{
    public function __construct(EmailTemplate $model)
    {
        $this->model = $model;
        $this->sortModel = $this->model;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $templates = $this->model->with(['category:name,id', 'media'])
                ->get(['id', 'name', 'status', 'category_id', 'description', 'created_at']);

            $my = view('components.admin.emailTemplateTable', [
                'templates' => $templates,
                'selector' => 'datatable-my',
            ])->render();

            $count['my'] = $templates->count();

            return response()->json([
                'status' => 1,
                'my' => $my,
                'count' => $count,
            ]);
        }

        $categories = EmailCategory::where('status', 1)
            ->orderBy('order')
            ->get();

        return view(self::$viewDir.'email.template', compact('categories'));
    }

    public function create()
    {
        $categories = EmailCategory::where('status', 1)
            ->orderBy('order')
            ->get();

        return view(self::$viewDir.'email.templateCreate', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->storeRule(),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            if ($request->template_id) {
                $item = $this->model->findorfail($request->template_id)
                    ->storeItem($request);
                $route = route('admin.email.template.edit', $item->id);
            } else {
                $item = $this->model->storeItem($request);
                $route = route('admin.email.template.edit', $item->id).'#/body';
            }

            return response()->json(['status' => 1, 'data' => $route]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function edit($id)
    {
        $template = $this->model->findorfail($id);
        $categories = EmailCategory::where('status', 1)
            ->orderBy('order')
            ->get();

        return view(self::$viewDir.'email.templateEdit', compact('categories', 'template'));
    }

    public function show($id)
    {
        $template = $this->model->findorfail($id);

        return view('components.admin.emailPreview', ['body' => $template->body])->render();
    }

    public function updateBody(Request $request, $id)
    {
        try {
            $item = $this->model->findorfail($id)
                ->updateBody($request);

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

    public function onlineTemplate()
    {
        $template = new BizinaEmailTemplate();

        return $template->getDatatable();
    }

    public function viewOnlineTemplate($slug)
    {
        $template = BizinaEmailTemplate::where('slug', $slug)->where('status', 1)->firstorfail();

        return view('components.admin.emailPreview', ['body' => $template->body])->render();
    }

    public function saveOnlineTemplate(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            $this->model->storeRule(),
            $this->model::CUSTOM_VALIDATION_MESSAGE
        );
        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }
        $onlineTemplate = BizinaEmailTemplate::where('slug', $request->template_slug)
            ->where('status', 1)
            ->firstorfail();

        $this->model->storeOnlineItem($request, $onlineTemplate);

        $onlineTemplate->increment('downloads');

        return response()->json(['status' => 1, 'data' => 1]);
    }
}
