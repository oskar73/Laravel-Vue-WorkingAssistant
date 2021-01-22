@extends('layouts.master')

@section('title', 'Site Advertisement Spot Create')
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
                    <span class="m-nav__link-text">Site Advertisement</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="{{route('admin.siteAds.spot.index')}}" class="m-nav__link">
                    <span class="m-nav__link-text">Spot</span>
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
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Spot Detail</a></li>
            <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Default Listing</a></li>
            <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Price</a></li>
            <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Position</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.siteAds.spot.store', ['page_id'=>$page->id, 'type_id'=>$type->id])}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="page" class="form-control-label">
                                Page:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is name of site ads page "></i>
                            </label>
                            <input type="text" class="form-control" name="page" id="page" value="{{$page->name}}" readonly>
                            <div class="form-control-feedback error-page"></div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="form-control-label">
                                Type:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is site ads type "></i>
                            </label>
                            <input type="text" class="form-control" name="type" id="type" value="{{$type->name}} ({{$type->width}} x {{$type->height}})" readonly>
                            <div class="form-control-feedback error-type"></div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-control-label">
                                Name:
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is name of blog ads spot"></i>
                            </label>
                            <input type="text" class="form-control" name="name" id="name" >
                            <div class="form-control-feedback error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">
                                Description:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is description about blog ads spot"></i>
                            </label>
                            <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="description" id="description"></textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thumbnail" class="form-control-label">
                                Screenshot

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is screenshot about blog ads spot"></i>
                            </label>
                            <input type="file" accept="image/*" class="form-control m-input--square uploadImageBox" id="thumbnail" name="image" data-target="thumbnail_image">
                            <div class="form-control-feedback error-thumbnail"></div>
                            <img id="thumbnail_image" class="w-100"/>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label for="featured" class="form-control-label">
                                    Featured?

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will set a spot featured"></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" name="featured" id="featured">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="new" class="form-control-label">
                                    New?
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will set a spot new"></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox"  name="new" id="new">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="sponsored_visible" class="form-control-label">
                                    Sponsored Link Visible?

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will set visible sponsored link button"></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" checked name="sponsored_visible" id="sponsored_visible">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="status" class="form-control-label">Approve?
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="Until you set price and position, it will be disabled."></i>
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
                <div class="text-right mt-4">
                    <a href="{{route('admin.siteAds.spot.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Next</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/siteAds/spotCreate.js')}}"></script>
@endsection
