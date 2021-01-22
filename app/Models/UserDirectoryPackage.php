<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class UserDirectoryPackage extends BaseModel
{
    use HasFactory;

    protected $table = 'user_directory_packages';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function storeItemFromPurchase($item, $user, $orderItem)
    {
        for ($k = 0; $k < $item['quantity']; $k++) {
            $directoryPackage = new UserDirectoryPackage();
            $directoryPackage->user_id = $user->id;
            $directoryPackage->order_item_id = $orderItem->id;
            $directoryPackage->listing_number = $item['item']['listing_limit'];
            if ($orderItem->recurrent == 0) {
                $directoryPackage->status = 'active';
            } else {
                $directoryPackage->status = 'pending';
            }
            $directoryPackage->item = $item['item'];
            $directoryPackage->price = $item['parameter'];
            $directoryPackage->save();

            if ($item['item']['meeting'] == 1 && $item['item']->meetingSet()->exists()) {
                $meeting = new UserMeeting();
                $meeting->createUserMeeting($directoryPackage, $item['item'], $user);
            }
            if ($item['item']['form'] == 1 && $item['item']->getForm()->exists()) {
                $form = new UserForm();
                $form->createUserForm($directoryPackage, $item['item'], $user);
            }
        }
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getName()
    {
        return json_decode($this->item)->name ?? '';
    }

    public function getProperty($field = null)
    {
        $property = optional(json_decode($this->item)->property);

        if ($field) {
            return $property->$field;
        } else {
            return $property;
        }
    }

    public function isPossibleforListing()
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->listing_number == -1) {
            return true;
        }

        if ($this->listing_number - $this->current_number > 0) {
            return true;
        }

        return false;
    }

    public function checkMarkProperty($value)
    {
        return checkMark($this->getProperty($value));
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
            return $row->orderItem->getName();
        })->addColumn('payment', function ($row) {
            return $row->orderItem->recurrent == 1 ? 'Recurrent' : 'Onetime';
        })->addColumn('due_date', function ($row) {
            return $row->orderItem->due_date;
        })->editColumn('listing_number', function ($row) {
            $listing_number = $row->listing_number == -1 ? 'Unlimited' : $row->listing_number;

            return $listing_number.' / '.$row->current_number;
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('status', function ($row) {
            if ($row->status == 'active') {
                return '<span class="c-badge c-badge-success">Active</span>';
            } else {
                return '<span class="c-badge c-badge-info" >'.$row->status.'</span>';
            }
        })->addColumn('action', function ($row) {
            return '<a href="'.route('admin.purchase.directory.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>';
        })->rawColumns(['checkbox', 'user', 'order', 'status', 'action'])->make(true);
    }
}
