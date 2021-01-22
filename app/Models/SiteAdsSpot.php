<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SiteAdsSpot extends BaseModel implements HasMedia
{
    use Sluggable, InteractsWithMedia;

    protected $table = 'site_ads_spots';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'type' => 'json',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    const CUSTOM_VALIDATION_MESSAGE = [
        'position_id.required' => 'position field is required',
    ];

    const ADDTOCART_VALIDATION_MESSAGE = [
        'start.required' => 'Please pick listing event start date',
        'end.required' => 'Please pick listing event end date',
    ];

    public function addToCartRule($price)
    {
        $rule = [];
        if ($price->type === 'period') {
            $rule['end'] = 'required';
            $rule['start'] = 'required';
            $rule['start.*'] = 'required';
            $rule['end.*'] = 'required';
        }

        return $rule;
    }

    public function createRule($image = 1)
    {
        $rule['name'] = 'required|string|max:45';
        $rule['description'] = 'max:3000';
        if ($image == 1) {
            $rule['image'] = 'required|image|mimes:jpg,jpeg,png,gif|max:10240';
        } else {
            $rule['image'] = 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240';
        }

        return $rule;
    }

    public function createPriceRule($request)
    {
        $rule['price'] = 'required|regex:/^\d+(\.\d{1,2})?$/';
        $rule['slashed_price'] = 'nullable|regex:/^\d+(\.\d{1,2})?$/';
        $rule['payment_type'] = 'required|in:period,impression';
        if ($request->payment_type == 'period') {
            $rule['period'] = 'required|in:1,7,14,30';
        } else {
            $rule['impression'] = 'required|integer|min:1';
        }

        return $rule;
    }

    public function updateListingRule($request)
    {
        $rule['google_ads'] = 'required|in:0,1,-1';
        if ($request->google_ads == 1) {
            $rule['ads_google_code'] = 'required|max:6000';
        } elseif ($request->google_ads == 0) {
            $type = $this->parentType;

            if ($request->ads_image) {
                $rule['ads_image'] = 'required|mimes:jpeg,png,jpg,gif|dimensions:width='.$type->width.',height='.$type->height;
            }
            if ($type->title_char != 0) {
                $rule['ads_title'] = 'nullable|string|max:'.$type->title_char;
            }
            if ($type->text_char != 0) {
                $rule['ads_text'] = 'nullable|string|max:'.$type->text_char;
            }
            $rule['ads_url'] = 'required|max:191';
        }

        return $rule;
    }

    public function storeItem($request, $page, $type)
    {
        $item = $this;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->page_id = $page->id;
        $item->type_id = $type->id;
        $item->type = $type;
        $item->featured = $request->featured ? 1 : 0;
        $item->new = $request->new ? 1 : 0;
        $item->sponsored_visible = $request->sponsored_visible ? 1 : 0;
        $item->status = $request->status ? 1 : 0;
        $item->save();

        if ($request->image) {
            $item->clearMediaCollection('image')
                ->addMedia($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }

        return $item;
    }

    public function updateItem($request)
    {
        $item = $this;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->featured = $request->featured ? 1 : 0;
        $item->new = $request->new ? 1 : 0;
        $item->sponsored_visible = $request->sponsored_visible ? 1 : 0;
        $item->status = $request->status ? 1 : 0;
        $item->save();

        if ($request->image) {
            $item->clearMediaCollection('image')
                ->addMedia($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }

        return $item;
    }

    public function createPrice($request)
    {
        $data['type'] = $request->payment_type;
        $data['price'] = $request->price;
        if ($request->payment_type == 'period') {
            $data['period'] = $request->period;
            $data['impression'] = null;
        } else {
            $data['period'] = null;
            $data['impression'] = $request->impression;
        }
        $data['slashed_price'] = $request->slashed_price;
        $data['status'] = $request->status ? 1 : 0;
        $data['standard'] = $request->standard ? 1 : 0;

        if ($request->standard) {
            $this->prices()->whereStandard(1)->update(['standard' => 0]);
        }

        if ($request->edit_price) {
            $price = $this->prices()->where('id', $request->edit_price)
                ->update($data);
        } else {
            $price = $this->prices()->create($data);
        }

        return $price;
    }

    public function updateListing($request)
    {
        if ($request->google_ads == -1) {
            $this->gag->clearMediaCollection('image');
            $this->gag()->delete();
        } else {
            if ($request->google_ads == 1) {
                $data = [
                    'title' => null,
                    'text' => null,
                    'url' => null,
                    'google_ads' => 1,
                    'code' => $request->ads_google_code,
                ];
            } else {
                $data = [
                    'title' => $request->ads_title,
                    'text' => $request->ads_text,
                    'url' => $request->ads_url,
                    'google_ads' => 0,
                    'code' => null,
                ];
            }
            if ($this->gag()->exists()) {
                $this->gag->update($data);
            } else {
                $this->gag()->create($data);
            }
            if ($request->google_ads != 0 || ($request->google_ads == 0 && $request->ads_image)) {
                $this->gag->clearMediaCollection('image');
            }
            if ($request->google_ads == 0 && $request->ads_image) {
                $this->gag
                    ->addMedia($request->ads_image)
                    ->usingFileName(guid().'.jpg')
                    ->toMediaCollection('image');
            }
        }
    }

    public function getFrame()
    {
        $listings = $this->filterListings();
        $spot = $this;
        if (count($listings) == 0) {
            if ($this->gag()->exists()) {
                $listing = $this->gag;
                $listing_type = 'default';
            } else {
                return null;
            }
        } else {
            $listing = $listings[0];
            $listing_type = 'listing';
        }
        $result['position_id'] = $this->position_id;
        $result['type'] = $listing_type;
        $result['frame'] = view('components.front.siteAds', compact('listing', 'listing_type', 'spot'))->render();

        return $result;
    }

    public function getAdminFrame()
    {
        $listings = $this->filterListings();
        $spot = $this;
        if (count($listings) == 0) {
            $listing = $this->gag;
            $listing_type = 'default';
        } else {
            $listing = $listings[0];
            $listing_type = 'listing';
        }
        $result['position_id'] = $this->position_id;
        $result['type'] = $listing_type;
        $result['frame'] = view('components.front.siteAdsAdmin', compact('listing', 'listing_type', 'spot'))->render();

        return $result;
    }

    public function filterListings()
    {
        $now = Carbon::now()->toDateString();
        $listings = $this->approvedListings;
        $finalListings = [];
        foreach ($listings as $listing) {
            foreach ($listing->events as $event) {
                if ($event->start_date <= $now && ($event->end_date == null || $event->end_date >= $now)) {
                    $finalListings[] = $listing;
                    break;
                }
            }
        }

        return $finalListings;
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id')->withDefault();
    }

    public function parentType()
    {
        return $this->belongsTo(SiteAdsType::class, 'type_id')->withDefault();
    }

    public function prices()
    {
        return $this->hasMany(SiteAdsPrice::class, 'spot_id');
    }

    public function standardPrice()
    {
        return $this->hasOne(SiteAdsPrice::class, 'spot_id')
            ->where('status', 1)
            ->orderBy('standard', 'DESC');
    }

    public function approvedPrices()
    {
        return $this->hasMany(SiteAdsPrice::class, 'spot_id')->where('status', 1);
    }

    public function gag()
    {
        return $this->hasOne(SiteAdsGag::class, 'spot_id')->withDefault();
    }

    public function listings()
    {
        return $this->hasMany(SiteAdsListing::class, 'spot_id');
    }

    public function approvedListings()
    {
        return $this->hasMany(SiteAdsListing::class, 'spot_id')->where('status', 'approved')->inRandomOrder();
    }

    public function filterItem()
    {
        try {
            $items = SiteAdsSpot::where('site_ads_spots.status', 1)
                ->select('site_ads_spots.id', 'site_ads_spots.name', 'site_ads_spots.slug', 'site_ads_spots.featured', 'site_ads_spots.new', 'site_ads_spots.description', 'site_ads_spots.position_id', 'site_ads_spots.page_id', 'site_ads_spots.type_id')
                ->with('media', 'standardPrice', 'parentType', 'page')
                ->orderBy('order')
                ->orderBy('featured', 'DESC')
                ->orderBy('new', 'DESC')
                ->orderBy('site_ads_spots.created_at', 'DESC')
                ->paginate(15);

            $view = view('components.front.siteAdsSpotItem', compact('items'))->render();

            $data['status'] = 1;
            $data['view'] = $view;

            return $data;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(40)
            ->height(40)
            ->sharpen(10)
            ->nonQueued();
    }
}
