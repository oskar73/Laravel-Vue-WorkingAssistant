<?php

namespace App\Http\Controllers\Admin\DirectoryAds;

use App\Http\Controllers\Admin\AdminController;
use App\Models\DirectoryAdsEvent;
use App\Models\DirectoryAdsListing;
use App\Models\DirectoryAdsListingTrack;
use App\Models\DirectoryAdsPrice;
use App\Models\DirectoryAdsSpot;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Validator;

class ListingController extends AdminController
{
    public function __construct(DirectoryAdsListing $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'), request()->get('user'));
        }

        return view(self::$viewDir.'directoryAds.listing');
    }

    public function select()
    {
        $spots = DirectoryAdsSpot::where('status', 1)
            ->with('media', 'standardPrice', 'position')
            ->get();

        return view(self::$viewDir.'directoryAds.listingSelect', compact('spots'));
    }

    public function create(Request $request, $slug)
    {
        $spot = DirectoryAdsSpot::whereStatus(1)
            ->with('media', 'prices', 'position')
            ->whereSlug($slug)
            ->firstorfail();

        if ($spot->standardPrice == null) {
            return back()->with('error', "Sorry, price isn\'t set for this spot yet.");
        }

        if ($request->ajax()) {
            $start = $request->start;
            $end = $request->end;

            $events = DirectoryAdsEvent::join('directory_ads_listings', 'directory_ads_events.listing_id', 'directory_ads_listings.id')
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('directory_ads_events.start_date', [$start, $end]);
                    $q->orWhereBetween('directory_ads_events.end_date', [$start, $end]);
                })->where('directory_ads_listings.spot_id', $spot->id)
                ->select('directory_ads_events.id', 'directory_ads_events.start_date', 'directory_ads_events.end_date')
                ->get();
            $lists = [];
            foreach ($events as $event) {
                if ($event->start_date != null && $event->end_date != null) {
                    $lists[] = [
                        'id' => 'e'.$event->id,
                        'start' => $event->start_date.' 00:00:00',
                        'end' => $event->end_date.' 24:00:00',
                        'color' => '#ff0000',
                        'rendering' => 'background',
                        'allDay' => true,
                    ];
                }
            }

            return $lists;
        }

        return view(self::$viewDir.'directoryAds.listingCreate', compact('spot'));
    }

    public function store(Request $request, $id)
    {
        try {
            $spot = DirectoryAdsSpot::whereId($id)
                ->whereStatus(1)
                ->firstorfail();

            $price = DirectoryAdsPrice::whereId($request->price)
                ->whereSpotId($id)
                ->whereStatus(1)
                ->firstorfail();

            $validation = Validator::make(
                $request->all(),
                $this->model->storeRule($request, $spot, $price),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );

            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $item = $this->model->storeItem($request, $spot, $price)
                ->storeEvents($request->start, $request->end);

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
        $listing = $this->model->with('media', 'events', 'spot')
            ->whereId($id)
            ->firstorfail();

        return view(self::$viewDir.'directoryAds.listingShow', compact('listing'));
    }

    public function tracking($id)
    {
        $listing = $this->model->whereId($id)->firstorfail();
        if (request()->wantsJson()) {
            $tracking = new DirectoryAdsListingTrack();

            return $tracking->getUserDataTable($listing->id);
        }

        return view(self::$viewDir.'directoryAds.listingTracking', compact('listing'));
    }

    public function getChart($id)
    {
        $listing = $this->model->whereId($id)->firstorfail();

        $dates = [];
        $trackings = [];
        $devices = [];
        $device_sessions = [];
        $device_colors = [];

        $data1 = DirectoryAdsListingTrack::where('listing_id', $listing->id)
            ->selectRaw('count(id) as count, date(created_at) as "date"')
            ->groupBy('date')
            ->take(10)
            ->get()
            ->sortByDesc('date');

        foreach ($data1 as $item) {
            array_unshift($dates, $item->date);
            array_unshift($trackings, $item->count);
        }

        $data2 = DirectoryAdsListingTrack::where('listing_id', $listing->id)
            ->selectRaw('count(id) as count, device')
            ->groupBy('device')
            ->take(10)
            ->get()
            ->sortByDesc('device');

        foreach ($data2 as $item2) {
            $devices[] = $item2->device;
            $device_sessions[] = $item2->count;
            $device_colors[] = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

        $data['dates'] = $dates;
        $data['trackings'] = $trackings;
        $data['devices'] = $devices;
        $data['device_sessions'] = $device_sessions;
        $data['device_colors'] = $device_colors;

        return response()->json([
            'status' => 1,
            'data' => $data,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $listing = $this->model->whereId($id)
                ->firstorfail();
            $validation = Validator::make($request->all(), $listing->updateStatusRule($request));

            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }

            $item = $listing->updateStatus($request);

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

    public function edit(Request $request, $id)
    {
        $listing = $this->model->with('media', 'events', 'spot')
            ->whereId($id)
            ->firstorfail();

        if ($request->ajax()) {
            $start = $request->start;
            $end = $request->end;

            $events = DirectoryAdsEvent::join('directory_ads_listings', 'directory_ads_events.listing_id', 'blog_ads_listings.id')
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('directory_ads_events.start_date', [$start, $end]);
                    $q->orWhereBetween('directory_ads_events.end_date', [$start, $end]);
                })->where('directory_ads_listings.spot_id', $listing->spot_id)
                ->select('directory_ads_events.id', 'directory_ads_events.start_date', 'directory_ads_events.end_date', 'directory_ads_events.listing_id')
                ->get();
            $lists = [];
            foreach ($events as $event) {
                if ($event->start_date != null && $event->end_date != null) {
                    if ($event->listing_id == $listing->id) {
                        $lists[] = [
                            'id' => 'e'.$event->id,
                            'start' => $event->start_date.' 00:00:00',
                            'end' => $event->end_date.' 24:00:00',
                            'color' => '#b3ffb3',
                            'rendering' => 'background',
                            'allDay' => true,
                        ];
                    } else {
                        $lists[] = [
                            'id' => 'e'.$event->id,
                            'start' => $event->start_date.' 00:00:00',
                            'end' => $event->end_date.' 24:00:00',
                            'color' => '#ff0000',
                            'rendering' => 'background',
                            'allDay' => true,
                        ];
                    }
                }
            }

            return $lists;
        }

        return view(self::$viewDir.'directoryAds.listingEdit', compact('listing'));
    }

    public function update(Request $request, $id)
    {
        try {
            $listing = $this->model->whereId($id)
                ->firstorfail();

            $validation = Validator::make(
                $request->all(),
                $listing->updateRule($request),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );

            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $item = $listing->updateItem($request)
                ->updateEvents($request);

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

    public function switchListing(Request $request)
    {
        try {
            $action = $request->action;

//            $notification = new NotificationTemplate();
            $slug = '';
            $notify = 0;

            $listings = $this->model->with('user')
                ->whereIn('id', $request->ids)
                ->get();

            if ($action === 'approve') {
                $listings->each->update(['status' => 'approved', 'reason' => null]);
//                $slug= $notification::BLOG_ADS_APPROVED;
                $notify = 1;
            } elseif ($action === 'deny') {
                $listings->each->update(['status' => 'denied', 'reason' => $request->reason]);
                $data['reason'] = $request->reason;
//                $slug= $notification::BLOG_ADS_DENIED;
                $notify = 1;
            } elseif ($action === 'pending') {
                $listings->each->update(['status' => 'pending']);
            } elseif ($action === 'expired') {
                $listings->each->update(['status' => 'expired']);
            } elseif ($action === 'paid') {
                $listings->each->update(['status' => 'paid']);
            } elseif ($action === 'delete') {
                $listings->each->delete();
            }

//            if($notify==1)
//            {
//                foreach($listings as $listing)
//                {
//                    $data['url'] = route('user.directoryAds.detail', $listing->id);
//                    $data['username'] = $listing->user->name;
//                    $notification->sendNotification($data, $slug, $listing->user);
//                }
//            }
            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
