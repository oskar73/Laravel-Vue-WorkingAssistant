<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Page;
use Illuminate\Http\Request;
use Validator;

class LegalPageController extends AdminController
{
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $setting = option('legal', 0);
        if ($setting == 0) {
            $this->model->createLegalPages();
        }

        $legalPages = $this->model->whereIn('type', ['legal', 'termsAndConditions'])
            ->get();

        return view(self::$viewDir.'content.legalPage', compact('legalPages'));
    }

    public function edit($id)
    {
        $legalPage = $this->model->whereIn('type', ['legal', 'termsAndConditions'])
            ->whereId($id)
            ->firstorfail();

        $seo = optional($legalPage->data);

        return view(self::$viewDir.'content.legalPageEdit', compact('legalPage', 'seo'));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), $this->model->legalPageStoreRule($id));

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }
        $page = $this->model->whereIn('type', ['legal', 'termsAndConditions'])
            ->whereId($id)
            ->firstorfail()
            ->updateLegalItem($request);

        return response()->json([
            'status' => 1,
            'data' => $page,
        ]);
    }
}
