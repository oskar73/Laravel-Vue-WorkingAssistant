<?php

namespace App\Http\Controllers\Admin\Email;

use App\Http\Controllers\Admin\AdminController;
use App\Models\EmailCampaign;
use App\Models\EmailCategory;
use App\Models\EmailTemplate;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Validator;

class CampaignController extends AdminController
{
    public function __construct(EmailCampaign $model)
    {
        $this->model = $model;
        $this->sortModel = $this->model;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'email.campaign');
    }

    public function create()
    {
        $categories = EmailCategory::where('status', 1)
            ->orderBy('order')
            ->get();
        $subscribers = Subscriber::where('status', 1)->count();

        return view(self::$viewDir.'email.campaignCreate', compact('categories', 'subscribers'));
    }

    public function getCategory(Request $request)
    {
        try {
            $category = EmailCategory::where('status', 1)
                ->where('id', $request->id)
                ->first();
            $templates = EmailTemplate::where('category_id', $category->id)
                ->select('id', 'name')
                ->where('status', 1)
                ->get();

            $result = '<option selected disabled hidden>Choose Template</option>';
            foreach ($templates as $template) {
                $result .= "<option value='{$template->id}'>{$template->name}</option>";
            }

            return response()->json([
                'status' => 1,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function getTemplate(Request $request)
    {
        try {
            $template = EmailTemplate::where('status', 1)
                ->where('id', $request->id)
            ->firstorfail();

            return response()->json([
                'status' => 1,
                'data' => $template->body,
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
                $this->model->storeRule($request),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            if ($request->campaign_id) {
                $item = $this->model->findorfail($request->campaign_id)
                ->storeItem($request);
            } else {
                $item = $this->model->storeItem($request);
            }

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
        $item = $this->model->findorfail($id);
        $categories = EmailCategory::where('status', 1)
            ->orderBy('order')
            ->get();
        $subscribers = Subscriber::where('status', 1)->count();

        return view(self::$viewDir.'email.campaignEdit', compact('categories', 'item', 'subscribers'));
    }

    public function sendNow(Request $request)
    {
        try {
            $campaign = $this->model->status(1)
                ->findorfail($request->id);
            $campaign->sendCampaign();

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

    public function show($id)
    {
        $item = $this->model->findorfail($id);

        return view('components.admin.emailPreview', ['body' => $item->body])->render();
//        return view(self::$viewDir . "email.campaignDetail", compact("item"));
    }
}
