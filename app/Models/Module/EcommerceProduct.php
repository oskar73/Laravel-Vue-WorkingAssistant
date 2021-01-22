<?php

namespace App\Models\Module;

use App\Integration\Stripe;
use App\Models\BaseModel;
use App\Traits\Ratable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EcommerceProduct extends BaseModel implements HasMedia
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;
    use Ratable;

    protected $table = 'ecommerce_products';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = [
        'thumbnail'
    ];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function getThumbnailAttribute(): string {
        return $this->getFirstMediaUrl('thumbnail');
    }

    public function addToCartRule()
    {
        $rule['quantity'] = 'required|integer|min:1';
        if ($this->size) {
            $rule['size'] = "required|exists:ecommerce_sizes,id,product_id,{$this->id},web_id,".tenant('id');
        }
        if ($this->color) {
            $rule['color'] = "required|exists:ecommerce_colors,id,product_id,{$this->id},web_id,".tenant('id');
        }
        if ($this->variant) {
            $rule['size'] = "required|exists:ecommerce_variants,id,product_id,{$this->id},web_id,".tenant('id');
        }

        return $rule;
    }

    public function storeRule($request)
    {
        $rule['category'] = 'required|integer|exists:ecommerce_categories,id,web_id,'.tenant('id').',status,1';
        $rule['title'] = 'required|string|max:45';
        $rule['description'] = 'required|max:6000';
        $rule['order'] = 'required|in:1,0';

        $rule['images.*'] = 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240';
        $rule['videos.*'] = 'nullable|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400';
        if ($request->links) {
            $rule['links.*'] = 'required';
        }

        $rule['sku'] = 'nullable|string|max:191';
        $rule['barcode'] = 'nullable|string|max:191';
        $rule['visible_date'] = 'required|date';
        if ($request->track_quantity) {
            $rule['quantity'] = 'required|integer|min:0';
        }
        if ($request->type) {
            $rule['weight'] = 'required|numeric';
            $rule['weight_unit'] = 'required|in:lb,oz,kg,g';
        }
        if ($request->size) {
            $rule['sizes'] = 'required';
            $rule['sizes.*'] = 'required|max:191';
        }
        if ($request->color) {
            $rule['colors'] = 'required';
            $rule['colors.*'] = 'required|max:191';
        }
        if ($request->variant) {
            $rule['variants'] = 'required';
            $rule['variant_name'] = 'required|string|max:191';
            $rule['variants.*'] = 'required|max:191';
        }

        return $rule;
    }

    public function priceRule($request)
    {
        $rule['slashed_price'] = 'nullable|regex:/^\d+(\.\d{1,2})?$/';
        if ($request->edit_price == null) {
            $rule['payment_type'] = 'required|in:1,0';
            $rule['price'] = 'required|regex:/^\d+(\.\d{1,2})?$/';
            if ($request->payment_type == 1) {
                $rule['period'] = 'required|numeric|min:1';
                $rule['period_unit'] = 'required|in:day,week,month,year';
            }
        } else {
            $rule['price'] = 'nullable|regex:/^\d+(\.\d{1,2})?$/';
        }

        return $rule;
    }

    public function savePrice($request)
    {
        if ($request->edit_price == null) {
            return $this->createPrice($request);
        } else {
            return $this->updatePrice($request);
        }
    }

    public function createPrice($request)
    {
        $item = $this;
        $price['stripe'] = 1;
        $price['standard'] = 1;
        $price['status'] = $request->status ? 1 : 0;
        $price['price'] = $request->price;
        $price['slashed_price'] = $request->slashed_price;
        $price['recurrent'] = $request->payment_type;

        if ($request->payment_type == 1) {
            $stripe = new Stripe();
            $name = $item->title.', $'.formatNumber($request->price).'/'.periodName($request->period, $request->period_unit);
            $plan = $stripe->createPlan($request->period, $request->period_unit, $request->price, $name);

            $price['plan_id'] = $plan->id;
            $price['period'] = $request->period;
            $price['period_unit'] = $request->period_unit;
        }
        $result = $item->prices()->create($price);

        return $result;
    }

    public function updatePrice($request)
    {
        $item = $this;

        $itemPrice = $item->prices()
            ->where('id', $request->edit_price)
            ->where('standard', 1)
            ->firstorfail();
        $price['price'] = $request->price;
        $price['slashed_price'] = $request->slashed_price;
        $price['recurrent'] = $request->payment_type;

        $delete = 0;
        $delete_id = $itemPrice->plan_id;
        if ($request->payment_type == 0) {
            $price['period'] = null;
            $price['period_unit'] = null;
            $price['plan_id'] = null;
            if ($itemPrice->recurrent == 1) {
                $delete = 1;
            }
        } else {
            $price['period'] = $request->period;
            $price['period_unit'] = $request->period_unit;

            if ($itemPrice->price != $request->price || $itemPrice->period != $request->period || $itemPrice->period_unit != $request->period_unit) {
                $stripe = new Stripe();
                $name = $item->title.', $'.formatNumber($request->price).'/'.periodName($request->period, $request->period_unit);
                $plan = $stripe->createPlan($request->period, $request->period_unit, $request->price, $name);
                $price['plan_id'] = $plan->id;

                $delete = 1;
            } else {
                $price['plan_id'] = $itemPrice->plan_id;
            }
        }

        $itemPrice->update($price);

        if ($delete == 1) {
            try {
                $stripe = new Stripe();
                $stripe->deletePlan($delete_id);

                $item->prices()->where('id', '!=', $request->edit_price)
                    ->get()
                    ->each
                    ->delete();
            } catch (\Exception $e) {
                \Log::info(json_encode($e->getMessage()));
            }
        }

        return $item;
    }

    public function updateVariantPrice($request)
    {
        $color = $request->color == 0 ? null : $request->color;
        $size = $request->size == 0 ? null : $request->size;
        $variant = $request->variant == 0 ? null : $request->variant;

        $price = $this->prices()->where('color_id', $color)
            ->where('size_id', $size)
            ->where('variant_id', $variant)
            ->first();

        $standardPrice = $this->standardPrice;
        $stripe = new Stripe();
        if ($standardPrice->recurrent == 0) {
            if ($price == null) {
                $price = new EcommercePrice();
                $price->product_id = $this->id;
                $price->color_id = $color;
                $price->size_id = $size;
                $price->variant_id = $variant;
                $price->recurrent = 0;
                $price->period = null;
                $price->period_unit = null;
                $price->plan_id = null;
                $price->standard = 0;
            }
            $price->price = $request->price;
            $price->slashed_price = $request->slashed_price;
            $price->save();
        } else {
            if ($price == null) {
                if ($request->price != $standardPrice->price) {
                    $price = new EcommercePrice();
                    $price->product_id = $this->id;
                    $price->color_id = $color;
                    $price->size_id = $size;
                    $price->variant_id = $variant;
                    $price->recurrent = 1;
                    $price->period = $standardPrice->period;
                    $price->period_unit = $standardPrice->period_unit;

                    $name = $this->title.', $'.formatNumber($request->price).'/'.periodName($standardPrice->period, $standardPrice->period_unit);
                    $plan = $stripe->createPlan($standardPrice->period, $standardPrice->period_unit, $request->price, $name);

                    $price->plan_id = $plan->id;
                    $price->standard = 0;
                    $price->price = $request->price;
                    $price->slashed_price = $request->slashed_price;
                    $price->save();
                } else {
                    if ($request->slashed_price != $standardPrice->slashed_price) {
                        $price = new EcommercePrice();
                        $price->product_id = $this->id;
                        $price->color_id = $color;
                        $price->size_id = $size;
                        $price->variant_id = $variant;
                        $price->recurrent = 1;
                        $price->period = $standardPrice->period;
                        $price->period_unit = $standardPrice->period_unit;
                        $price->plan_id = $standardPrice->plan_id;
                        $price->standard = 0;
                        $price->price = $standardPrice->price;
                        $price->slashed_price = $request->slashed_price;
                        $price->save();
                    }
                }
            } else {
                if ($request->price == $standardPrice->price) {
                    $price->recurrent = 1;
                    $price->period = $standardPrice->period;
                    $price->period_unit = $standardPrice->period_unit;
                    $price->plan_id = $standardPrice->plan_id;
                    $price->standard = 0;
                    $price->price = $standardPrice->price;
                    $price->slashed_price = $request->slashed_price;
                    $price->save();
                } else {
                    if ($request->price != $price->price) {
                        $name = $this->title.', $'.formatNumber($request->price).'/'.periodName($standardPrice->period, $standardPrice->period_unit);
                        $plan = $stripe->createPlan($standardPrice->period, $standardPrice->period_unit, $request->price, $name);

                        $price->plan_id = $plan->id;
                        $price->price = $request->price;
                    }
                    $price->slashed_price = $request->slashed_price;
                    $price->save();
                }
            }
        }

        return $price;
    }

    public function storeItem($request)
    {
        return $this->saveItem($request)
            ->saveMedia($request);
    }

    public function saveItem($request)
    {
        $item = $this;
        $item->title = $request->title;
        $item->category_id = $request->category;
        $item->description = $request->description;

        if ($request->links !== null) {
            $item->links = json_encode($request->links);
        } else {
            $item->links = null;
        }

        $item->featured = $request->featured ? 1 : 0;
        $item->status = $request->status ? 1 : 0;
        $item->new = $request->new ? 1 : 0;
        $item->order = $request->order;
        $item->sku = $request->sku;
        $item->barcode = $request->barcode;
        $item->track_quantity = $request->track_quantity ? 1 : 0;
        if ($request->track_quantity) {
            $item->continue_selling = $request->continue_selling ? 1 : 0;
            $item->quantity = $request->quantity;
        } else {
            $item->continue_selling = 1;
            $item->quantity = 0;
        }
        $item->type = $request->type ? 'physical' : 'software';
        if ($request->type) {
            $item->weight = $request->weight;
            $item->weight_unit = $request->weight_unit;
        } else {
            $item->weight = 0;
        }
        $item->size = $request->size ? 1 : 0;
        $item->color = $request->color ? 1 : 0;
        $item->variant = $request->variant ? 1 : 0;
        if ($request->variant) {
            $item->variant_name = $request->variant_name;
        } else {
            $item->variant_name = null;
        }
        $item->visible_date = $request->visible_date;
        $item->save();

        $item->saveVariants($request);

        return $item;
    }

    public function saveVariants($request)
    {
        if ($request->size && $request->sizes) {
            foreach (array_unique(explode(',', $request->sizes)) as $size) {
                $new_size = EcommerceSize::where('product_id', $this->id)
                    ->where('name', $size)
                    ->first();
                if ($new_size == null) {
                    $new_size = new EcommerceSize();
                    $new_size->name = $size;
                    $new_size->product_id = $this->id;
                    $new_size->save();
                }
            }
        }

        if ($request->color && $request->colors) {
            foreach (array_unique(explode(',', $request->colors)) as $color) {
                $new_color = EcommerceColor::where('product_id', $this->id)
                    ->where('name', $color)
                    ->first();
                if ($new_color == null) {
                    $new_color = new EcommerceColor();
                    $new_color->name = $color;
                    $new_color->product_id = $this->id;
                    $new_color->save();
                }
            }
        }

        if ($request->variant && $request->variants) {
            foreach (array_unique(explode(',', $request->variants)) as $variant) {
                $new_variant = EcommerceVariant::where('product_id', $this->id)
                    ->where('name', $variant)
                    ->first();
                if ($new_variant == null) {
                    $new_variant = new EcommerceVariant();
                    $new_variant->name = $variant;
                    $new_variant->product_id = $this->id;
                    $new_variant->save();
                }
            }
        }
    }

    public function updateItem($request)
    {
        $item = $this->saveItem($request);
        $ids = $request->oldItems ?? [];
        if ($request->thumbnail !== null) {
            $collections = ['image', 'video', 'thumbnail'];
        } else {
            $collections = ['image', 'video'];
        }

        $item->media()
            ->whereNotIn('id', $ids)
            ->whereIn('collection_name', $collections)
            ->get()
            ->each
            ->delete();

        $item->saveMedia($request);

        return $item;
    }

    public function saveMedia($request)
    {
        if ($request->thumbnail !== null) {
            $this->addMediaFromBase64($request->thumbnail)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('thumbnail');
        }
        foreach ($request->images ?? [] as $image) {
            $this->addMedia($image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }
        foreach ($request->videos ?? [] as $video) {
            $this->addMedia($video)
                ->toMediaCollection('video');
        }

        return $this;
    }

    public function getAllVariants()
    {
        $sizes = $this->sizes->map(function ($item) {
            $item->type = 'size';

            return $item;
        })->toArray();
        $colors = $this->colors->map(function ($item) {
            $item->type = 'color';

            return $item;
        })->toArray();
        $variants = $this->variants->map(function ($item) {
            $item->type = 'variant';

            return $item;
        })->toArray();

        $result = [];
        if ($this->size && count($sizes)) {
            foreach ($sizes as $size) {
                if ($this->color && count($colors)) {
                    foreach ($colors as $color) {
                        if ($this->variants && count($variants)) {
                            foreach ($variants as $variant) {
                                array_push($result, $this->makeItem($size, $color, $variant));
                            }
                        } else {
                            array_push($result, $this->makeItem($size, $color, null));
                        }
                    }
                } else {
                    if ($this->variants && count($variants)) {
                        foreach ($variants as $variant) {
                            array_push($result, $this->makeItem($size, null, $variant));
                        }
                    } else {
                        array_push($result, $this->makeItem($size, null, null));
                    }
                }
            }
        } else {
            if ($this->color && count($colors)) {
                foreach ($colors as $color) {
                    if ($this->variants && count($variants)) {
                        foreach ($variants as $variant) {
                            array_push($result, $this->makeItem(null, $color, $variant));
                        }
                    } else {
                        array_push($result, $this->makeItem(null, $color, null));
                    }
                }
            } else {
                if ($this->variants && count($variants)) {
                    foreach ($variants as $variant) {
                        array_push($result, $this->makeItem(null, null, $variant));
                    }
                }
            }
        }

        return $result;
    }

    public function makeItem($size = null, $color = null, $variant = null)
    {
        $item['size_id'] = $size ? $size['id'] : 0;
        $item['color_id'] = $color ? $color['id'] : 0;
        $item['variant_id'] = $variant ? $variant['id'] : 0;
        $a = $size ? $size['name'] : '';
        $b = $color ? (' | '.$color['name']) : '';
        $c = $variant ? (' | '.$variant['name']) : '';
        $item['name'] = $a.$b.$c;

        return $item;
    }

    public function category()
    {
        return $this->belongsTo(EcommerceCategory::class, 'category_id')->withDefault();
    }

    public function colors()
    {
        return $this->hasMany(EcommerceColor::class, 'product_id');
    }

    public function sizes()
    {
        return $this->hasMany(EcommerceSize::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(EcommerceVariant::class, 'product_id');
    }

    public function prices()
    {
        return $this->hasMany(EcommercePrice::class, 'product_id');
    }

    public function standardPrice()
    {
        return $this->hasOne(EcommercePrice::class, 'product_id')->where('standard', 1)->withDefault();
    }

    public function scopeFrontVisible($query)
    {
        return $query->where('status', 1)->where(function ($q) {
            $q->where('visible_date', null);
            $q->orWhere('visible_date', '<=', now()->toDateString());
        });
    }

    public function filterItem($request)
    {
        try {
            $title = '<li class="breadcrumb-item"><a href="#/all">All Categories</a></li>';

            $category = null;

            if ($request->keyword == '') {
                if ($request->category === 'all') {
                    $filter_ids = EcommerceCategory::where(function ($query) {
                        $query->whereStatus(1)->whereParentId(0);
                    })
                        ->orWhere(function ($query) {
                            $query
                                ->where('parent_id', '!=', 0)
                                ->whereStatus(1)
                                ->whereHas('category', function ($query) {
                                    $query->whereStatus(1);
                                });
                        })
                        ->pluck('id')
                        ->toArray();

                    $query = EcommerceProduct::whereIn('category_id', $filter_ids);
                } else {
                    $category = EcommerceCategory::where('slug', $request->category)->first();

                    if ($category->parent_id === 0) {
                        $category_ids = $category->approvedSubCategories()->pluck('id')->toArray();
                        array_push($category_ids, $category->id);

                        $query = EcommerceProduct::whereIn('category_id', $category_ids);

                        $title .= "<li class='breadcrumb-item'><a href='#/{$category->slug}'>".$category->name.'</a></li>';
                    } else {
                        $query = EcommerceProduct::where('category_id', $category->id);

                        $title .= "<li class='breadcrumb-item'><a href='#/{$category->category->slug}'>{$category->category->name}</a></li><li class='breadcrumb-item active' ><a href='#/{$category->slug}'>{$category->name}</a></li>";
                    }
                }
            } else {
                $keyword = $request->keyword;
                $query = EcommerceProduct::where(function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%$keyword%");
                    $query->orwhere('description', 'LIKE', "%$keyword%");
                });

                $title = '<li class="breadcrumb-item"><a href="javascript:void(0);"> " '.$keyword.' "  search result</a></li>';
            }
            $query2 = $query->frontVisible()
                ->select(['ecommerce_products.id', 'ecommerce_products.title', 'ecommerce_products.slug', 'ecommerce_products.featured', 'ecommerce_products.new', 'ecommerce_products.description'])
                ->with(['media', 'standardPrice']);
            if ($request->orderBy === 'featured') {
                $items = $query2->orderBy('featured', 'DESC');
            } elseif ($request->orderBy === 'popular') {
                $items = $query2->orderBy('new', 'DESC');
            } else {
                $items = $query2->orderBy('new', 'DESC');
            }
            $items = $items->orderBy('ecommerce_products.created_at', 'DESC')->paginate(9);
            $view = view('components.front.ecommerceItem', compact('items', 'title', 'category'))->render();

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

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('thumbnail')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(40)
                    ->height(40)
                    ->sharpen(10)
                    ->nonQueued();
            });
        $this
            ->addMediaCollection('image')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(40)
                    ->height(40)
                    ->sharpen(10)
                    ->nonQueued();
            });
    }
}
