<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Yajra\DataTables\DataTables;

class Ticket extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'tickets';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($obj) {
            if ($obj->parent_id == 0) {
                Ticket::where('parent_id', $obj->id)->get()->each->delete();
            }
        });
    }

    public function storeRule()
    {
        $rule['subject'] = 'required|max:191';
        $rule['description'] = 'required|max:6000';
        $rule['priority'] = 'required|in:low,medium,high';
        $rule['category'] = 'required|exists:ticket_categories,id,status,1';

        return $rule;
    }

    public function updateRule()
    {
        $rule['description'] = 'required|max:6000';

        return $rule;
    }

    public function createItem($request)
    {
        $item = new Ticket();
        $item->user_id = user()->id;
        $item->category_id = $request->category;
        $item->priority = $request->priority;
        $item->parent_id = 0;
        $item->text = $request->subject;
        $item->status = 'opened';
        $item->is_read = 1;
        $item->save();

        $newItem = new Ticket();
        $newItem->user_id = user()->id;
        $newItem->category_id = $request->category;
        $newItem->parent_id = $item->id;
        $newItem->text = $request->description;
        $newItem->save();

        if ($request->attachments) {
            foreach ($request->attachments as $attachment) {
                $newItem->addMedia($attachment)
                    ->toMediaCollection('attachment');
            }
        }

        return $item;
    }

    public function updateItem($request, $status, $is_read = 0)
    {
        $mainTicket = $this;
        $mainTicket->status = $request->close ? 'closed' : $status;
        $mainTicket->is_read = $is_read;
        $mainTicket->save();

        $item = new Ticket();
        $item->parent_id = $this->id;
        $item->text = $request->description;
        $item->user_id = user()->id;
        $item->category_id = $this->category_id;
        $item->save();
        if ($request->attachments) {
            foreach ($request->attachments as $attachment) {
                $item->addMedia($attachment)
                    ->toMediaCollection('attachment');
            }
        }

        return $mainTicket;
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(Ticket::class, 'parent_id')->withDefault();
    }

    public function items()
    {
        return $this->hasMany(Ticket::class, 'parent_id');
    }

    public function getDatatable($status, $user)
    {
        switch ($status) {
            case 'all':
                $tickets = $this::with('user', 'category')
                    ->where('parent_id', 0);
                break;
            case 'opened':
                $tickets = $this::with('user', 'category')
                    ->where('parent_id', 0)
                    ->where('status', '!=', 'closed');
                break;
            case 'answered':
                $tickets = $this::with('user', 'category')
                    ->where('parent_id', 0)
                    ->where('status', 'answered');
                break;
            case 'closed':
                $tickets = $this::with('user', 'category')
                    ->where('parent_id', 0)
                    ->where('status', 'closed');
                break;
        }
        if ($user != 'all') {
            $tickets = $tickets->my($user);
        }

        return Datatables::of($tickets)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('user', function ($row) {
            $result = "<a href=''>".$row->user->name.'</a>';

            return $result;
        })->addColumn('category', function ($row) {
            return $row->category->name;
        })->editColumn('priority', function ($row) {
            if ($row->priority == 'high') {
                return '<span class="c-badge c-badge-danger">High</span>';
            } elseif ($row->priority == 'medium') {
                return '<span class="c-badge c-badge-info" >Medium</span>';
            } elseif ($row->priority == 'low') {
                return '<span class="c-badge c-badge-success" >Low</span>';
            }
        })->editColumn('status', function ($row) {
            if ($row->status == 'opened') {
                return '<span class="c-badge c-badge-danger hover-handle">Opened</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success origin-none d-none down-handle hover-box switchOne" data-action="close">Close?</a>';
            } elseif ($row->status == 'answered') {
                return '<span class="c-badge c-badge-info hover-handle" >Answered</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success origin-none d-none down-handle hover-box switchOne" data-action="close">Close?</a>';
            } elseif ($row->status == 'closed') {
                return '<span class="c-badge c-badge-success" >Closed</span>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('admin.ticket.item.show', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('admin.ticket.item.edit', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Reply">
                            <i class="la la-reply"></i>
                    </a>
                    <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3 switchOne" data-action="delete" title="Delete">
                            <i class="la la-remove"></i>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'user', 'priority', 'action'])
            ->make(true);
    }

    public function userDataTable($status)
    {
        switch ($status) {
            case 'all':
                $tickets = $this::with('category')
                    ->my()
                    ->where('parent_id', 0);
                break;
            case 'opened':
                $tickets = $this::with('category')
                    ->my()
                    ->where('parent_id', 0)
                    ->where('status', '!=', 'closed');
                break;
            case 'answered':
                $tickets = $this::with('category')
                    ->my()
                    ->where('parent_id', 0)
                    ->where('status', 'answered');
                break;
            case 'closed':
                $tickets = $this::with('category')
                    ->my()
                    ->where('parent_id', 0)
                    ->where('status', 'closed');
                break;
        }

        return Datatables::of($tickets)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('category', function ($row) {
            return $row->category->name;
        })->editColumn('priority', function ($row) {
            if ($row->priority == 'high') {
                return '<span class="c-badge c-badge-danger">High</span>';
            } elseif ($row->priority == 'medium') {
                return '<span class="c-badge c-badge-info" >Medium</span>';
            } elseif ($row->priority == 'low') {
                return '<span class="c-badge c-badge-success" >Low</span>';
            }
        })->editColumn('status', function ($row) {
            if ($row->status == 'opened') {
                return '<span class="c-badge c-badge-danger hover-handle">Opened</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success origin-none d-none down-handle hover-box switchOne" data-action="close">Close?</a>';
            } elseif ($row->status == 'answered') {
                return '<span class="c-badge c-badge-info hover-handle" >Answered</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success origin-none d-none down-handle hover-box switchOne" data-action="close">Close?</a>';
            } elseif ($row->status == 'closed') {
                return '<span class="c-badge c-badge-success" >Closed</span>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('user.ticket.show', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('user.ticket.edit', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Reply">
                            <i class="la la-reply"></i>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'priority', 'action'])
            ->make(true);
    }
}
