@extends('layouts.master')

@section('title', 'Site Advertisement Listing Create')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendors/lightgallery/css/lightgallery.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/calendar/fullcalendar.css')}}">
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
                    <span class="m-nav__link-text">Site Advertisement</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="{{route('admin.siteAds.listing.index')}}" class="m-nav__link">
                    <span class="m-nav__link-text">Listing</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Create</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link" href="{{route('admin.siteAds.listing.select')}}">Select Spot</a></li>
            <li class="tab-item"><a class="tab-link tab-active" data-area="#detail" href="javascript:void(0);">Listing Detail</a></li>
        </ul>
    </div>
    <form action="{{route('admin.siteAds.listing.store', $spot->id)}}" id="submitForm">
        @csrf
        <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="detail_area">
            <div class="m-portlet__body  px-3 px-md-5">
               <div class="row">
                   <div class="col-md-3 mb-3">
                       <div class="lightgallery">
                           <a href="{{$spot->getFirstMediaUrl("image")}}"
                              class="progressive replace h-cursor"
                           >
                            <img src="{{$spot->getFirstMediaUrl("image", 'thumb')}}" alt="" class="preview w-100">
                           </a>
                       </div>
                   </div>
                   <div class="col-md-9">
                        {{$spot->name}} <br><br>
                        {{$spot->description}}
                   </div>
               </div>
                <div class="font-size20">Listing Detail</div>
                <div class="mt-3 border border-success p-2 pt-4">
                   <div class="row">
                        <div class="col-md-7 mb-2">
                            @php
                                $type = $spot->parentType;
                            @endphp
                                <div class="form-group">
                                    <label for="image" class="form-control-label">Image ({{$type->width}}x{{$type->height}}px)</label>
                                    <input type="file" accept="image/*" class="form-control m-input--square" id="image" name="image" data-target="image_preview">
                                    <div class="form-control-feedback error-image"></div>
                                    <img id="image_preview" class="border border-success mt-2" style="max-width:100%;width:{{$type->width}}px;height:{{$type->height}}px"/>
                                </div>
                            @if($type->title_char!==0)
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title ({{$type->title_char}} char):</label>
                                    <input type="text" class="form-control" name="title" id="title" maxlength="{{$type->title_char}}">
                                    <div class="form-control-feedback error-title"></div>
                                </div>
                            @endif
                            @if($type->text_char!==0)
                                <div class="form-group">
                                    <label for="text" class="form-control-label">Text ({{$type->text_char}} char):</label>
                                    <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="text" id="text" maxlength="{{$type->text_char}}"></textarea>
                                    <div class="form-control-feedback error-text"></div>
                                </div>
                            @endif
                                <div class="form-group">
                                    <label for="url" class="form-control-label">URL (start with http:// or https://):</label>
                                    <input type="url" class="form-control" name="url" id="url" >
                                    <div class="form-control-feedback error-url"></div>
                                </div>
                        </div>
                        <div class="col-md-5" x-data="{cta:false}">
                            <label class="m-checkbox m-checkbox--state-success">
                                <input type="checkbox" id="cta_check" name="cta_check" x-on:click="cta=!cta">
                                Enable CTA LINK
                                <span></span>
                            </label>
                            <br>
                            <br>
                            <div class="cta_area" x-show="cta">
                                <div class="form-group">
                                    <label for="cta_url" class="form-control-label">CTA URL:</label>
                                    <input type="url" class="form-control" name="cta_url" id="cta_url" >
                                    <div class="form-control-feedback error-cta_url"></div>
                                </div>
                                <div class="form-group">
                                    <label for="cta_type" class="form-control-label">Select CTA Type:</label>
                                    <select name="cta_type" id="cta_type" class="form-control">
                                        <option value="buy_now">Buy Now</option>
                                        <option value="shop_now">Shop Now</option>
                                        <option value="visit_now">Visit Now</option>
                                        <option value="learn_more">Learn More</option>
                                        <option value="join_now">Join Now</option>
                                    </select>
                                    <div class="form-control-feedback error-cta_type"></div>
                                </div>
                            </div>

                            <hr>
                            <div class="mt-3 form-group">
                                <label>Price Option</label>
                                <div class="m-radio-list">
                                    @foreach($spot->prices as $price)
                                        <label class="m-radio m-radio--state-primary">
                                            <input type="radio" name="price" value="{{$price->id}}" @if($price->standard) checked @endif data-price="{{$price}}">
                                            <p class="slashed_price_text d-inline-block mb-0 ml-0">${{$price->slashed_price}}</p> ${{$price->price}} / {{$price->getUnit()}}
                                            <span></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3 form-group">
                                        <label for="status" class="form-control-label">Status:</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="approved">Approved</option>
                                            <option value="pending">Pending</option>
                                            <option value="denied">Denied</option>
                                            <option value="expired">Expired</option>
                                            <option value="paid">Newly Paid</option>
                                        </select>
                                        <div class="form-control-feedback error-status"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-3 form-group">
                                        <label for="notify_status" class="form-control-label">Send Notification</label>
                                        <select name="notify_status" id="notify_status" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes (Default Notification) </option>
                                            <option value="2">Yes (Custom Notification) </option>
                                        </select>
                                        <div class="form-control-feedback error-notify_status"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 form-group">
                                <label for="customer" class="form-control-label">Choose Customer</label>
                                <select name="customer" id="customer" class="select2 m-select2">
                                    <option value="{{user()->id}}" selected>{{user()->name}} ({{user()->email}})</option>
                                </select>
                                <div class="form-control-feedback error-customer"></div>
                            </div>
                            <div class="mt-5 text-right">
                                <a href="{{route('admin.siteAds.listing.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                                <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="calendar_area mt-3">
                    <div class="row">
                        <div class="col-md-8">
                           <div id="calendar"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="m-alert m-alert--outline m-alert--square alert alert-info alert-dismissible fade show" role="alert">
                                Select Period
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table ajaxTable datatable">
                                    <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Price ($)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dynamic_date_field">
                                    </tbody>
                                </table>
                                <div class="form-group text-right">
                                    <div class="font-size20">Total Price : $<span class="total_price">0.00</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            <textarea name="notification" id="notification" >
                                <h3>Hello {username}!</h3>
                                <p>Administrator created blog advertisement listing for you. <br> Please check in detail by clicking below link.</p>
                            </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn m-btn--square btn-outline-primary" data-dismiss="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/lightgallery/js/lightgallery-all.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/calendar/fullcalendar.js') }}"></script>
    <script>var g_price = `<?php echo json_encode($spot->standardPrice); ?>`, width="{{$spot->parentType->width}}", height="{{$spot->parentType->height}}", slug = "{{$spot->slug}}"</script>
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/admin/siteAds/listingCreate.js')}}"></script>
    <script src="{{asset('assets/js/dev1/calendar-hover.js')}}"></script>
@endsection
