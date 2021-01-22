<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Admin\AdminController;
use App\Models\NotificationTemplate;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Validator;

class ItemController extends AdminController
{
    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'), request()->get('user'));
        }

        return view(self::$viewDir.'ticket.item');
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $items = $this->model->with('media', 'user.media')
                ->where('parent_id', $id)
                ->orderBy('tickets.created_at', 'DESC')
                ->paginate(10);

            return view('components.account.ticketItem', compact('items'))->render();
        } else {
            $item = $this->model->where('id', $id)
                ->firstorfail();
        }

        return view(self::$viewDir.'ticket.itemEdit', compact('item'));
    }

    public function show($id)
    {
        $item = $this->model->where('id', $id)
            ->firstorfail();

        return view(self::$viewDir.'ticket.itemShow', compact('item'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->updateRule());
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $mainTicket = $this->model->find($id)->updateItem($request, 'answered');

//            $notification = new NotificationTemplate();
//            $slug = $notification::TICKET_REPLIED;
//            $data['username'] = $mainTicket->user->name;
//            $data['url'] = route('user.ticket.show', $mainTicket->id);
//            $data['answer'] = $request->description;
//            $notification->sendNotification($data, $slug, $mainTicket->user);

            return response()->json([
                'status' => 1,
                'data' => $mainTicket,
            ]);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function switchTicket(Request $request)
    {
        try {
            $action = $request->action;

            if ($action === 'close') {
                $this->model->whereIn('id', $request->ids)->update(['status' => 'closed']);
            } elseif ($action === 'delete') {
                $this->model->whereIn('id', $request->ids)->get()->each->delete();
            }

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
}
