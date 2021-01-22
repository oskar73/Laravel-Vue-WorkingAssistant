<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Yajra\DataTables\DataTables;

class DirectoryAdsListing extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $table = 'directory_ads_listings';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [
        'start.required' => 'Please pick listing event start date',
        'end.required' => 'Please pick listing event end date',
    ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($obj) {
            if ($obj->status == 'expired') {
//                $obj->expiredNotification();
            }
        });
    }

    public function storeRule($request, $spot, $price)
    {
        $type = json_decode($spot->type);
        if ($request->image) {
            $rule['image'] = 'required|mimes:jpeg,png,jpg,gif|dimensions:width='.$type->width.',height='.$type->height;
        }
        if ($type->title_char != 0) {
            $rule['title'] = 'nullable|string|max:'.$type->title_char;
        }
        if ($type->text_char != 0) {
            $rule['text'] = 'nullable|string|max:'.$type->text_char;
        }
        $rule['url'] = 'nullable|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        if ($request->cta_check) {
            $rule['cta_url'] = 'required|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
            $rule['cta_type'] = 'required|in:buy_now,shop_now,visit_now,learn_more,join_now';
        }
        if ($price->type === 'period') {
            $rule['start'] = 'required';
            $rule['end'] = 'required';
            $rule['start.*'] = 'required';
            $rule['end.*'] = 'required';
        }
        $rule['status'] = 'required|in:approved,pending,denied,paid';
        $rule['notify_status'] = 'required|in:0,1,2';
        $rule['customer'] = 'required|exists:users,id,status,active,web_id,'.tenant('id');
        if ($request->notify_status != 0) {
            $rule['notification'] = 'required';
        }

        return $rule;
    }

    public function updateRule($request)
    {
        $type = json_decode($this->type);
        $price = json_decode($this->price);
        if ($request->image) {
            $rule['image'] = 'required|mimes:jpeg,png,jpg,gif|dimensions:width='.$type->width.',height='.$type->height;
        }
        if ($type->title_char != 0) {
            $rule['title'] = 'nullable|string|max:'.$type->title_char;
        }
        if ($type->text_char != 0) {
            $rule['text'] = 'nullable|string|max:'.$type->text_char;
        }
        $rule['url'] = 'nullable|max:191|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        if ($request->cta_check) {
            $rule['cta_url'] = 'required|max:191|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
            $rule['cta_type'] = 'required|in:buy_now,shop_now,visit_now,learn_more,join_now';
        }
        if ($price->type === 'period') {
            $rule['start'] = 'required';
            $rule['end'] = 'required';
            $rule['start.*'] = 'required';
            $rule['end.*'] = 'required';
        } else {
            $rule['impression_number'] = 'required|integer';
            $rule['current_number'] = 'required|integer';
        }
        $rule['status'] = 'required|in:approved,pending,denied,paid,expired';
        $rule['notify_status'] = 'required|in:0,1,2';
        $rule['customer'] = 'required|exists:users,id,status,active,web_id,'.tenant('id');
        if ($request->notify_status != 0) {
            $rule['notification'] = 'required';
        }

        return $rule;
    }

    public function updateUserRule($request)
    {
        $type = json_decode($this->type);
        if ($request->image) {
            $rule['image'] = 'required|mimes:jpeg,png,jpg,gif|dimensions:width='.$type->width.',height='.$type->height;
        }
        if ($type->title_char != 0) {
            $rule['title'] = 'nullable|string|max:'.$type->title_char;
        }
        if ($type->text_char != 0) {
            $rule['text'] = 'nullable|string|max:'.$type->text_char;
        }
        $rule['url'] = 'nullable|max:191|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        if ($request->cta_check) {
            $rule['cta_url'] = 'required|max:191|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
            $rule['cta_type'] = 'required|in:buy_now,shop_now,visit_now,learn_more,join_now';
        }

        return $rule;
    }

    public function storeItem($request, $spot, $price)
    {
        $type = json_decode($spot->type);
        $item = $this;
        $item->spot_id = $spot->id;
        $item->user_id = $request->customer;
        if ($type->title_char != 0) {
            $item->title = $request->title;
        }
        if ($type->text_char != 0) {
            $item->text = $request->text;
        }
        $item->url = $request->url;
        if ($request->cta_check) {
            $item->cta_action = 1;
            $item->cta_type = $request->cta_type;
            $item->cta_url = $request->cta_url;
        }
        $item->status = $request->status;
        $item->price = $price;
        $item->type = $spot->type;
        if ($price->type === 'impression') {
            $item->impression_number = $price->impression;
        }
        $item->save();
        if ($request->image) {
            $item->addMedia($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }

        return $item;
    }

    public function updateItem($request)
    {
        $item = $this;
        $type = json_decode($this->type);
        $price = json_decode($this->price);

        $item->user_id = $request->customer;
        if ($type->title_char != 0) {
            $item->title = $request->title;
        }
        if ($type->text_char != 0) {
            $item->text = $request->text;
        }
        $item->url = $request->url;
        if ($request->cta_check) {
            $item->cta_action = 1;
            $item->cta_type = $request->cta_type;
            $item->cta_url = $request->cta_url;
        } else {
            $item->cta_action = 0;
            $item->cta_type = null;
            $item->cta_url = null;
        }
        $item->status = $request->status;
        if ($price->type === 'impression') {
            $item->impression_number = $request->impression_number;
            $item->current_number = $request->current_number;
        }
        $item->save();
        if ($request->image) {
            $item->clearMediaCollection('image')
                ->addMedia($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }

        return $item;
    }

    public function updateUserItem($request)
    {
        $item = $this;
        $type = json_decode($this->type);
        if ($type->title_char != 0) {
            $item->title = $request->title;
        }
        if ($type->text_char != 0) {
            $item->text = $request->text;
        }
        $item->url = $request->url;
        if ($request->cta_check) {
            $item->cta_action = 1;
            $item->cta_type = $request->cta_type;
            $item->cta_url = $request->cta_url;
        } else {
            $item->cta_action = 0;
            $item->cta_type = null;
            $item->cta_url = null;
        }
        $item->status = 'pending';
        $item->save();

        if ($request->image) {
            $item->clearMediaCollection('image')
                ->addMedia($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }

        return $item;
    }

    public function storeEvents($starts, $ends)
    {
        $price = json_decode($this->price);
        $data = [];
        if ($price->type === 'period') {
            foreach ($starts as $key => $start) {
                $data[$key]['start_date'] = $start;
                $data[$key]['end_date'] = $ends[$key];
            }
        } else {
            $data[0]['start_date'] = Carbon::now()->toDateString();
            $data[0]['end_date'] = null;
        }
        foreach ($data as $datum) {
            $this->events()->create($datum);
        }

        return $this;
    }

    public function updateEvents($request)
    {
        $price = json_decode($this->price);
        if ($price->type === 'period') {
            $this->events()->delete();
            $this->storeEvents($request->start, $request->end);
        } else {
            if ($this->events()->count() == 0) {
                $this->storeEvents(now()->toDateString(), null);
            }
        }

        return $this;
    }

    public function storeItemFromPurchase($item, $user, $orderItem)
    {
        $price = json_decode($item['item']['price']);

        for ($k = 0; $k < $item['quantity']; $k++) {
            $listing = new DirectoryAdsListing();
            $listing->order_item_id = $orderItem->id;
            $listing->user_id = $user->id;
            $listing->spot_id = $item['item']['id'];
            $listing->price = $item['item']['price'];
            $listing->type = $item['item']['type'];
            $listing->status = 'paid';
            if ($price->type == 'impression') {
                $listing->impression_number = $item['parameter'];
            }
            $listing->save();

            if ($price->type == 'period') {
                $starts = $item['parameter']['start'];
                $ends = $item['parameter']['end'];
            } else {
                $starts = [];
                $ends = [];
            }
            $listing->storeEvents($starts, $ends);
        }
    }

    public function updateStatus($request)
    {
        $item = $this;
        $item->status = $request->status;
        $item->save();

        return $item;
    }

    public function track($request)
    {
        $track = new DirectoryAdsListingTrack();
        $track->listing_id = $this->id;
        $track->ip = $request->ip();
        $track->device = getOS();
        $track->save();

        return $track;
    }

    public function tracks()
    {
        return $this->hasMany(DirectoryAdsListingTrack::class, 'listing_id');
    }

    public function spot()
    {
        return $this->belongsTo(DirectoryAdsSpot::class, 'spot_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function position()
    {
        return $this->belongsTo(DirectoryAdsPosition::class, 'position_id')->withDefault();
    }

    public function events()
    {
        return $this->hasMany(DirectoryAdsEvent::class, 'listing_id')->orderBy('start_date');
    }

    public function getDatatable($status, $user)
    {
        switch ($status) {
            case 'pending':
                $listings = $this::with('user', 'spot', 'events')->where('status', 'pending');
                break;
            case 'all':
                $listings = $this::with('user', 'spot', 'events');
                break;
            case 'approved':
                $listings = $this::with('user', 'spot', 'events')->where('status', 'approved');
                break;
            case 'denied':
                $listings = $this::with('user', 'spot', 'events')->where('status', 'denied');
                break;
            case 'expired':
                $listings = $this::with('user', 'spot', 'events')->where('status', 'expired');
                break;
            case 'new':
                $listings = $this::with('user', 'spot', 'events')->where('status', 'new');
                break;
        }
        if ($user != 'all') {
            $listings = $listings->where('user_id', $user);
        }

        return Datatables::of($listings)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('spot', function ($row) {
            $result = "<a href=''>".$row->spot->name.'</a>';

            return $result;
        })->addColumn('page', function ($row) {
            return $row->spot->getPageName();
        })->addColumn('user', function ($row) {
            $result = "<a href=''>".$row->user->name.'</a>';

            return $result;
        })->addColumn('price', function ($row) {
            $price = json_decode($row->price);
            if ($price->type === 'impression') {
                $result = 'Total Impressions: '.$row->impression_number."<br> <a href='".route('admin.directoryAds.listing.tracking', $row->id)."' class='underline'>Current Impressions: {$row->current_number}</a>";
            } else {
                $result = 'Duration:<br>';
                foreach ($row->events as $event) {
                    $result .= $event->start_date.' ~ '.$event->end_date.'<br>';
                }
                $result .= "<a href='".route('admin.directoryAds.listing.tracking', $row->id)."' class='underline'>Current Impressions: {$row->current_number}</a>";
            }

            return $result;
        })->editColumn('status', function ($row) {
            if ($row->status == 'approved') {
                return '<span class="c-badge c-badge-success">Approved</span>';
            } elseif ($row->status == 'pending') {
                return '<span class="c-badge c-badge-info" >Pending</span>';
            } elseif ($row->status == 'denied') {
                return '<span class="c-badge c-badge-danger" >Denied</span>';
            } elseif ($row->status == 'paid') {
                return '<span class="c-badge c-badge-info" >Newly Paid</span>';
            } elseif ($row->status == 'expired') {
                return '<span class="c-badge c-badge-warning" >Expired</span>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('admin.directoryAds.listing.show', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('admin.directoryAds.listing.edit', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Edit">
                            <i class="la la-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3 switchOne" data-action="delete" title="Delete">
                            <i class="la la-remove"></i>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'page', 'user', 'price', 'spot', 'action'])
            ->make(true);
    }

    public function getUserDataTable()
    {
        $listings = $this::with('user', 'spot', 'events')->where('user_id', user()->id);

        return Datatables::of($listings)->addColumn('spot', function ($row) {
            $result = "<a href=''>".$row->spot->name.'</a>';

            return $result;
        })->addColumn('page', function ($row) {
            return $row->spot->getPageName();
        })->addColumn('price', function ($row) {
            $price = json_decode($row->price);
            if ($price->type === 'impression') {
                $result = 'Total Impressions: '.$row->impression_number."<br> <a href='".route('user.siteAds.tracking', $row->id)."'  class='underline'>Current Impressions: {$row->current_number}</a> ";
            } else {
                $result = 'Duration: <br>';
                foreach ($row->events as $event) {
                    $result .= $event->start_date.' ~ '.$event->end_date.'<br>';
                }
                $result .= "<a href='".route('user.siteAds.tracking', $row->id)."' class='underline'>Current Impressions: {$row->current_number}</a>";
            }

            return $result;
        })->editColumn('status', function ($row) {
            if ($row->status == 'approved') {
                return '<span class="c-badge c-badge-success">Approved</span>';
            } elseif ($row->status == 'pending') {
                return '<span class="c-badge c-badge-info" >Pending</span>';
            } elseif ($row->status == 'denied') {
                return '<span class="c-badge c-badge-danger" >Denied</span>';
            } elseif ($row->status == 'paid') {
                return '<span class="c-badge c-badge-info" >Newly Paid</span>';
            } elseif ($row->status == 'expired') {
                return '<span class="c-badge c-badge-warning" >Expired</span>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            if ($row->status == 'expired') {
                return '
                    <a href="'.route('user.directoryAds.detail', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>';
            } else {
                return '
                    <a href="'.route('user.directoryAds.detail', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('user.directoryAds.edit', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Edit">
                            <i class="la la-edit"></i>
                    </a>';
            }
        })->rawColumns(['checkbox', 'status', 'page', 'price', 'spot', 'action'])
            ->make(true);
    }
}
