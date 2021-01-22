@extends('layouts.master')

@section('title', 'Ecommerce Store Edit Product')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6 text-left">
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Ecommerce Store</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Edit Product</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.ecommerce.product.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-2 col-md-4">
            <div class="sidebar-tab">
                <ul class="sidebar-tab-ul py-0">
                    <li class="tab-item">
                        <a class="tab-link tab-active" data-area="#detail" href="#/detail">
                            1.Product Detail
                        </a>
                    </li>
                    <li class="tab-item">
                        <a class="tab-link" data-area="#price" href="#/price">
                            2.Price
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-10 col-md-8">

            <div class="tab_area area-active" id="detail_area">
                <form action="{{route('admin.ecommerce.product.updateProduct', $product->id)}}" id="submit_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <div class="form-group">
                                        <label for="title" class="form-control-label">
                                            Title:
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is title of this product. Max characters are 45."
                                            ></i>
                                        </label>
                                        <input type="text" class="form-control m-input--square" name="title" id="title" value="{{$product->title}}">
                                        <div class="form-control-feedback error-title"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="form-control-label">
                                            Description:
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is description about this product. Max characters are 6000"
                                            ></i>
                                        </label>
                                        <textarea class="form-control m-input--square minh-100" name="description" id="description">{{$product->description}}</textarea>
                                        <div class="form-control-feedback error-description"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <p class="font-size18 mb-0">Media</p>
                                    <div class="p-2" style="border:1px dashed grey;">
                                        <div class="form-group">
                                            <table class="table table-bordered table-item-center vertical-middle">
                                                <tbody id="image_area">
                                                    @foreach($product->getMedia('image') as $key=>$image)
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control m-input--square" value="{{$image->getUrl()}}" readonly>
                                                                <input type="hidden" name='oldItems[]' value="{{$image->id}}">
                                                            </td>
                                                            <td><img class='width-150' src="{{$image->getUrl()}}"/></td>
                                                            <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addImage">+ Add Image</a>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <table class="table table-bordered table-item-center vertical-middle">
                                                <tbody id="link_area">
                                                    @foreach($product->getLinks() as $key1=>$link)
                                                        <tr>
                                                            <td><input type="url" name='links[]' class="form-control m-input--square" value="{{$link}}"></td>
                                                            <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addLink">+ Add External Video Link</a>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <table class="table table-bordered table-item-center vertical-middle">
                                                <tbody id="video_area">
                                                    @foreach($product->getMedia('video') as $key2=>$video)
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control m-input--square" value="{{$video->getUrl()}}" readonly>
                                                                <input type="hidden" name='oldItems[]' value="{{$video->id}}">
                                                            </td>
                                                            <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addVideo">+ Upload Video</a>
                                            </table>
                                        </div>
                                        <div class="form-group m-form__group">
                                            <label for="example_input_full_name">
                                                Choose Gallery Order:
                                                <i class="la la-info-circle tipso2"
                                                   data-tipso-title="What is this?"
                                                   data-tipso="This is order which one of images and videos will be put first."
                                                ></i>
                                            </label>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="m-option">
                                                        <span class="m-option__control">
                                                            <span class="m-radio m-radio--brand m-radio--check-bold">
                                                                <input type="radio" name="order" value="1" @if($product->order==1) checked @endif>
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                        <span class="m-option__label">
                                                            <span class="m-option__head">
                                                                <span class="m-option__title">
                                                                    Image Gallery

                                                                    <hr/>

                                                                    Video Gallery
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="m-option">
                                                        <span class="m-option__control">
                                                            <span class="m-radio m-radio--brand m-radio--check-bold">
                                                                <input type="radio" name="order" value="0" @if($product->order==0) checked @endif>
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                        <span class="m-option__label">
                                                            <span class="m-option__head">
                                                                <span class="m-option__title">
                                                                     Video Gallery

                                                                    <hr/>

                                                                     Image Gallery

                                                                </span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <p class="font-size18 mb-2">Inventory</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sku" class="form-control-label">
                                                    SKU
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="This is Stock Keeping Unit. Optional"
                                                    ></i>
                                                </label>
                                                <input type="text" class="form-control m-input--square" name="sku" id="sku" value="{{$product->sku}}">
                                                <div class="form-control-feedback error-sku"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="barcode" class="form-control-label">
                                                    Barcode
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="This is barcode. ISBN, UPC, GTIN, etc. Optional"
                                                    ></i>
                                                </label>
                                                <input type="text" class="form-control m-input--square" name="barcode" id="barcode" value="{{$product->barcode}}">
                                                <div class="form-control-feedback error-barcode"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row"  x-data="{track:{{$product->track_quantity==1?'true':'false'}}}">
                                        <div class="col-md-6">
                                            <br>
                                            <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                                <input type="checkbox" name="track_quantity" x-bind:checked="track" x-on:click="track=!track"> Track quantity
                                                <i class="la la-info-circle tipso2"
                                                   data-tipso-title="What is this?"
                                                   data-tipso="This will track available quantity of this product."
                                                ></i>
                                                <span></span>
                                            </label> <br>

                                            <label class="m-checkbox m-checkbox--air m-checkbox--state-success" x-show="track">
                                                <input type="checkbox" name="continue_selling" {{$product->continue_selling==1?'checked':''}}> Continue selling when out of stock
                                                <i class="la la-info-circle tipso2"
                                                   data-tipso-title="What is this?"
                                                   data-tipso="This will allow selling even when out of stock."
                                                ></i>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" x-show="track">
                                                <label for="quantity" class="form-control-label">
                                                    Quantity:
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="This is available quantity."
                                                    ></i>
                                                </label>
                                                <input type="number" class="form-control m-input--square" name="quantity" id="quantity" value="{{$product->quantity}}">
                                                <div class="form-control-feedback error-quantity"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--mobile" x-data="{type:{{$product->type=='physical'?'true':'false'}}}">
                                <div class="m-portlet__body">
                                    <p class="font-size18 mb-2">Shipping</p>
                                    <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                        <input type="checkbox" name="type" x-bind:checked="type" x-on:click="type=!type">This is a physical product
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is type of product. If it's physical product, you can input weight. If it's software or non-physical product, you can skip weight."
                                        ></i>
                                        <span></span>
                                    </label>
                                    <div class="form-control-feedback error-type"></div>
                                    <hr>
                                    <div x-show="!type">
                                        Customers won’t enter their shipping address or choose a shipping method when buying this product.
                                    </div>
                                    <div class="row" x-show="type">
                                        <div class="col-md-6">
                                            <label for="weight" class="form-control-label">
                                                Weight
                                                <i class="la la-info-circle tipso2"
                                                   data-tipso-title="What is this?"
                                                   data-tipso="When payment type is recurrent, you can define how often it would be happened."
                                                ></i>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control text-right m-input--square" name="weight" id="weight" value="{{$product->weight}}">
                                                <div class="input-group-append" style="width:150px;">
                                                    <select class="form-control m-bootstrap-select selectpicker disable_item" name="weight_unit" id="weight_unit">
                                                        <option value="lb" @if($product->weight_unit==='lb') selected @endif>lb</option>
                                                        <option value="oz" @if($product->weight_unit==='oz') selected @endif>oz</option>
                                                        <option value="kg" @if($product->weight_unit==='kg') selected @endif>kg</option>
                                                        <option value="g" @if($product->weight_unit==='g') selected @endif>g</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-control-feedback error-weight_unit"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <p class="font-size18 mb-2">Variants</p>
                                    <div class="mb-3" x-data="{size:{{$product->size==1?'true':'false'}}}">
                                        <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                            <input type="checkbox" name="size" x-bind:checked="size" x-on:click="size=!size">This product has different sizes
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will enable you to add different sizes. You can put different prices according to different size in price page."
                                            ></i>
                                            <span></span>
                                        </label>
                                        <div x-show="size" class="p-2">
                                            <select multiple data-role="tagsinput" id="sizes" name="sizes[]">
                                                @foreach($product->sizes as $size)
                                                    <option value="{{$size->name}}" selected>{{$size->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-feedback error-sizes"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3" x-data="{color:{{$product->color==1?'true':'false'}}}">
                                        <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                            <input type="checkbox" name="color" x-bind:checked="color" x-on:click="color=!color">This product has different colors
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will enable you to add different colors. You can put different prices according to different colors in price page."
                                            ></i>
                                            <span></span>
                                        </label>
                                        <div x-show="color" class="p-2">
                                            <select multiple data-role="tagsinput" id="colors" name="colors[]">
                                                @foreach($product->colors as $color)
                                                    <option value="{{$color->name}}" selected>{{$color->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-feedback error-colors"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3" x-data="{variant:{{$product->variant==1?'true':'false'}}}">
                                            <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                                <input type="checkbox" name="variant" x-bind:checked="variant" x-on:click="variant=!variant">Add Custom Variant
                                                <i class="la la-info-circle tipso2"
                                                   data-tipso-title="What is this?"
                                                   data-tipso="This will enable you to add your custom variant.."
                                                ></i>
                                                <span></span>
                                            </label>
                                            <div class="p-2" x-show="variant">
                                                <div class="form-group">
                                                    <label for="variant_name" class="form-control-label">
                                                        Variant Name
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is name of your custom variant."
                                                        ></i>
                                                    </label>
                                                    <input type="text" class="form-control m-input--square" name="variant_name" id="variant_name" value="{{$product->variant_name}}">
                                                    <div class="form-control-feedback error-variant_name"></div>
                                                </div>
                                                <div>
                                                    <select multiple data-role="tagsinput" id="variants" name="variants[]">
                                                        @foreach($product->variants as $variant)
                                                            <option value="{{$variant->name}}" selected>{{$variant->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-control-feedback error-variants"></div>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <div class="form-group">
                                        <label for="footer" class="form-control-label">
                                            Choose Category:
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is category."
                                            ></i>
                                        </label>
                                        <select name="category" id="category" class="category" data-live-search="true" data-width="100%">
                                            <option value="" disabled selected>Choose Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" @if($product->category_id==$category->id) selected @endif>{{$category->name}}</option>
                                                @foreach($category->approvedSubCategories as $subcat)
                                                    <option value="{{$subcat->id}}" @if($product->category_id==$subcat->id) selected @endif>{{$category->name}} &rarr; {{$subcat->name}}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <div class="form-control-feedback error-category"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="featured" class="form-control-label">Featured?</label>
                                                <div>
                                                    <span class="m-switch m-switch--icon m-switch--info">
                                                        <label>
                                                            <input type="checkbox"  name="featured" id="featured" {{$product->featured==1?'checked':''}}>
                                                            <span></span>
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label for="new" class="form-control-label">New?</label>
                                                <div>
                                                    <span class="m-switch m-switch--icon m-switch--info">
                                                        <label>
                                                            <input type="checkbox"  name="new" id="new" {{$product->new==1?'checked':''}}>
                                                            <span></span>
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label for="status" class="form-control-label">
                                                    Active?
                                                </label>
                                                <div>
                                                    <span class="m-switch m-switch--icon m-switch--info">
                                                        <label>
                                                            <input type="checkbox" name="status" id="status" {{$product->status==1?'checked':''}}>
                                                            <span></span>
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <div class="form-group">
                                        <label for="visible_date" class="form-control-label">
                                            Visible Date

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is visible date of this product in onlinestore.The default visible date will be today."
                                            ></i>
                                        </label>
                                        <input type="text" name="visible_date" class="form-control m-input--square" id="visible_date" autocomplete="off" value="{{$product->visible_date}}" readonly>
                                        <div class="form-control-feedback error-visible_date"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <div class="form-group">
                                        <label for="thumbnail" class="form-control-label">
                                            Thumbnail

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is thumbnail of this product. Maximum image size is 10 MB."
                                            ></i>
                                        </label>
                                        <input type="file" accept="image/*" class="form-control m-input--square" id="thumbnail" >
                                        <div class="form-control-feedback error-thumbnail"></div>
                                        <img id="thumbnail_image" class="w-100" src="{{$product->getFirstMediaUrl("thumbnail")}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <a href="{{route('admin.ecommerce.product.index')}}" class="btn m-btn--square d-inline-block btn-outline-info mb-2">Back</a>
                                <button type="submit" class="btn m-btn--square btn-outline-success d-inline-block smtBtn mb-2">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab_area" id="price_area">

                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="get_price_area">
                            <div class="text-center">
                                <i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="priceModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <form id="addPriceModalForm" action="{{route('admin.ecommerce.product.createPrice', $product->id)}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="edit_price" name="edit_price">
                        <div class="row" x-data="{recurrent:false}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_type" class="form-control-label">
                                        Payment Type:

                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is payment type. You can choose either onetime or recurrent subscription payment."
                                        ></i>
                                    </label>
                                    <select name="payment_type" id="payment_type" class="payment_type selectpicker disable_item" data-width="100%" x-on:change="recurrent=!recurrent">
                                        <option value="1" >Recurrent</option>
                                        <option value="0" selected>Onetime</option>
                                    </select>
                                    <div class="form-control-feedback error-payment_type"></div>
                                </div>
                            </div>
                            <div class="col-md-6" x-show="recurrent">
                                <label for="period" class="form-control-label">
                                    Recurring Billing Cycle:

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="When payment type is recurrent, you can define how often it would be happened."
                                    ></i>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control text-right m-input--square disable_item" value="1" name="period" id="period">
                                    <div class="input-group-append" style="width:150px;">
                                        <select class="form-control m-bootstrap-select selectpicker disable_item" name="period_unit" id="period_unit">
                                            <option value="day">Day</option>
                                            <option value="week">Week</option>
                                            <option value="month" selected>Month</option>
                                            <option value="year">Year</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-control-feedback error-period"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-control-label">
                                        Price:
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is price of this package."
                                        ></i>
                                    </label>
                                    <input type="text" class="form-control price disable_item" name="price" id="price">
                                    <div class="form-control-feedback error-price"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slashed_price" class="form-control-label">
                                        Slashed Price:
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is slashed price of this package. Optional. You can give the better price to customers with this field."
                                        ></i>
                                    </label>
                                    <input type="text" class="form-control price" name="slashed_price" id="slashed_price">
                                    <div class="form-control-feedback error-slashed_price"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info m-btn m-btn--custom m-btn--square" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn m-btn--square m-btn btn-outline-success smtBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>var item_id = "{{$product->id}}"</script>
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendors/taginput/tagsinput.js')}}"></script>
    <script src="{{asset('assets/js/admin/ecommerce/productEdit.js')}}"></script>
@endsection
