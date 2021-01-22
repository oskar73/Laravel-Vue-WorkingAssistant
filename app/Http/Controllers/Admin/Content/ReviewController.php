<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Review;
use Illuminate\Http\Request;
use Validator;

class ReviewController extends AdminController
{
    public function __construct(Review $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'content.review');
    }

    public function show($id)
    {
        $review = $this->model->findorfail($id);

        return view(self::$viewDir.'content.reviewShow', compact('review'));
    }

    public function edit(Request $request)
    {
        try {
            return response()->json([
                'status' => 1,
                'data' => $this->model->findorfail($request->id),
            ]);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function updateRule($request)
    {
        $rule['rating'] = 'required|in:1,2,3,4,5';
        $rule['comment'] = 'required|min:5|max:600';

        return $rule;
    }

    public function update(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->updateRule($request));
            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $item = $this->model->findorfail($request->item_id);

            $item->rating = $request->rating;
            $item->comment = $request->comment;
            $item->status = $request->status ? 1 : 0;
            $item->save();

            return $this->jsonSuccess($item);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
}
