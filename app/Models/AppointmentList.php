<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class AppointmentList extends BaseModel
{
    use HasFactory;

    protected $table = 'appointment_lists';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function storeRule()
    {
        $rule['category_id'] = 'required|exists:appointment_categories,id';
        // $rule['meeting_id'] = 'required';
        $rule['date'] = 'required';
        $rule['start'] = 'required';
        $rule['end'] = 'required';

        return $rule;
    }

    public function updateRule()
    {
        $rule['category'] = 'required|exists:appointment_categories,id';
        $rule['date'] = 'required';
        $rule['start_time'] = 'required';
        $rule['end_time'] = 'required|after:start_time';
        $rule['reason'] = 'nullable|max:600';
        $rule['description'] = 'nullable|max:600';
        $rule['status'] = 'required|in:approved,pending,canceled,done';

        return $rule;
    }

    public function storeItem($request)
    {
        $item = $this;
        $item->category_id = $request->category_id;
        // $item->meeting_pid = $request->meeting_id;
        $item->user_id = user()->id;
        $item->date = $request->date;
        $item->start_time = $request->start;
        $item->end_time = $request->end;
        $item->status = 'pending';
        $item->reason = $request->reason;
        $item->description = $request->description;
        $item->save();

        return $item;
    }

    public function updateItem($request)
    {
        $item = $this;
        $item->category_id = $request->category;
        $item->date = $request->date;
        $item->start_time = $request->start_time;
        $item->end_time = $request->end_time;
        $item->status = $request->status;
        $item->reason = $request->reason;
        $item->description = $request->description;
        $item->save();

        return $item;
    }

    public function getEvents($request, $user_id = 0)
    {
        $start = $request->start;
        $end = $request->end;

        if ($user_id == 0) {
            $lists = $this->whereBetween('date', [$start, $end])
                ->get();
        } else {
            $lists = $this->where('user_id', user()->id)
                ->whereBetween('date', [$start, $end])
                ->get();
        }
        $events = [];
        if ($lists != null) {
            foreach ($lists as $list) {
                $event = [];
                $event['start'] = $list->date.' '.timeGlobal($list->start_time);
                $event['end'] = $list->date.' '.timeGlobal($list->end_time);
                $event['reason'] = $list->reason;
                $event['status'] = ucfirst($list->status);
                if ($list->status == 'approved') {
                    $color = '#34bfa3';
                } elseif ($list->status == 'pending') {
                    $color = '#36a3f7';
                } elseif ($list->status == 'canceled') {
                    $color = '#CF1124';
                } else {
                    $color = '#32a506';
                }
                if ($user_id == 0) {
                    $event['user'] = $list->user->name;
                    $event['title'] = $list->start_time.' - '.$list->end_time.' ('.$list->user->name.')';
                } else {
                    $event['title'] = $list->start_time.' - '.$list->end_time;
                }
                $event['color'] = $color;
                $event['id'] = $list->id;
                $event['date'] = $list->date;
                $event['product'] = $list->meeting->model?->getName() ?? '';
                $event['start_time'] = $list->start_time;
                $event['end_time'] = $list->end_time;
                $event['allDay'] = false;
                array_push($events, $event);
            }
        }

        return $events;
    }

    public function getDatatable($status, $user, $dir = 'user.')
    {
        switch ($status) {
            case 'all':
                $appointments = $this::with('user', 'meeting');
                break;
            case 'approved':
                $appointments = $this::with('user', 'meeting')->whereStatus('approved');
                break;
            case 'pending':
                $appointments = $this::with('user', 'meeting')->whereStatus('pending');
                break;
            case 'canceled':
                $appointments = $this::with('user', 'meeting')->whereStatus('canceled');
                break;
            case 'done':
                $appointments = $this::with('user', 'meeting')->whereStatus('done');
                break;
        }
        if ($user != 'all') {
            $appointments = $appointments->my($user);
        }

        return Datatables::of($appointments)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('user', function ($row) {
            return "<img src='".$row->user->avatar()."' title='".$row->user->name."' class='user-avatar-50'><br><a href='".route('admin.userManage.detail', $row->user->id)."'>{$row->user->name}</a><br>({$row->user->email})";
        })->addColumn('time', function ($row) {
            return "{$row->start_time} - {$row->end_time}";
        })->addColumn('product', function ($row) {
            return $row->meeting->model?->getName() ?? '';
        })->editColumn('status', function ($row) {
            if ($row->status === 'approved') {
                $result = "<span class='c-badge c-badge-success white-space-nowrap'>".$row->status.'</span>';
            } elseif ($row->status === 'pending') {
                $result = "<span class='c-badge c-badge-danger white-space-nowrap'>".$row->status.'</span>';
            } else {
                $result = "<span class='c-badge c-badge-info white-space-nowrap'>".$row->status.'</span>';
            }

            return $result;
        })->addColumn('action', function ($row) use($dir) {
            return '<a href="'.route($dir.'appointment.listing.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon">
                        <span>
                            <span>Detail</span>
                        </span>
                    </a>
                    <a href="'.route($dir.'appointment.listing.edit', $row->id).'" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon">
                        <span>
                            <span>Edit</span>
                        </span>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne"  data-action="delete">
                        <span>
                            <span>Delete</span>
                        </span>
                    </a>
                    ';
        })->rawColumns(['checkbox', 'user', 'status', 'action'])->make(true);
    }

    public function category()
    {
        return $this->belongsTo(AppointmentCategory::class, 'category_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function meeting()
    {
        return $this->belongsTo(UserMeeting::class, 'meeting_pid')->withDefault();
    }
}
