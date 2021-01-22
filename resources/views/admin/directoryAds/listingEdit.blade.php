@extends('layouts.master')

@section('title', 'Directory Ads Listing Edit')
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
                    <span class="m-nav__link-text">Directory Ads</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="{{route('admin.directoryAds.listing.index')}}" class="m-nav__link">
                    <span class="m-nav__link-text">Listing</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Edit</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#detail" href="javascript:void(0);">Listing Detail</a></li>
        </ul>
    </div>
    <form action="{{route('admin.directoryAds.listing.update', $listing->id)}}" id="submitForm">
        @csrf
        <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="detail_area">
            <div class="m-portlet__body  px-3 px-md-5">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="lightgallery">
                            <a href="{{$listing->spot->getFirstMediaUrl("image")}}"
                               class="progressive replace h-cursor"
                            >
                                <img src="{{$listing->spot->getFirstMediaUrl("image", 'thumb')}}" alt="" class="preview w-100">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        {{$listing->spot->name}} <br><br>
                        {{$listing->spot->description}}
                    </div>
                </div>
                <div class="font-size20">Listing Detail</div>
                <div class="mt-3 border border-success p-2 pt-4">
                    <div class="row">
                        <div class="col-md-7 mb-2">
                            @php
                                $type = json_decode($listing->type);
                            @endphp
                            <div class="form-group">
                                <label for="image" class="form-control-label">Image ({{$type->width}}x{{$type->height}}px)</label>
                                <input type="file" accept="image/*" class="form-control m-input--square" id="image" name="image" data-target="image_preview">
                                <div class="form-control-feedback error-image"></div>
                                <img id="image_preview" class="border border-success mt-2" style="max-width:100%;width:{{$type->width}}px;height:{{$type->height}}px" src="{{$listing->getFirstMediaUrl("image")}}"/>
                            </div>
                            @if($type->title_char!==0)
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title ({{$type->title_char}} char):</label>
                                    <input type="text" class="form-control" name="title" id="title" maxlength="{{$type->title_char}}" value="{{$listing->title}}">
                                    <div class="form-control-feedback error-title"></div>
                                </div>
                            @endif
                            @if($type->text_char!==0)
                                <div class="form-group">
                                    <label for="text" class="form-control-label">Text ({{$type->text_char}} char):</label>
                                    <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="text" id="text" maxlength="{{$type->text_char}}">{{$listing->text}}</textarea>
                                    <div class="form-control-feedback error-text"></div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="url" class="form-control-label">URL (start with http:// or https://):</label>
                                <input type="url" class="form-control" name="url" id="url" value="{{$listing->url}}">
                                <div class="form-control-feedback error-url"></div>
                            </div>
                        </div>
                        <div class="col-md-5" x-data="{cta:{{$listing->cta_action? 'true': 'false'}}}">
                            <label class="m-checkbox m-checkbox--state-success">
                                <input type="checkbox" id="cta_check" name="cta_check" x-on:click="cta=!cta" @if($listing->cta_action) checked @endif>
                                Enable CTA LINK
                                <span></span>
                            </label>
                            <br>
                            <br>
                            <div class="cta_area" x-show="cta">
                                <div class="form-group">
                                    <label for="cta_url" class="form-control-label">CTA URL:</label>
                                    <input type="url" class="form-control" name="cta_url" id="cta_url" value="{{$listing->cta_url}}">
                                    <div class="form-control-feedback error-cta_url"></div>
                                </div>
                                <div class="form-group">
                                    <label for="cta_type" class="form-control-label">Select CTA Type:</label>
                                    <select name="cta_type" id="cta_type" class="form-control">
                                        <option value="buy_now" @if($listing->cta_type=='buy_now') selected @endif>Buy Now</option>
                                        <option value="shop_now" @if($listing->cta_type=='shop_now') selected @endif>Shop Now</option>
                                        <option value="visit_now" @if($listing->cta_type=='visit_now') selected @endif>Visit Now</option>
                                        <option value="learn_more" @if($listing->cta_type=='learn_more') selected @endif>Learn More</option>
                                        <option value="join_now" @if($listing->cta_type=='join_now') selected @endif>Join Now</option>
                                    </select>
                                    <div class="form-control-feedback error-cta_type"></div>
                                </div>
                            </div>

                            <hr>

                            @php
                              $price = json_decode($listing->price);
                            @endphp
                            <div class="mt-3 form-group">
                                <label>Price Option</label>
                                <div class="m-radio-list">
                                    <label class="m-radio m-radio--state-primary">
                                        <input type="radio" name="price" value="{{$price->id}}" checked>
                                        <p class="slashed_price_text d-inline-block mb-0 ml-0">${{$price->slashed_price}}</p> ${{$price->price}} / {{$price->type=='period'? numToDay($price->period) : $price->impression . " imps"}}
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3 form-group">
                                        <label for="status" class="form-control-label">Status:</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="approved" @if($listing->status=='approved') selected @endif>Approved</option>
                                            <option value="pending" @if($listing->status=='pending') selected @endif>Pending</option>
                                            <option value="denied" @if($listing->status=='denied') selected @endif>Denied</option>
                                            <option value="expired" @if($listing->status=='expired') selected @endif>Expired</option>
                                            <option value="paid" @if($listing->status=='paid') selected @endif>Newly Paid</option>
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
                                    <option value="{{$listing->user->id}}" selected>{{$listing->user->name}} ({{$listing->user->email}})</option>
                                </select>
                                <div class="form-control-feedback error-customer"></div>
                            </div>
                            @if($price->type=='impression')
                                <div class="impression_area row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="impression_number" class="form-control-label">Total Impression:</label>
                                            <input type="text" class="form-control" name="impression_number" id="impression_number" value="{{$listing->impression_number}}">
                                            <div class="form-control-feedback error-impression_number"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="current_number" class="form-control-label">Current Impression:</label>
                                            <input type="text" class="form-control" name="current_number" id="current_number" value="{{$listing->current_number}}">
                                            <div class="form-control-feedback error-current_number"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-5 text-right">
                                <a href="{{route('admin.directoryAds.listing.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                                <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    @if($price->type=='period')
                    <div class="calendar_area">
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
                                        @php
                                            $t_price = 0;
                                        @endphp
                                        <tbody id="dynamic_date_field">
                                            @foreach($listing->events as $key=>$event)
                                                <tr id="rowe{{$event->id}}" class="picked_row">
                                                    <td><input type="text" class="jgjformshow" name="start[]" id="starte{{$event->id}}" value="{{$event->start_date}}" readonly/></td>
                                                    <td><input type="text" name="end[]" class="jgjformshow" id="ende{{$event->id}}" value="{{$event->end_date}}" readonly/></td>
                                                    <td><input type="text" class="jgjformshow" name="priceval" id="pricee{{$event->id}}" value="{{ formatNumber($price->price)}}" readonly/></td>
                                                    <td><button type="button" data-id="e{{$event->id}}" data-price="{{$price->price}}" class="btn-danger btn btn-sm btn_remove">X</button></td>
                                                </tr>
                                                @php
                                                    $t_price +=$price->price;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="form-group text-right">
                                        <div class="font-size20">Total Price : $<span class="total_price">{{formatNumber($t_price?? 0)}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
                                <p>Administrator edited your blog advertisement listing. <br> Please check in detail by clicking below link.</p>
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
    <script>var g_price = @JSON($listing->price), g_type=@JSON($listing->type), t_price = "{{$t_price?? 0}}", listing_id = "{{$listing->id}}"</script>
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/admin/directoryAds/listingEdit.js')}}"></script>
    <script src="{{asset('assets/js/dev1/calendar-hover.js')}}"></script>
@endsection
