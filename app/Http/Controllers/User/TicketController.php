<?php

namespace App\Http\Controllers\User;

use App\Models\NotificationTemplate;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Validator;

class TicketController extends UserController
{
    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->userDataTable(request()->get('status'));
        }

        return view(self::$viewDir.'ticket.item');
    }

    public function create()
    {
        $categories = TicketCategory::where('status', 1)
            ->select('id', 'name', 'slug')
            ->orderBy('order')
            ->get();

        return view(self::$viewDir.'ticket.itemCreate', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->storeRule());
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = $this->model->createItem($request);

//            $notification = new NotificationTemplate();
//            $data['url'] = route('admin.ticket.item.edit', $item->id);
//            $data['slug'] = $notification::TICKET_NEW;
//            $data['detail'] = "ID:#{$item->id} <br>Title:{$item->text}<br>Priority: {$item->priority}";
//            $notification->sendNotificationToAdmin($data);

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

    public function show($id)
    {
        $item = $this->model->where('id', $id)
            ->where('parent_id', 0)
            ->where('user_id', user()->id)
            ->firstorfail();

        if ($item->is_read == 0) {
            $item->is_read = 1;
            $item->save();
        }

        return view(self::$viewDir.'ticket.itemShow', compact('item'));
    }

    public function edit($id)
    {
        $item = $this->model->where('id', $id)
            ->where('parent_id', 0)
            ->where('user_id', user()->id)
            ->firstorfail();

        if ($item->is_read == 0) {
            $item->is_read = 1;
            $item->save();
        }

        if (request()->ajax()) {
            $items = $this->model->with('media', 'user.media')
                ->where('parent_id', $item->id)
                ->orderBy('tickets.created_at', 'DESC')
                ->paginate(10);

            return view('components.account.ticketItem', compact('items'))->render();
        }

        return view(self::$viewDir.'ticket.itemEdit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->updateRule());
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $mainTicket = $this->model->my()
                ->findorfail($id)
                ->updateItem($request, 'opened', 1);

//            $notification = new NotificationTemplate();
//            $data['url'] = route('admin.ticket.item.edit', $mainTicket->id);
//            $data['slug'] = $notification::TICKET_REPLIED_BY_USER;
//            $data['detail'] = "ID:#{$mainTicket->id} <br>Title:{$mainTicket->text}<br>Priority: {$mainTicket->priority}";
//            $data['answer'] = $request->description;
//            $notification->sendNotificationToAdmin($data);

            return response()->json([
                'status' => 1,
                'data' => $mainTicket,
            ]);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function switch(Request $request)
    {
        try {
            $action = $request->action;

            if ($action === 'close') {
                $this->model->whereIn('id', $request->ids)->where('user_id', user()->id)->update(['status' => 'closed']);
            }

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
}
