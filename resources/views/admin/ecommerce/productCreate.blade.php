@extends('layouts.master')

@section('title', 'Ecommerce Store Add Product')
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
                    <span class="m-nav__link-text">Add Product</span>
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
                        <a class="tab-link tab-active" href="#">
                            1.Product Detail
                        </a>
                    </li>
                    <li class="tab-item">
                        <a class="tab-link" href="#" onclick="itoastr('info', 'Please submit product detail first.')">
                            2.Price Detail
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-10 col-md-8">

            <form action="{{route('admin.ecommerce.product.store')}}" id="submit_form" method="post" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control m-input--square" name="title" id="title">
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
                                    <textarea class="form-control m-input--square minh-100" name="description" id="description"></textarea>
                                    <div class="form-control-feedback error-description"></div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__body">
                                <p class="font-size18 mb-0">Media</p>
                                <div class="p-2" style="border:1px dashed grey;">
                                    <div class="form-group">
                                        <table class="table table-bordered table-item-center">
                                            <tbody id="image_area">

                                            </tbody>
                                            <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addImage">+ Add Image</a>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <table class="table table-bordered table-item-center">
                                            <tbody id="link_area">

                                            </tbody>
                                            <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addLink">+ Add External Video Link</a>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <table class="table table-bordered table-item-center">
                                            <tbody id="video_area">

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
                                                            <input type="radio" name="order" value="1" checked>
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
                                                            <input type="radio" name="order" value="0">
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
                                            <input type="text" class="form-control m-input--square" name="sku" id="sku">
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
                                            <input type="text" class="form-control m-input--square" name="barcode" id="barcode">
                                            <div class="form-control-feedback error-barcode"></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row"  x-data="{track:true}">
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
                                            <input type="checkbox" name="continue_selling"> Continue selling when out of stock
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
                                            <input type="number" class="form-control m-input--square" name="quantity" id="quantity" value="0">
                                            <div class="form-control-feedback error-quantity"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet m-portlet--mobile" x-data="{type:true}">
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
                                            <input type="text" class="form-control text-right m-input--square" name="weight" id="weight">
                                            <div class="input-group-append" style="width:150px;">
                                                <select class="form-control m-bootstrap-select selectpicker disable_item" name="weight_unit" id="weight_unit">
                                                    <option value="lb">lb</option>
                                                    <option value="oz">oz</option>
                                                    <option value="kg" selected>kg</option>
                                                    <option value="g">g</option>
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
                                <div class="mb-3" x-data="{size:false}">
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
                                        </select>
                                        <div class="form-control-feedback error-sizes"></div>
                                    </div>
                                </div>
                                <div class="mb-3" x-data="{color:false}">
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
                                        </select>
                                        <div class="form-control-feedback error-colors"></div>
                                    </div>
                                </div>
                                <div class="mb-3" x-data="{variant:false}">
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
                                                <input type="text" class="form-control m-input--square" name="variant_name" id="variant_name">
                                                <div class="form-control-feedback error-variant_name"></div>
                                            </div>
                                            <div>
                                                <select multiple data-role="tagsinput" id="variants" name="variants[]">
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
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @foreach($category->approvedSubCategories as $subcat)
                                                <option value="{{$subcat->id}}">{{$category->name}} &rarr; {{$subcat->name}}</option>
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
                                                        <input type="checkbox"  name="featured" id="featured">
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
                                                        <input type="checkbox"  name="new" id="new">
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label for="status" class="form-control-label">
                                                Active?
                                                <i class="la la-info-circle tipso2"
                                                   data-tipso-title="What is this?"
                                                   data-tipso="The status of this product will be inactive until you set price."
                                                ></i>
                                            </label>
                                            <div>
                                                <span class="m-switch m-switch--icon m-switch--info">
                                                    <label>
                                                        <input type="checkbox" disabled name="status" id="status">
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
                                    <input type="text" name="visible_date" class="form-control m-input--square" id="visible_date" autocomplete="off" value="{{now()->toDateString()}}" readonly>
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
                                    <img id="thumbnail_image" class="w-100"/>
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
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendors/taginput/tagsinput.js')}}"></script>
    <script src="{{asset('assets/js/admin/ecommerce/productCreate.js')}}"></script>
@endsection
