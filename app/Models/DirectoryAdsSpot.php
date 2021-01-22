<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DirectoryAdsSpot extends BaseModel implements HasMedia
{
    use Sluggable, InteractsWithMedia;
    use HasFactory;

    protected $table = 'directory_ads_spots';

    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function createRule($request)
    {
        $rule['name'] = 'required|string|max:45';
        $rule['description'] = 'max:3000';
        $rule['position_type'] = 'required|in:fixed,perpage';
        if ($request->position_type == 'perpage') {
            $rule['page_type'] = 'required|in:home,category,tag,detail';
            $rule['position_id'] = 'required|exists:directory_ads_positions,id,web_id,'.tenant('id');
            $rule['type'] = 'nullable|exists:directory_ads_types,id,status,1,web_id,'.tenant('id');

            if ($request->page_type == 'category') {
                $rule['category'] = 'required|exists:directory_categories,id,web_id,'.tenant('id');
            }
            if ($request->page_type == 'tag') {
                $rule['tag'] = 'required|exists:directory_tags:id,web_id,'.tenant('id');
            }
            if ($request->page_type == 'detail') {
                $rule['detail'] = 'required|exists:directory_categories,id,web_id,'.tenant('id');
            }
        }
        if (! $request->edit_id) {
            $rule['image'] = 'required|image|mimes:jpg,jpeg,png,gif|max:10240';
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
            $type = json_decode($this->type);

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

    public function storeItem($request)
    {
        $item = $this;
        $item->name = $request->name;
        $item->description = $request->description;
        if ($request->position_type == 'fixed') {
            $item->fixed_position = 1;
            $item->page = null;
            $item->page_id = null;
        } else {
            $item->fixed_position = 0;
            $item->page = $request->page_type;
            if ($request->page_type == 'category') {
                $item->page_id = $request->category;
            }
            if ($request->page_type == 'tag') {
                $item->page_id = $request->tag;
            }
            if ($request->page_type == 'detail') {
                $item->page_id = $request->detail;
            }
        }
        $item->position_id = $request->position_id;
        if ($request->type != null) {
            $item->type = DirectoryAdsType::whereStatus(1)->whereId($request->type)->firstorfail();
        }
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

    public function getPageName()
    {
        if ($this->fixed_position) {
            return 'Fixed Position through all pages';
        }

        if ($this->page == 'home') {
            return 'Directory Listing Home Page';
        } elseif ($this->page == 'category') {
            return $this->directoryCategory->name.' Category Home Page';
        } elseif ($this->page == 'tag') {
            return $this->directoryTag->name.' Tag Home Page';
        } else {
            return $this->directoryCategory->name.' Category Blog Detail Page';
        }
    }

    public function position()
    {
        return $this->belongsTo(DirectoryAdsPosition::class, 'position_id')->withDefault();
    }

    public function prices()
    {
        return $this->hasMany(DirectoryAdsPrice::class, 'spot_id');
    }

    public function approvedPrices()
    {
        return $this->hasMany(DirectoryAdsPrice::class, 'spot_id')->where('status', 1);
    }

    public function standardPrice()
    {
        return $this->hasOne(DirectoryAdsPrice::class, 'spot_id')
            ->where('status', 1)
            ->orderBy('standard', 'DESC');
    }

    public function directoryCategory()
    {
        return $this->belongsTo(DirectoryCategory::class, 'page_id')->withDefault();
    }

    public function directoryTag()
    {
        return $this->belongsTo(DirectoryTag::class, 'page_id')->withDefault();
    }

    public function gag()
    {
        return $this->hasOne(DirectoryAdsGag::class, 'spot_id')->withDefault();
    }

    public function listings()
    {
        return $this->hasMany(DirectoryAdsListing::class, 'spot_id');
    }

    public function approvedListings()
    {
        return $this->hasMany(DirectoryAdsListing::class, 'spot_id')->where('status', 'approved')->inRandomOrder();
    }

    public function currentSpots($type, $id)
    {
        $spots = null;
        switch ($type) {
            case 'home':
                $spots = $this->where(function ($query) {
                    $query->where('fixed_position', 0)->where('page', 'home');
                    $query->orWhere('fixed_position', 1);
                })
                    ->with('approvedListings.events', 'gag.media', 'approvedListings.media', 'position')
                    ->whereStatus(1)
                    ->get();
                break;
            case 'category':
                $spots = $this->where(function ($query) use ($id) {
                    $query->where('fixed_position', 0)->where('page', 'home')->where('page_id', $id);
                    $query->orWhere('fixed_position', 1);
                })
                    ->with('approvedListings.events', 'gag.media', 'approvedListings.media', 'position')
                    ->whereStatus(1)
                    ->get();
                break;
            case 'detail':
                $spots = $this->where(function ($query) use ($id) {
                    $query->where('fixed_position', 0)->where('page', 'detail')->where('page_id', $id);
                    $query->orWhere('fixed_position', 1);
                })
                    ->with('approvedListings.events', 'gag.media', 'approvedListings.media', 'position')
                    ->whereStatus(1)
                    ->get();
                break;
            case 'tag':
                $spots = $this->where(function ($query) use ($id) {
                    $query->where('fixed_position', 0)->where('page', 'tag')->where('page_id', $id);
                    $query->orWhere('fixed_position', 1);
                })
                    ->with('approvedListings.events', 'gag.media', 'approvedListings.media', 'position')
                    ->whereStatus(1)
                    ->get();
                break;
        }

        return $spots;
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
        $result['position_id'] = $this->position->position_id ?? 0;
        $result['type'] = $listing_type;
        $result['frame'] = view('components.front.directoryAds', compact('listing', 'listing_type', 'spot'))->render();

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

    public function filterItem()
    {
        try {
            $items = DirectoryAdsSpot::where('directory_ads_spots.status', 1)
                ->select(['directory_ads_spots.id', 'directory_ads_spots.name', 'directory_ads_spots.slug', 'directory_ads_spots.featured', 'directory_ads_spots.new', 'directory_ads_spots.description', 'directory_ads_spots.position_id', 'directory_ads_spots.page', 'directory_ads_spots.page_id', 'directory_ads_spots.type'])
                ->with('media', 'standardPrice', 'position')
                ->orderBy('order')
                ->orderBy('featured', 'DESC')
                ->orderBy('new', 'DESC')
                ->orderBy('directory_ads_spots.created_at', 'DESC')
                ->paginate(15);

            $view = view('components.front.directoryAdsSpotItem', compact('items'))->render();

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
