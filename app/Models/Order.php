<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class Order extends BaseModel
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function saveItem($cart, $user, $gateway)
    {
        $order = $this;
        $order->user_id = $user->id;
        $order->gateway = $gateway;
        $order->discount_total = 0;
        $order->onetime_total = $cart->onetimeTotalPrice;
        $order->recurrent_total = $cart->subTotalPrice;
        $order->total = $cart->totalPrice;
        $order->total_qty = $cart->totalQty;
        $order->save();

        return $order;
    }

    public function storePaypalOnetimeOrderItems($cart, $user)
    {
        $order_item_ids = [];
        foreach ($cart->items as $key => $item) {
            if ($item['recurrent'] == 0) {
                $orderItem = new OrderItem();
                $orderItem->user_id = $user->id;
                $orderItem->order_id = $this->id;
                $orderItem->order_item_id = $key;
                $orderItem->recurrent = 0;
                $orderItem->product_type = $item['type'];
                $orderItem->product_id = $item['item']['id'];
                $orderItem->sub_total = $item['price'] * $item['quantity'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->product_detail = json_encode($item['item']);
                $orderItem->paid = 1;
                $orderItem->status = 'active';
                $orderItem->save();

                $order_item_ids[$key] = $orderItem->id;
            }
        }

        return $order_item_ids;
    }

    public function storePaypalRecurrentOrderItem($item, $user, $order_item_id, $agreement_id)
    {
        $orderItem = new OrderItem();
        $orderItem->user_id = $user->id;
        $orderItem->order_id = $this->id;
        $orderItem->order_item_id = $order_item_id;
        $orderItem->recurrent = 1;
        $orderItem->product_type = $item['type'];
        $orderItem->product_id = $item['item']['id'];
        $orderItem->sub_total = $item['price'] * $item['quantity'];
        $orderItem->quantity = $item['quantity'];
        $orderItem->price = json_encode($item['parameter']);
        $orderItem->product_detail = json_encode($item['item']);
        $orderItem->agreement_id = $agreement_id;
        $orderItem->status = 'pending';
        $orderItem->paid = 1;
        $orderItem->save();

        return $orderItem;
    }

    public function savePaypalRecurrentOrder($cart, $user, $item)
    {
        $order = $this;
        $order->user_id = $user->id;
        $order->gateway = 'paypal';
        $order->discount_total = 0;
        $order->onetime_total = 0;
        $order->recurrent_total = $item['price'];
        $order->total = $item['price'];
        $order->total_qty = $item['quantity'];
        $order->save();

        return $order;
    }

    public function addPaypalRecurrentOrder($cart, $user, $item)
    {
        $order = $this;
        $order->recurrent_total += $item['price'];
        $order->total += $item['price'];
        $order->total_qty += $item['quantity'];
        $order->save();

        return $order;
    }

    public function savePaypalOnetimeOrder($cart, $user)
    {
        $order = $this;
        $order->user_id = $user->id;
        $order->gateway = 'paypal';
        $order->discount_total = 0;
        $order->onetime_total = $cart->onetimeTotalPrice;
        $order->recurrent_total = 0;
        $order->total = $cart->onetimeTotalPrice;
        $order->total_qty = $cart->onetimeQty;
        $order->save();

        return $order;
    }

    public function storeItems($cart, $user)
    {
        $order_item_ids = [];
        foreach ($cart->items as $key => $item) {
            $orderItem = new OrderItem();
            $orderItem->user_id = $user->id;
            $orderItem->order_id = $this->id;
            $orderItem->order_item_id = $key;
            $orderItem->recurrent = $item['recurrent'];
            $orderItem->product_type = $item['type'];
            $orderItem->product_id = $item['item']['id'];
            $orderItem->sub_total = $item['price'] * $item['quantity'];
            $orderItem->quantity = $item['quantity'];
            if ($item['recurrent'] == 0) {
                $orderItem->price = $item['price'];
            } else {
                $orderItem->price = json_encode($item['parameter']);
            }
            $orderItem->product_detail = json_encode($item['item']);
            $orderItem->paid = 0;
            $orderItem->status = 'pending';
            $orderItem->save();

            $order_item_ids[$key] = $orderItem->id;
        }

        return $order_item_ids;
    }

    public function updateOnetimeItemsStatusAsPaid()
    {
        OrderItem::where('order_id', $this->id)
            ->where('recurrent', 0)
            ->get()
            ->each
            ->update([
                'paid' => 1,
                'status' => 'active',
                'agreement_id' => $this->id,
            ]);

        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function getDatatable()
    {
        $orders = $this::with('user');

        return Datatables::of($orders)->addColumn('user', function ($row) {
            return "<img src='".$row->user->avatar()."' title='".$row->user->name."' class='user-avatar-50'><br><a href='".route('admin.userManage.detail', $row->user->id)."'>{$row->user->name}</a><br>({$row->user->email})";
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('gateway', function ($row) {
            return ucfirst($row->gateway);
        })->addColumn('price', function ($row) {
            $total_price = 'Total Price: $'.formatNumber($row->total).'<br>';
            $onetime_price = $row->onetime_total != 0 ? 'Onetime Total Price: $'.formatNumber($row->onetime_total).' <br>' : '';
            $recurrent_price = $row->recurrent_total != 0 ? 'Recurring Total Price: $'.formatNumber($row->recurrent_total).' <br>' : '';
            $discount_price = $row->discount_total != 0 ? 'Discount Price: $'.formatNumber($row->discount_total) : '';

            return $total_price.$onetime_price.$recurrent_price.$discount_price;
        })->addColumn('action', function ($row) {
            return '<a href="'.route('admin.purchase.order.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['checkbox', 'user', 'price', 'action'])->make(true);
    }

    public function getUserDataTable()
    {
        $orders = $this::where('useR_id', user()->id);

        return Datatables::of($orders)->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('gateway', function ($row) {
            return ucfirst($row->gateway);
        })->addColumn('price', function ($row) {
            $total_price = 'Total Price: $'.formatNumber($row->total).'<br>';
            $onetime_price = $row->onetime_total != 0 ? 'Onetime Total Price: $'.formatNumber($row->onetime_total).' <br>' : '';
            $recurrent_price = $row->recurrent_total != 0 ? 'Recurring Total Price: $'.formatNumber($row->recurrent_total).' <br>' : '';
            $discount_price = $row->discount_total != 0 ? 'Discount Price: $'.formatNumber($row->discount_total) : '';

            return $total_price.$onetime_price.$recurrent_price.$discount_price;
        })->addColumn('action', function ($row) {
            return '<a href="'.route('user.purchase.order.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['checkbox', 'price', 'action'])->make(true);
    }
}
