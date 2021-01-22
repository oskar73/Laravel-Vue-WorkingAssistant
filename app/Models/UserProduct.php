<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class UserProduct extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function storeItemFromPurchase($item, $user, $orderItem)
    {
        $userProduct = new UserProduct();
        $userProduct->user_id = $user->id;
        $userProduct->order_item_id = $orderItem->id;
        $userProduct->quantity = $item['quantity'];

        if ($orderItem->recurrent == 0) {
            $userProduct->status = 'active';
        } else {
            $userProduct->status = 'pending';
        }

        $userProduct->item = $item['item'];
        $userProduct->price = $item['price'];
        $userProduct->parameter = serialize($item['parameter']);
        $userProduct->save();
    }

    public function getDatatable($status)
    {
        $items = $this->with('orderItem', 'user');
        if ($status == 'all') {
            $result = $items;
        } elseif ($status == 'active') {
            $result = $items->where('status', 'active');
        } else {
            $result = $items->where('status', '!=', 'active');
        }

        return Datatables::of($result)->addColumn('user', function ($row) {
            return "<img src='".$row->user->avatar()."' title='".$row->user->name."' class='user-avatar-50'><br><a href='".route('admin.userManage.detail', $row->user->id)."'>{$row->user->name}</a><br>({$row->user->email})";
        })->addColumn('order', function ($row) {
            return "<a href='".route('admin.purchase.order.detail', $row->orderItem->order_id)."'>Order #{$row->orderItem->order_id}</a>";
        })->addColumn('itemName', function ($row) {
            $name = $row->orderItem->getName();
            if ($row->size) {
                $name .= '<br>Size:'.$row->size;
            }
            if ($row->color) {
                $name .= '<br>Color:'.$row->color;
            }

            if ($row->custom) {
                $name .= '<br>'.json_decode($row->item)->variant_name.':'.$row->custom;
            }

            return $name;
        })->addColumn('payment', function ($row) {
            return $row->orderItem->recurrent == 1 ? 'Recurrent' : 'Onetime';
        })->addColumn('due_date', function ($row) {
            return $row->orderItem->due_date;
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('status', function ($row) {
            if ($row->status == 'active') {
                return '<span class="c-badge c-badge-success">Active</span>';
            } else {
                return '<span class="c-badge c-badge-info" >'.$row->status.'</span>';
            }
        })->addColumn('action', function ($row) {
            return '<a href="'.route('admin.purchase.ecommerce.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['user', 'order', 'itemName', 'status', 'action'])->make(true);
    }

    public function getUserDataTable()
    {
        $result = $this->with('orderItem', 'user')->where('user_id', user()->id);

        return Datatables::of($result)->addColumn('order', function ($row) {
            return "<a href='".route('user.purchase.order.detail', $row->orderItem->order_id)."'>Order #{$row->orderItem->order_id}</a>";
        })->addColumn('itemName', function ($row) {
            $name = $row->orderItem->getName();
            if ($row->size) {
                $name .= '<br>Size:'.$row->size;
            }
            if ($row->color) {
                $name .= '<br>Color:'.$row->color;
            }

            if ($row->custom) {
                $name .= '<br>'.json_decode($row->item)->variant_name.':'.$row->custom;
            }

            return $name;
        })->addColumn('payment', function ($row) {
            return $row->orderItem->recurrent == 1 ? 'Recurrent' : 'Onetime';
        })->addColumn('due_date', function ($row) {
            return $row->orderItem->due_date;
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('status', function ($row) {
            if ($row->status == 'active') {
                return '<span class="c-badge c-badge-success">Active</span>';
            } else {
                return '<span class="c-badge c-badge-info" >'.$row->status.'</span>';
            }
        })->addColumn('action', function ($row) {
            return '<a href="'.route('user.ecommerce.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['order', 'itemName', 'status', 'action'])->make(true);
    }
}
