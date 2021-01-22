@extends('layouts.master')

@section('title', 'Coupon')
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
                    <span class="m-nav__link-text">Coupon</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success createBtn mb-2">Create</a>
    </div>
@endsection

@section('content')
    <div class="tab_btn_area text-center">
        <div class="show_checked d-none">
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn" data-action="active">Active</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn " data-action="inactive">Inactive</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn " data-action="delete">Delete</a>
        </div>
    </div>
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#active" href="#/active"> Active Coupons (<span class="active_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#inactive" href="#/inactive"> Inactive Coupons (<span class="inactive_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#used" href="#/used"> User Coupon Usage (<span class="used_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="active_area">
        <div class="m-portlet__body">
            @include("components.admin.couponTable", ['selector'=>'datatable-active'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="inactive_area">
        <div class="m-portlet__body">
            @include("components.admin.couponTable", ['selector'=>'datatable-inactive'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="used_area">
        <div class="m-portlet__body">
            @include("components.admin.couponTable", ['selector'=>'datatable-used'])
        </div>
    </div>

    <div class="modal fade" id="item_modal" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Coupon Setting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <form id="item_modal_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="item_id" id="item_id">
                        <div class="form-group">
                            <label for="name" class="form-control-label">Name:

                                <i class="la la-info-circle tooltip_icon"
                                   title='{{$tooltip[1]}}'
                                   data-page="{{$view_name}}"
                                   data-id="1"
                                ></i>

                            </label>
                            <input type="text" class="form-control m-input--square" name="name" id="name" autocomplete="off">
                            <div class="form-control-feedback error-name"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" style="position:relative;">
                                    <label for="code" class="form-control-label"> Code:

                                        <i class="la la-info-circle tooltip_icon"
                                           title='{{$tooltip[2]}}'
                                           data-page="{{$view_name}}"
                                           data-id="2"
                                        ></i>

                                    </label>
                                    <div class="input-group m-input-group">
                                        <input type="text" class="form-control m-input" name="code" id="code" autocomplete="off">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0);" id="generateCode" class="generateCode btn m-btn--square  btn-outline-info">Generate</a>
                                        </div>
                                    </div>
                                    <div class="form-control-feedback error-code"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount">
                                        Discount

                                        <i class="la la-info-circle tooltip_icon"
                                           title='{{$tooltip[3]}}'
                                           data-page="{{$view_name}}"
                                           data-id="3"
                                        ></i>

                                    </label>
                                    <div class="input-group m-input-group">
                                        <input type="text" class="form-control m-input text-right" name="discount" placeholder="10.00" id="discount" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                    </div>
                                    <div class="form-control-feedback error-discount"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">Choose Product Type

                                <i class="la la-info-circle tooltip_icon"
                                   title='{{$tooltip[4]}}'
                                   data-page="{{$view_name}}"
                                   data-id="4"
                                ></i>

                            </label>
                            <select class="form-control m-input select_picker" name="type" id="type">
                                <option value="all" selected>All Products</option>
                                <option value="package">Package</option>
                                <option value="readymade">Ready Made BIZ</option>
                                <option value="module">Module</option>
                                <option value="plugin">Plugin</option>
                                <option value="service">Service</option>
                                <option value="lacarte">A La Carte</option>
                                <option value="blog">Blog Package</option>
                                <option value="blogAds">Blog Advertisement</option>
                            </select>
                            <div class="form-control-feedback error-type"></div>
                        </div>
                        <div class="form-group product_area d-none">
                            <label for="product">Choose Product

                                <i class="la la-info-circle tooltip_icon"
                                   title='{{$tooltip[5]}}'
                                   data-page="{{$view_name}}"
                                   data-id="5"
                                ></i>

                            </label>
                            <select class="form-control m-input select_picker" name="product" id="product">
                                <option value="all" selected>All Products</option>
                            </select>
                            <div class="form-control-feedback error-product"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user">Choose User

                                        <i class="la la-info-circle tooltip_icon"
                                           title='{{$tooltip[6]}}'
                                           data-page="{{$view_name}}"
                                           data-id="6"
                                        ></i>

                                    </label>
                                    <select class="form-control m-input select_picker" name="user" id="user" data-live-search="true">
                                        <option value="0" selected>All Users</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-feedback error-user"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expire_date">Choose Expire Date

                                        <i class="la la-info-circle tooltip_icon"
                                           title='{{$tooltip[7]}}'
                                           data-page="{{$view_name}}"
                                           data-id="7"
                                        ></i>

                                    </label>
                                    <input type="text" class="form-control" id="expire_date" readonly="" name="expire_date" placeholder="Select date &amp; time">
                                    <div class="form-control-feedback error-expire_date"></div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reusable">Reusable

                                        <i class="la la-info-circle tooltip_icon"
                                           title='{{$tooltip[8]}}'
                                           data-page="{{$view_name}}"
                                           data-id="8"
                                        ></i>

                                    </label>
                                    <select class="form-control m-input select_picker" name="reusable" id="reusable">
                                        <option value="0" selected>Onetime</option>
                                        <option value="1">Reusable</option>
                                    </select>
                                    <div class="form-control-feedback error-reusable"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Status

                                        <i class="la la-info-circle tooltip_icon"
                                           title='{{$tooltip[9]}}'
                                           data-page="{{$view_name}}"
                                           data-id="9"
                                        ></i>

                                    </label>
                                    <select class="form-control m-input select_picker" name="status" id="status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="form-control-feedback error-status"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group notify_area d-none">
                            <label class="image_label"> Send Notification?

                                <i class="la la-info-circle tooltip_icon"
                                   title='{{$tooltip[10]}}'
                                   data-page="{{$view_name}}"
                                   data-id="10"
                                ></i>

                            </label>
                            <select name="notify" id="notify" class="form-control ">
                                <option value="0" selected>No</option>
                                <option value="1" >Yes (Default Notification)</option>
                                <option value="2" >Yes (Custom Notification)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn m-btn--square btn-outline-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn m-btn--square btn-outline-info smtBtn">Submit</button>
                    </div>

                    <div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Custom Notification</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">X</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <textarea name="notification" id="notification">
                                            <h3>Hello {username}!</h3>
                                            <p>Administrator created coupon code for you. <br><br> Coupon code: {coupon}. <br>
                                            <br> Please use this code for next payment.<br> It will discount {discount}% your total price.</p>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn m-btn--square btn-outline-primary save_btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/coupon/index.js')}}"></script>
@endsection
