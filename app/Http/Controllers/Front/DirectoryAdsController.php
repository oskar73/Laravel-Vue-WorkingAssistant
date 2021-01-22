<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Integration\Cart;
use App\Models\DirectoryAdsEvent;
use App\Models\DirectoryAdsListing;
use App\Models\DirectoryAdsPrice;
use App\Models\DirectoryAdsSpot;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Validator;

class DirectoryAdsController extends Controller
{
    public $model;

    public function __construct(DirectoryAdsSpot $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->model->filterItem();

            return response()->json($result);
        }

        $seo = $this->getSeo();

        return view('frontend.directoryAds.index', compact('seo'));
    }

    public function getData(Request $request)
    {
        try {
            $type = $request->type;
            $id = $request->id;

            $spots = $this->model->currentSpots($type, $id);

            $result = [];

            foreach ($spots as $spot) {
                $result[] = $spot->getFrame();
            }

            return response()->json([
                'status' => 1,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => json_encode($e->getMessage()),
            ]);
        }
    }

    public function spot(Request $request, $slug)
    {
        $spot = $this->model->whereStatus(1)
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
                })
                ->where('directory_ads_listings.spot_id', $spot->id)
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

        $seo['meta_title'] = $spot->name;
        $seo['meta_description'] = extractDesc($spot->description);
        $seo['meta_keywords'] = extractKeyWords($spot->description);
        $seo['meta_image'] = $spot->getFirstMediaUrl('image');

        return view('frontend.directoryAds.spot', compact('spot', 'seo'));
    }

    public function addtocart(Request $request, $id)
    {
        try {
            $spot = $this->model->whereId($id)
                ->whereStatus(1)
                ->firstorfail();

            $price = DirectoryAdsPrice::whereId($request->price)
                ->whereSpotId($id)
                ->whereStatus(1)
                ->firstorfail();

            $validation = Validator::make($request->all(), $spot->addToCartRule($price), $this->model::ADDTOCART_VALIDATION_MESSAGE);

            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            if ($price->type === 'impression') {
                $itemPrice = $price->price;
                $parameter = $price->impression;
            } else {
                $itemPrice = count($request->start) * $price->price;
                $parameter['start'] = $request->start;
                $parameter['end'] = $request->end;
            }

            $spot->price = $price;

            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            $cart->add($spot, route('directoryAds.spot', $spot->slug), 1, $itemPrice, 'directoryAds', $spot->getFirstMediaUrl('image'), 0, $spot->name, $parameter);

            Session::put('cart', $cart);

            return response()->json([
                'status' => 1,
                'data' => tenant()->getHeader(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function impClick(Request $request)
    {
        try {
            $id = $request->get('id');
//            if(!Session::has("blogAds-impclick-" . $id))
//            {
            Session::put('directoryAds-impclick-'.$id, true);

            $listing = DirectoryAdsListing::whereStatus('approved')
                ->whereId($id)
                ->firstorfail();

            $listing->current_number++;
            $listing->save();

            $listing->track($request);

            if (json_decode($listing->price)->type == 'impression') {
                if ($listing->current_number >= $listing->impression_number) {
                    $listing->status = 'expired';
                    $listing->save();

                    $event = $listing->events()->first();
                    if ($event != null) {
                        $event->end_date = Carbon::now()->toDateString();
                        $event->save();
                    }
                }
            }
//            }

            return response()->json([
                'status' => 1,
                'data' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function getSeo()
    {
        $data = optional(Page::firstOrCreate([
            'type' => 'module',
            'url' => 'directoryAds',
        ])->data);

        $seo['meta_title'] = $data['meta_title'];
        $seo['meta_description'] = extractDesc($data['meta_description']);
        $seo['meta_keywords'] = $data['meta_keywords'];
        $seo['meta_image'] = $data['meta_image'];

        return $seo;
    }
}
