<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\NotificationTemplate;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    public function profile($role)
    {
        if (! in_array($role, ['admin', 'account'])) {
            abort(404);
        }

        return view('account.profile');
    }

    public function profileUpdate(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), user()->profileUpdateRule($request));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $user = user()->updateProfile($request);

            $data['url'] = route('profile', user()->hasRole('admin') ? 'admin' : 'account');
            $data['username'] = user()->name;

            $notification = new NotificationTemplate();
            $notification->sendNotification($data, $notification::PROFILE_CHANGED, $user);

            return response()->json([
                'status' => 1,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function passwordUpdate(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'old_password' => [
                    function ($attribute, $value, $fail) {
                        if (user()->password !== null && ! Hash::check($value, user()->password)) {
                            $fail('Old Password didn\'t match');
                        }
                    },
                ],
                'new_password' => 'required|min:8|different:old_password|max:191',
                'confirm_password' => 'required|same:new_password',
            ]);
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $user = user()->updatePsw($request);

            return response()->json([
                'status' => 1,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function uploadImage(Request $request, $folder = null)
    {
        try {
            $validation = Validator::make($request->all(), [
                'file' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);
            if ($validation->fails()) {
                abort(404);
            }

            $file = $request->file('file');
            $name = guid().'.'.$file->getClientOriginalExtension();

            $folder_name = config('custom.storage_name.tinymce');

            $path = $folder ? $folder_name.'/'.$folder : $folder_name;

            $location = BaseModel::fileUpload($file, $name, $path);

            return response()->json([
                'location' => $location,
            ]);
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function uploadImages(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'file' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);
            if ($validation->fails()) {
                abort(404);
            }

            $file = $request->file('file');

            $name = $file->getClientOriginalName();

            $folder_name = config('custom.storage_name.tinymce');

            $path = $folder_name.'/'.$id;

            BaseModel::fileUpload($file, $name, $path);

            return response()->json([
                'name' => $name,
                'original_name' => $name,
            ]);
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function notifications($role)
    {
        if (! in_array($role, ['admin', 'account'])) {
            abort(404);
        }

        if (request()->wantsJson()) {
            return user()->getNotifications(request()->get('status'));
        }

        return view('account.notification');
    }

    public function notificationDetail($role, $id)
    {
        if (! in_array($role, ['admin', 'account'])) {
            abort(404);
        }
        $notification = user()->notifications()->whereId($id)->firstorfail();
        if ($notification->read_at == null) {
            $notification->read_at = Carbon::now()->toDateTimeString();
            $notification->save();
        }

        return view('account.notificationDetail', compact('notification'));
    }

    public function notificationSwitch(Request $request)
    {
        try {
            $action = $request->action;

            if ($action === 'read') {
                user()->notifications()->whereIn('id', $request->ids)->get()->each->update(['read_at' => Carbon::now()->toDateTimeString()]);
            } elseif ($action === 'unread') {
                user()->notifications()->whereIn('id', $request->ids)->get()->each->update(['read_at' => null]);
            } elseif ($action === 'delete') {
                user()->notifications()->whereIn('id', $request->ids)->get()->each->delete();
            }

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
