<?php

namespace App\Http\Controllers\User;

use App\Models\AppointmentCategory;
use App\Models\AppointmentList;
use App\Models\NotificationTemplate;
use App\Models\UserMeeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class AppointmentController extends UserController
{
    public function __construct(UserMeeting $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $list = new AppointmentList();

            return $list->getEvents($request, user()->id);
        }
        $categories = AppointmentCategory::where("status", 1)->orderBy("order")->get();

        $data['categories'] = $categories;

        return view(self::$viewDir.'.appointment.index', $data);
    }

    public function create()
    {
        $meetings = $this->model->where('user_id', user()->id)
            ->where('status', 'active')
            ->get();

        if ($meetings == null) {
            return back()->with('info', "You don\'t have the permission to book an appointment.");
        }
        $categories = AppointmentCategory::where('status', 1)->get();

        return view(self::$viewDir.'.appointment.create', compact('meetings', 'categories'));
    }

    public function edit($id)
    {
        $list = AppointmentList::where('user_id', user()->id)
            ->where('id', $id)
            ->firstorfail();

        $categories = AppointmentCategory::where('status', 1)
            ->get();

        $meetings = $this->model->where('user_id', user()->id)
            ->where('status', 'active')
            ->get();
        if ($list->status == 'done') {
            return view(self::$viewDir.'.appointment.detail', compact('list'));
        }

        return view(self::$viewDir.'.appointment.edit', compact('meetings', 'categories', 'list'));
    }

    public function detail($id)
    {
        $list = AppointmentList::where('user_id', user()->id)->where('id', $id)->firstorfail();

        return view(self::$viewDir.'.appointment.detail', compact('list'));
    }

    public function cancel(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'reason' => 'required|max:600',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }
        $list = AppointmentList::where('user_id', user()->id)->where('id', $id)->firstorfail();
        $list->reason = $request->reason;
        $list->status = 'canceled';
        $list->save();

//        $notification = new NotificationTemplate();
//        $data['url'] = route('admin.appointment.listing.detail', $list->id);
//        $data['slug'] = $notification::APPOINTMENT_CANCELED_BY_USER;
//        $data['reason'] = $list->reason;
//        $data['detail'] = "Category:{$list->category->name}<br>Date: {$list->date} <br> Time: {$list->start_time} - {$list->end_time}";
//        $notification->sendNotificationToAdmin($data);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function selectProduct(Request $request)
    {
        try {
            $meeting = $this->model->where('id', $request->id)
                ->where('user_id', user()->id)
                ->firstorfail();

            if ($meeting->meeting_number - $meeting->current_number <= 0) {
                return response()->json([
                    'status' => 0,
                    'data' => ["Sorry that product doesn\'t have enough meeting number."],
                ]);
            }
            $product = $meeting->product;
            if ($product == null || $product->meeting == 0) {
                return response()->json([
                    'status' => 0,
                    'data' => ["Sorry that product doesn\'t accept any meeting now. Please choose the other one."],
                ]);
            }
            $categories = $product->meetingSet->categories->pluck('id')->toArray();

            return response()->json([
                'status' => 1,
                'data' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function selectCategory(Request $request)
    {
        try {
            $meeting = $this->model->where('id', $request->meeting_id)
                ->where('user_id', user()->id)
                ->firstorfail();

            if ($meeting->meeting_number - $meeting->current_number <= 0) {
                return response()->json([
                    'status' => 0,
                    'data' => ["Sorry that product doesn\'t have enough meeting number."],
                ]);
            }
            $product = $meeting->product;
            $categories = $product->meetingSet->categories->pluck('id')->toArray();
            if (! in_array($request->category_id, $categories)) {
                return response()->json([
                    'status' => 0,
                    'data' => ['You are not allowed to choose this category and product'],
                ]);
            }
            $category = AppointmentCategory::where('id', $request->category_id)->where('status', 1)->firstorfail();

            if ($request->date == 0) {
                $now = Carbon::now();
                $date = $now->toDateString();
                $result[$date] = $meeting->getAvailablePeriod($date, $category);
                foreach (range(1, 6) as $i) {
                    $day = Carbon::now()->add($i, 'day');
                    $date = $day->toDateString();
                    $result[$date] = $meeting->getAvailablePeriod($date, $category);
                }
            } else {
                $result[$request->date] = $meeting->getAvailablePeriod($request->date, $category);
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

    public function store(Request $request)
    {
        $list = new AppointmentList();
        $validation = Validator::make($request->all(), $list->storeRule());

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }

        $meeting = $this->model->where('id', $request->meeting_id)
            ->where('user_id', user()->id)
            ->firstorfail();

        if ($meeting->meeting_number - $meeting->current_number <= 0) {
            return response()->json([
                'status' => 0,
                'data' => ["Sorry that product doesn\'t have enough meeting number."],
            ]);
        }

        $product = $meeting->product;
        $categories = $product->meetingSet->categories->pluck('id')->toArray();
        if (! in_array($request->category_id, $categories)) {
            return response()->json([
                'status' => 0,
                'data' => ['You are not allowed to choose this category and product'],
            ]);
        }
        $category = AppointmentCategory::where('id', $request->category_id)
            ->where('status', 1)
            ->firstorfail();
        $periods = $meeting->getAvailablePeriod($request->date, $category);
        $check = 0;
        foreach ($periods as $period) {
            if ($period['start'] == $request->start && $period['end'] == $request->end) {
                $check = 1;
            }
        }
        if ($check == 0) {
            return response()->json([
                'status' => 0,
                'data' => ['Your selection is wrong. Please try to choose another period.'],
            ]);
        }

        if ($request->id) {
            $item = $list->where('id', $request->id)
                ->where('user_id', user()->id)
                ->firstorfail()
                ->storeItem($request);

//            $notification = new NotificationTemplate();
//            $data['url'] = route('admin.appointment.listing.detail', $item->id);
//            $data['slug'] = $notification::APPOINTMENT_RESCHEDULED;
//            $data['detail'] = "Category:{$item->category->name}<br>Date: {$item->date} <br> Time: {$item->start_time} - {$item->end_time}";
//            $notification->sendNotificationToAdmin($data);
        } else {
            $item = $list->storeItem($request);
            $meeting->increment('current_number');
//
//            $notification = new NotificationTemplate();
//            $data['url'] = route('admin.appointment.listing.detail', $item->id);
//            $data['slug'] = $notification::APPOINTMENT_APPROVAL;
//            $data['detail'] = "Category:{$item->category->name}<br>Date: {$item->date} <br> Time: {$item->start_time} - {$item->end_time}";
//            $notification->sendNotificationToAdmin($data);
        }

        return response()->json([
            'status' => 1,
            'data' => $item,
        ]);
    }
}
