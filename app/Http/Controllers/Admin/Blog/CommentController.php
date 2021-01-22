<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Validator;

class CommentController extends AdminController
{
    public function __construct(BlogComment $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'blog.comment');
    }

    public function edit($id)
    {
        $comment = $this->model->with('favorite_to_users', 'user')
            ->findorfail($id);

        return view(self::$viewDir.'blog.editComment', compact('comment'));
    }

    public function show($id)
    {
        $comment = $this->model->with('favorite_to_users', 'user')
            ->findorfail($id);

        return view(self::$viewDir.'blog.showComment', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                ['status' => 'required|in:1,0,-1']
            );
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $comment = $this->model->findorfail($id);
            $comment->comment = $request->comment;
            $comment->status = $request->status;
            $comment->save();

            return response()->json([
                'status' => 1,
                'data' => $comment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function switchComment(Request $request)
    {
        try {
            $action = $request->action;
            if ($action === 'approve') {
                $this->model->whereIn('id', $request->ids)->update(['status' => 1]);
            } elseif ($action === 'deny') {
                $this->model->whereIn('id', $request->ids)->update(['status' => -1]);
            } elseif ($action === 'delete') {
                $this->model->whereIn('id', $request->ids)->get()->each->delete();
            }

            return response()->json([
                'status' => 1,
                'data' => $action,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
