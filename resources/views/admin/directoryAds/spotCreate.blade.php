@extends('layouts.master')

@section('title', 'Directory Listing Ads Spot Create')
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
                    <span class="m-nav__link-text">Directory Listing Ads</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="{{route('admin.directoryAds.spot.index')}}" class="m-nav__link">
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
            <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Price</a></li>
            <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Default Listing</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.directoryAds.spot.store')}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-control-label">
                                Name:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is name of this spot"></i>
                            </label>
                            <input type="text" class="form-control" name="name" id="name" >
                            <div class="form-control-feedback error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">
                                Description:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is description about spot spot"></i>
                            </label>
                            <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="description" id="description"></textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>

                        <div class="form-group">
                            <label for="position_type" class="form-control-label">
                                Spot Position Type:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is type of blog spot. If it's fixed, this spot will be remain on selected position through all directory pages and if it's different per page, then it will remain on only specific page."></i>
                            </label>
                            <select name="position_type" id="position_type" class="non_search_select2">
                                <option ></option>
                                <option value="fixed">Fixed through all directory pages</option>
                                <option value="perpage">Different per page</option>
                            </select>
                            <div class="form-control-feedback error-page_type"></div>
                        </div>
                        <div class="form-group page_type_area d-none d-none-when-fixed">
                            <label for="page_type" class="form-control-label">
                                Page Type:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is type of blog ads spot, where it will be put at."></i>
                            </label>
                            <select name="page_type" id="page_type" class="non_search_select2">
                                <option ></option>
                                <option value="home">Directory Listing Home Page</option>
                                <option value="category">Directory Listing Category Home Page</option>
                                <option value="tag">Directory Listing Tag Home Page</option>
                                <option value="detail">Directory Listing Detail Page</option>
                            </select>
                            <div class="form-control-feedback error-page_type"></div>
                        </div>
                        <div class="form-group d-none category_area page_area d-none-when-fixed">
                            <label for="category" class="form-control-label">
                                Directory Listing Category Home Page:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is specific category page name where blog ads will be put at"></i>
                            </label>
                            <select name="category" id="category" class="non_search_select2" >
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @foreach($category->approvedSubCategories as $cat)
                                        <option value="{{$cat->id}}">&nbsp; &rarr; {{$cat->name}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-category"></div>
                        </div>
                        <div class="form-group d-none tag_area page_area d-none-when-fixed">
                            <label for="tag" class="form-control-label">
                                Directory Listing Tag Home Page:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is specific tag name where blog ads will be put at"></i>
                            </label>
                            <select name="tag" id="tag" class="non_search_select2" >
                                <option ></option>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-tag"></div>
                        </div>

                        <div class="form-group d-none detail_area page_area d-none-when-fixed">
                            <label for="detail" class="form-control-label">
                                Directory Listing Detail Page:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is specific category name where blog ads will be put at"></i>
                            </label>
                            <select name="detail" id="detail" class="non_search_select2" >
                                <option ></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}} Category Directory Listing Detail Pages</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-detail"></div>
                        </div>
                        <div class="form-group">
                            <label for="position_name">
                                Select Ads Position

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is blog ads position"></i>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control m-input" id="position" name="position" readonly>
                                <input type="hidden" id="position_id" name="position_id">
                                <div class="input-group-append">
                                    <span class="btn btn-success" id="select_position">Select Position</span>
                                </div>
                            </div>
                            <div class="form-control-feedback error-position_id"></div>
                            <div class="preview_position"></div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="form-control-label">
                                Select Ads Type

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is type of blog ads"></i>
                            </label>
                            <select name="type" id="type" class="non_search_select2">
                                <option ></option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}} (Width: {{$type->width}}px, Height: {{$type->height}}px, Title Char: {{$type->title_char}}, Text Char: {{$type->text_char}})</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-type"></div>
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
                                       data-tipso="Until you set price, it will be disabled."></i>
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
                    <a href="{{route('admin.directoryAds.spot.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Next</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="position_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Position</h5> <br>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="position_area">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/directoryAds/spotCreate.js')}}"></script>
@endsection
