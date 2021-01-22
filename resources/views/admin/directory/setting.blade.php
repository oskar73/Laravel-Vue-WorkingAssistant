@extends('layouts.master')

@section('title', 'Directory Listing Setting')
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
                    <span class="m-nav__link-text">Directory Listing</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Setting</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Directory Listing  Setting
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body">
            <form action="{{route('admin.directory.setting.store')}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="allow_type">
                                    Directory Listing Allow
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can choose directory listing."
                                    ></i>
                                </label>
                                <select class="form-control" name="allow_type" id="allow_type">
                                    <option value="free" @if($setting['permission']=='free') selected @endif>Free Listing Allow</option>
                                    <option value="paid" @if($setting['permission']=='paid') selected @endif>Only Paid Listing Allow</option>
                                    <option value="both" @if($setting['permission']=='both') selected @endif>Both Free and Paid Listing Allow</option>
                                    <option value="not" @if($setting['permission']=='not') selected @endif>Not Allow Any Listing Now</option>
                                </select>
                                <div class="form-control-feedback error-allow_type"></div>
                            </div>
                            <div class="property_area mt-5" style="display: @if($setting['permission']=='both'||$setting['permission']=='free'||$setting['permission']==null) block @else none @endif">
                                <h5>Free Listing Properties</h5>
                                <hr>
                                <div class="row" x-data="{unlimit:'{{$setting['listing_number']==-1?1:0}}'}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="listing_number" class="form-control-label">
                                                Listing limit number:

                                                <i class="la la-info-circle tipso2"
                                                   data-tipso-title="What is this?"
                                                   data-tipso="This is directory listing limit number that users can put using this package."
                                                ></i>
                                            </label>
                                            <input type="number" class="form-control" name="listing_number" id="listing_number" x-bind:disabled="unlimit==1" value="{{$setting['listing_number']!=-1?$setting['listing_number']:''}}">
                                            <div class="form-control-feedback error-listing_number"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <br>
                                        <label class="m-checkbox m-checkbox--state-success">
                                            <input type="checkbox" name="unlimit" x-on:click="unlimit=unlimit==1?0:1" x-bind:checked="unlimit==1">
                                            Set Unlimit Listing Number

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="If you check this field, it will give unlimited listing privilege to users"
                                            ></i>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="m-checkbox m-checkbox--state-success">
                                            <input type="checkbox" name="allow_thumbnail" {{$setting['thumbnail']==1? 'checked':''}}>
                                            Allow to put thumbnail

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will allow for users to put their image"
                                            ></i>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="m-checkbox m-checkbox--state-success">
                                            <input type="checkbox" name="allow_social" {{$setting['social']==1? 'checked':''}}>
                                            Allow to put social media share links

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will allow for users to put their social media link"
                                            ></i>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="m-checkbox m-checkbox--state-success">
                                            <input type="checkbox" name="allow_featured" {{$setting['featured']==1? 'checked':''}}>
                                            Allow featured listings

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will allow for users to set featured listing. Featured listings will be searched first."
                                            ></i>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="m-checkbox m-checkbox--state-success">
                                            <input type="checkbox" name="allow_image" {{$setting['image']==1? 'checked':''}}>
                                            Allow to put image gallery

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will allow for users to put image gallery in listing detail."
                                            ></i>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="m-checkbox m-checkbox--state-success">
                                            <input type="checkbox" name="allow_links" {{$setting['links']==1? 'checked':''}}>
                                            Allow to put external video links

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will allow for users to put external video links."
                                            ></i>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="m-checkbox m-checkbox--state-success">
                                            <input type="checkbox" name="allow_videos" {{$setting['videos']==1? 'checked':''}}>
                                            Allow to upload custom videos

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will allow for users to upload custom videos."
                                            ></i>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="m-checkbox m-checkbox--state-success">
                                            <input type="checkbox" name="allow_tracking" {{$setting['tracking']==1? 'checked':''}}>
                                            Allow to track impression

                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will allow for users to see impression tracking data."
                                            ></i>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="listing_approve">
                                    Allow Listing without Admin Approve
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is listing approve system when users post new listing."
                                    ></i>
                                </label>
                                <select class="form-control" name="listing_approve" id="listing_approve">
                                    <option value="1" @if($setting['listing_approve']==1) selected @endif>Allow</option>
                                    <option value="0" @if($setting['listing_approve']==0) selected @endif>Not Allow</option>
                                </select>
                                <div class="form-control-feedback error-listing_approve"></div>
                            </div>
                            <div class="text-right mt-3">
                                <button type="submit" id="submit_btn" class="m-1 btn m-btn--square btn-outline-info m-btn m-btn--custom btn-bizinabox">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/directory/setting.js')}}"></script>
@endsection
