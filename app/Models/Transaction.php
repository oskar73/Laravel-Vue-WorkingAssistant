<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class Transaction extends BaseModel
{
    use HasFactory;

    protected $table = 'transactions';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'transaction_id')->withDefault();
    }

    public function refund()
    {
        return $this->hasOne(Refund::class, 'transaction_id')->withDefault();
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'agreement_id', 'agreement_id')->withDefault();
    }

    public function onetimeItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'agreement_id')->where('recurrent', 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function storeOnetimeCharge($cart, $user, $charge_id, $order, $gateway)
    {
        $transaction = $this;
        $transaction->user_id = $user->id;
        $transaction->charge_id = $charge_id;
        $transaction->agreement_id = $order->id;
        $transaction->amount = $cart->onetimeTotalPrice;
        $transaction->gateway = $gateway;
        $transaction->refunded = 0;
        $transaction->recurrent = 0;
        $transaction->save();

        return $transaction;
    }

    public function makeInvoice()
    {
        $invoice = new Invoice();
        $invoice->user_id = $this->user_id;
        $invoice->transaction_id = $this->id;
        $invoice->paid = 1;
        $invoice->file = 1;
        $invoice->save();

        $invoice->sendNotification();

        return $this;
    }

    public function storeSubscriptionCharge($charge_id, $agreement_id, $amount, $user_id, $gateway)
    {
        $transaction = $this;
        $transaction->charge_id = $charge_id;
        $transaction->agreement_id = $agreement_id;
        $transaction->amount = $amount;
        $transaction->user_id = $user_id;
        $transaction->gateway = $gateway;
        $transaction->recurrent = 1;
        $transaction->save();

        return $transaction;
    }

    public function getDatatable($status)
    {
        switch ($status) {
            case 'all':
                $transactions = $this::with('user', 'invoice');
                break;
            case 'onetime':
                $transactions = $this::with('user', 'invoice')->where('recurrent', 0);
                break;
            case 'recurrent':
                $transactions = $this::with('user', 'invoice')->where('recurrent', 1);
                break;
            case 'refunded':
                $transactions = $this::with('user', 'invoice', 'refund')->where('refunded', 1);
                break;
        }

        return Datatables::of($transactions)->addColumn('user', function ($row) {
            return "<img src='".$row->user->avatar()."' title='".$row->user->name."' class='user-avatar-50'><br><a href='".route('admin.userManage.detail', $row->user->id)."'>{$row->user->name}</a><br>({$row->user->email})";
        })->editColumn('gateway', function ($row) {
            if ($row->gateway == 'paypal') {
                return "<span class='c-badge c-badge-success'>{$row->gateway}</span>";
            } else {
                return "<span class='c-badge c-badge-info'>{$row->gateway}</span>";
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('amount', function ($row) {
            return '$'.formatNumber($row->amount);
        })->addColumn('invoice', function ($row) {
            return '<a href='.route('admin.purchase.transaction.invoice', $row->invoice->id ?? 0).'><i class="fa fa-file-invoice-dollar font-size30 text-dark"></i</a>';
        })->addColumn('action', function ($row) {
            return '<a href="" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['user', 'gateway', 'invoice', 'action'])->make(true);
    }

    public function getUserDatatable()
    {
        $transactions = $this::with('user', 'invoice')
            ->where('user_id', user()->id);

        return Datatables::of($transactions)->editColumn('gateway', function ($row) {
            if ($row->gateway == 'paypal') {
                return "<span class='c-badge c-badge-success'>{$row->gateway}</span>";
            } else {
                return "<span class='c-badge c-badge-info'>{$row->gateway}</span>";
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('amount', function ($row) {
            return '$'.formatNumber($row->amount);
        })->addColumn('invoice', function ($row) {
            return '<a href='.route('user.purchase.transaction.invoice', $row->invoice->id ?? 0).'><i class="fa fa-file-invoice-dollar font-size30 text-dark"></i</a>';
        })->addColumn('action', function ($row) {
            return '<a href="" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['gateway', 'invoice', 'action'])->make(true);
    }
}
