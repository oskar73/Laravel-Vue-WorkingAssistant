<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserManageController extends AdminController
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'userManage.index');
    }

    public function edit($id)
    {
        $user = $this->model->with('roles')
            ->findorfail($id);

        return view(self::$viewDir.'userManage.edit', compact('user'));
    }

    public function detail($id)
    {
        $user = $this->model->with('roles')
            ->withCount('posts', 'directoryListings', 'blogAdsListings', 'siteAdsListings', 'directoryAdsListings')
            ->findorfail($id);

        return view(self::$viewDir.'userManage.detail', compact('user'));
    }

    public function create()
    {
        return view(self::$viewDir.'userManage.create');
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->storeRule());
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $user = $this->model->storeItem($request)
                ->syncRoles($request->roles);

            return response()->json(['status' => 1, 'data' => $user]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function updateProfile(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->profileUpdateRule($request, $id));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $user = $this->model->findorfail($id)
                ->updateProfile($request, 1)
                ->syncRoles($request->roles);

            return response()->json(['status' => 1, 'data' => $user]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'new_password' => 'required|min:8|max:191',
                'confirm_password' => 'required|same:new_password',
            ]);
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $user = $this->model->findorfail($id)->updatePsw($request);

            return response()->json(['status' => 1, 'data' => $user]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
