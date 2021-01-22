<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class OrderItem extends BaseModel
{
    use HasFactory;

    protected $table = 'order_items';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'agreement_id', 'agreement_id')->latest();
    }

    public function storePaypalIpnPayment($due_date, $transaction_id, $agreement_id, $amount, $user_id)
    {
        $order_item = $this;
        $order_item->status = 'active';
        $order_item->due_date = $due_date;
        $order_item->save();

        $transaction = new Transaction();
        $transaction->storeSubscriptionCharge($transaction_id, $agreement_id, $amount, $user_id, 'paypal')
            ->makeInvoice();

        return $order_item;
    }

    public function getName()
    {
        $detail = json_decode($this->product_detail);

        return $detail->name ?? $detail->title ?? '';
    }

    public function getItem()
    {
        return $this->hasOne($this->nameToUserProduct($this->product_type), 'order_item_id')->withDefault();
    }

    public function getRecurrentPrice()
    {
        $price = json_decode($this->price);

        if ($this->product_type == 'ecommerce') {
            $price = $price->price;
            $result = formatNumber($price->price).'/'.$price->period.' '.\Str::plural($price->period_unit, $price->period);
        } else {
            $result = formatNumber($price->price).'/'.$price->period.' '.\Str::plural($price->period_unit, $price->period);
        }

        return $result;
    }

    public function getSubscriptionDatatable($status)
    {
        switch ($status) {
            case 'all':
                $subscriptions = $this::with('user', 'order')->where('recurrent', 1);
                break;
            case 'active':
                $subscriptions = $this::with('user', 'order')->where('recurrent', 1)->where('status', 'active');
                break;
            case 'inactive':
                $subscriptions = $this::with('user', 'order')->where('recurrent', 1)->where('status', '!=', 'active');
                break;
        }

        return Datatables::of($subscriptions)->addColumn('user', function ($row) {
            return "<img src='".$row->user->avatar()."' title='".$row->user->name."' class='user-avatar-50'><br><a href='".route('admin.userManage.detail', $row->user->id)."'>{$row->user->name}</a><br>({$row->user->email})";
        })->editColumn('order_id', function ($row) {
            return "<a href='".route('admin.purchase.order.detail', $row->order_id)."'>#{$row->order_id}</a>";
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('product_type', function ($row) {
            return moduleName($row->product_type);
        })->addColumn('product_name', function ($row) {
            return $row->getName();
        })->addColumn('price_detail', function ($row) {
            return '$'.$row->getRecurrentPrice();
        })->editColumn('status', function ($row) {
            if ($row->status === 'active') {
                $result = "<span class='c-badge c-badge-success'>".$row->status.'</span>';
            } else {
                $result = "<span class='c-badge c-badge-danger'>".ucfirst($row->status).'</span>';
            }

            return $result;
        })->addColumn('action', function ($row) {
            return '<a href="'.route('admin.purchase.subscription.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['user', 'order_id', 'status', 'action'])->make(true);
    }

    public function getUserSubscriptionDatatable()
    {
        $subscriptions = $this::with('user', 'order')
            ->where('recurrent', 1)
            ->where('user_id', user()->id);

        return Datatables::of($subscriptions)->editColumn('order_id', function ($row) {
            return "<a href='".route('user.purchase.order.detail', $row->order_id)."'>#{$row->order_id}</a>";
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('product_type', function ($row) {
            return moduleName($row->product_type);
        })->addColumn('product_name', function ($row) {
            return $row->getName();
        })->addColumn('price_detail', function ($row) {
            return '$'.$row->getRecurrentPrice();
        })->editColumn('status', function ($row) {
            if ($row->status === 'active') {
                $result = "<span class='c-badge c-badge-success'>".$row->status.'</span>';
            } else {
                $result = "<span class='c-badge c-badge-danger'>".ucfirst($row->status).'</span>';
            }

            return $result;
        })->addColumn('action', function ($row) {
            return '<a href="'.route('user.purchase.subscription.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['order_id', 'status', 'action'])->make(true);
    }
}
