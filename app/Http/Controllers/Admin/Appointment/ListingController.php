<?php

namespace App\Http\Controllers\Admin\Appointment;

use App\Http\Controllers\Admin\AdminController;
use App\Models\AppointmentCategory;
use App\Models\AppointmentList;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Validator;

class ListingController extends AdminController
{
    public function __construct(AppointmentList $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->model->getEvents($request, 0);
        }

        return view(self::$viewDir.'.appointment.listing');
    }

    public function getData(Request $request)
    {
        return $this->model->getDatatable(request()->get('status'), request()->get('user'));
    }

    public function edit($id)
    {
        $list = $this->model->findorfail($id);
        $categories = AppointmentCategory::where('status', 1)->get();

        return view(self::$viewDir.'.appointment.listingEdit', compact('list', 'categories'));
    }

    public function detail($id)
    {
        $list = $this->model->findorfail($id);

        return view(self::$viewDir.'.appointment.listingDetail', compact('list'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->updateRule());
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $item = $this->model->findorfail($id)->updateItem($request);

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

    public function switchListing(Request $request)
    {
        try {
            $action = $request->action;
            $listings = $this->model->whereIn('id', $request->ids)->get();

            $notification = new NotificationTemplate();
            $notify = 0;

            if ($action === 'approve') {
                $listings->each->update(['status' => 'approved', 'description' => $request->description, 'reason' => null]);
                $notify = 1;
//                $data['description'] = $request->description;
//                $slug = $notification::APPOINTMENT_APPROVED;
            } elseif ($action === 'cancel') {
                $listings->each->update(['status' => 'canceled', 'reason' => $request->reason, 'description' => null]);
                $notify = 1;
//                $data['reason'] = $request->reason;
//                $slug = $notification::APPOINTMENT_CANCELED;
            } elseif ($action === 'delete') {
                $listings->each->delete();
            }

            if ($notify == 1) {
                foreach ($listings as $listing) {
//                    $data['username'] = $listing->user->name;
//                    $data['url'] = route('user.appointment.detail', $listing->id);
//                    $notification->sendNotification($data, $slug, $listing->user);
                }
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
