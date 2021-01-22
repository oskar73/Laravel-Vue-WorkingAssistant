@extends('layouts.master')

@section('title', 'Blog Setting')
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
                    <span class="m-nav__link-text">Blog</span>
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
                       Blog  Setting
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body">
            <form action="{{route('admin.blog.setting.store')}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="guest_blog">
                                    Blog Posting Allow
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can choose blogging type."
                                    ></i>
                                </label>
                                <select class="form-control" name="guest_blog" id="guest_blog">
                                    <option value="free" @if($setting['permission']=='free') selected @endif>Free Posting Allow</option>
                                    <option value="paid" @if($setting['permission']=='paid') selected @endif>Only Paid Posting Allow</option>
                                    <option value="both" @if($setting['permission']=='both') selected @endif>Both Free and Paid Posting Allow</option>
                                    <option value="not" @if($setting['permission']=='not') selected @endif>Not Allow Any Post Now</option>
                                </select>
                                <div class="form-control-feedback error-guest_blog"></div>
                            </div>
                            <div class="post_number_area" style="display: @if($setting['permission']=='both'||$setting['permission']=='free'||$setting['permission']==null) block @else none @endif">
                                <div class="form-group">
                                    <label for="post_number">
                                        Free Posting Limit Number
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="When you allow free blogging to users, you can limit number per unit day."
                                        ></i>
                                    </label>
                                    <input type="number"
                                           class="form-control m-input m-input--square text-right"
                                           id="post_number" name="post_number"
                                           value="{{$setting['post_number']}}"
                                           autocomplete="off"
                                    >
                                    <div class="form-control-feedback error-post_number"></div>
                                </div>
                                <div class="form-group">
                                    <label for="period">
                                        Free Posting Period
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="When you allow free blogging to users, this is the unit day for limit posting."
                                        ></i>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right m-input--square" value="{{$setting['period']}}" name="period" id="period" autocomplete="off">
                                        <div class="input-group-append" style="width:150px;">
                                            <select class="form-control" name="period_unit" id="period_unit">
                                                <option value="day" @if($setting['period_unit']=='day') selected @endif>Day</option>
                                                <option value="week" @if($setting['period_unit']=='week') selected @endif>Week</option>
                                                <option value="month" @if($setting['period_unit']=='month') selected @endif>Month</option>
                                                <option value="year" @if($setting['period_unit']=='year') selected @endif>Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-control-feedback error-period"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="post_approve">
                                    Allow Blog Post without Admin Approve
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is blog posting approve system when users post new blog."
                                    ></i>
                                </label>
                                <select class="form-control" name="post_approve" id="post_approve">
                                    <option value="1" @if($setting['post_approve']==1) selected @endif>Allow</option>
                                    <option value="0" @if($setting['post_approve']==0) selected @endif>Not Allow</option>
                                </select>
                                <div class="form-control-feedback error-post_approve"></div>
                            </div>
                            <div class="form-group">
                                <label for="comment_approve">
                                    Allow Blog Comment without Admin Approve

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is comment approve system when users comment on blog."
                                    ></i>
                                </label>
                                <select class="form-control" name="comment_approve" id="comment_approve">
                                    <option value="1" @if($setting['comment_approve']==1) selected @endif>Allow</option>
                                    <option value="0" @if($setting['comment_approve']==0) selected @endif>Not Allow</option>
                                </select>
                                <div class="form-control-feedback error-comment_approve"></div>
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
    <script src="{{asset('assets/js/admin/blog/setting.js')}}"></script>
@endsection
