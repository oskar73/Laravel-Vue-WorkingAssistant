@extends('layouts.master')

@section('title', 'User Management')
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
                    <span class="m-nav__link-text">User Management</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">User Detail</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.userManage.index')}}" class="btn m-btn--square  btn-outline-info m-btn m-btn--custom">
            Back
        </a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-2 col-md-4">
            <div class="sidebar-tab">
                <div class="mb-3 text-center">
                    <img id="avatar" class="image_upload_output maxw-100 wh-200px m-auto" src="{{$user->avatar()}}"/>
                </div>

                <ul class="sidebar-tab-ul">
                    <li class="tab-item"><a class="tab-link tab-active" data-area="#profile" href="#/profile">Profile</a></li>

                    @activeModule(["simple_blog", "advanced_blog"])
                    <li class="tab-item">
                        <a class="tab-link" data-area="#blog" href="#/blog">
                            Blog Posts
                            @if($user->posts_count)<span class="count_area">({{$user->posts_count}})</span> @endif
                        </a>
                    </li>
                    @endactiveModule

                    @activeModule("blogAds")
                    <li class="tab-item">
                        <a class="tab-link" data-area="#blogAds" href="#/blogAds">
                            Blog Ads Listings
                            @if($user->blog_ads_listings_count)<span class="count_area">({{$user->blog_ads_listings_count}})</span> @endif
                        </a>
                    </li>
                    @endactiveModule
                    @activeModule("siteAds")
                    <li class="tab-item">
                        <a class="tab-link" data-area="#siteAds" href="#/siteAds">
                            Site Ads Listings
                            @if($user->site_ads_listings_count)<span class="count_area">({{$user->site_ads_listings_count}})</span> @endif
                        </a>
                    </li>
                    @endactiveModule
                    @activeModule("directory")
                    <li class="tab-item">
                        <a class="tab-link" data-area="#directory" href="#/directory">
                            Directory Listings
                            @if($user->directory_listings_count)<span class="count_area">({{$user->directory_listings_count}})</span> @endif
                        </a>
                    </li>
                    @endactiveModule
                    @activeModule("directoryAds")
                    <li class="tab-item">
                        <a class="tab-link" data-area="#directoryAds" href="#/directoryAds">
                            Directory Ads Listings
                            @if($user->directory_ads_listings_count)<span class="count_area">({{$user->directory_ads_listings_count}})</span> @endif
                        </a>
                    </li>
                    @endactiveModule
                </ul>
            </div>
        </div>
        <div class="col-lg-10 col-md-8">
            <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="profile_area">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Profile
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="form-group">
                                <label for="name">
                                    Name
                                    <i class="fa fa-info-circle tooltip_3" title="Name"></i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="name" id="name" value="{{$user->name}}" readonly>
                                <div class="form-control-feedback error-name"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    Email address
                                    <i class="fa fa-info-circle tooltip_3" title="Email Address"></i>
                                </label>

                                <div class="input-group m-input--square">
                                    <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <label class="m-checkbox m-checkbox--single m-checkbox--state m-checkbox--state-success mb-2">
                                                <input type="checkbox" name="verified" @if($user->email_verified_at) checked @endif onclick="return false;">
                                                <span></span>
                                            </label>
                                            &nbsp; Verified
                                        </span>
                                    </div>
                                </div>
                                <div class="form-control-feedback error-email"></div>
                            </div>
                            <div class="form-group">
                                <label for="timezone">
                                    Timezone
                                    <i class="fa fa-info-circle tooltip_3" title="Timezone"></i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="timezone" id="timezone" value="{{$user->timezone}}" readonly>
                                <div class="form-control-feedback error-timezone"></div>
                            </div>
                            <div class="form-group">
                                <label for="timeformat">Time Format:
                                    <i class="fa fa-info-circle tooltip_3"
                                       title="This is your time format.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="time_format" id="time_format" value="{{$user->timeformat}}" readonly>
                                <div class="form-control-feedback error-time_format"></div>
                            </div>
                            <div class="form-group">
                                <label for="roles" class="form-control-label">
                                    User Roles:
                                    <i class="fa fa-info-circle tooltip_3"
                                       title="This is user roles. Default users have 'user' role.">
                                    </i>
                                </label>
                                <select name="roles[]" id="roles" class="roles select2" multiple>
                                    <option ></option>
                                    <option value="admin" @if($user->hasRole('admin')) selected @else disabled @endif>Admin</option>
                                </select>
                                <div class="form-control-feedback error-appCats"></div>
                            </div>
                            <div class="text-right">
                                <a href="{{route('admin.userManage.edit', $user->id)}}" class="btn m-btn--square  btn-outline-success m-btn m-btn--custom">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @activeModule(["simple_blog", "advanced_blog"])
            <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="blog_area">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Blog
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>

                <div class="m-portlet__body">
{{--                    @include("components.admin.blogPostTable", ['selector'=>'datatable-all', 'user'=>0])--}}
                    Blog
                </div>
            </div>
            @endactiveModule
            @activeModule("blogAds")
            <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="blogAds_area">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Blog Advertisement
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>

                <div class="m-portlet__body">
{{--                    @include("components.admin.blogAdsListingTable", ['selector'=>'datatable-all', 'user'=>0])--}}
                    Blog Ads
                </div>
            </div>
            @endactiveModule
            @activeModule("siteAds")
            <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="siteAds_area">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Site Advertisement
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>

                <div class="m-portlet__body">
                    {{--                    @include("components.admin.blogAdsListingTable", ['selector'=>'datatable-all', 'user'=>0])--}}
                    Site Ads
                </div>
            </div>
            @endactiveModule
            @activeModule("directory")
            <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="directory_area">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Directory Listing
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>

                <div class="m-portlet__body">
                    {{--                    @include("components.admin.blogAdsListingTable", ['selector'=>'datatable-all', 'user'=>0])--}}
                    Directory Listing
                </div>
            </div>
            @endactiveModule
            @activeModule("directoryAds")
            <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="directoryAds_area">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Directory Advertisement
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>

                <div class="m-portlet__body">
                    {{--                    @include("components.admin.blogAdsListingTable", ['selector'=>'datatable-all', 'user'=>0])--}}
                    Directory Ads
                </div>
            </div>
            @endactiveModule
        </div>
    </div>
@endsection
@section('script')
    <script>var user_id="{{$user->id}}";</script>
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/admin/userManage/detail.js')}}"></script>
@endsection
