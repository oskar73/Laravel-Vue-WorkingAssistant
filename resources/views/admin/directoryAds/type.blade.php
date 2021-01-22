@extends('layouts.master')

@section('title', 'Directory Listing Ads Type')
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
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Type</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success createBtn mb-2">Add New Type</a>
    </div>
@endsection

@section('content')
    <div class="tab_btn_area text-center">
        <div class="show_checked d-none">
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn" data-action="active">Active</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-primary switchBtn " data-action="inactive">Inactive</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn " data-action="delete">Delete</a>
        </div>
    </div>
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Types (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#active" href="#/active"> Active Types (<span class="active_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#inactive" href="#/inactive"> InActive Types (<span class="inactive_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="active_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="inactive_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="modal fade" id="create_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ads Type</h5> <br>
                    <select class="form-control" id="recommend" name="recommend" style="width:300px;margin-left:auto;">

                    </select>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <form id="create_modal_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="type_id" id="type_id"/>

                        <div class="form-group">
                            <label for="name" class="form-control-label">Name:</label>
                            <input type="text" class="form-control m-input--square" name="name" id="name">
                            <div class="form-control-feedback error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Description:</label>
                            <textarea class="form-control m-input--square minh-100" name="description" id="description"></textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width" class="form-control-label">Image Width
                                    </label>
                                    <input type="text" class="form-control m-input--square change_pam" name="width" id="width" autocomplete="off">
                                    <div class="form-control-feedback error-width"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="height" class="form-control-label">Image Height
                                    </label>
                                    <input type="text" class="form-control m-input--square change_pam" name="height" id="height" autocomplete="off">
                                    <div class="form-control-feedback error-height"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title_char" class="form-control-label">Title Chars
                                    </label>
                                    <input type="text" class="form-control m-input--square change_pam" name="title_char" id="title_char" autocomplete="off">
                                    <div class="form-control-feedback error-title_char"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text_char" class="form-control-label">Text Chars
                                    </label>
                                    <input type="text" class="form-control m-input--square change_pam" name="text_char" id="text_char" autocomplete="off">
                                    <div class="form-control-feedback error-text_char"></div>
                                </div>
                            </div>
                        </div>
                        <div class="preview text-center">
                            <div class="d-inline-block position-relative">
                                <div class="d-inline-block position-relative ad_preview_div">
                                    <div class="img_preview_div d-inline-block position-relative">
                                        <p class="title_pos pos_center">Title will be put here</p>
                                        <img src="{{asset('assets/img/placeholder.png')}}" id="preview_img" >
                                        <div class="placeholder_text pos_center"><span class="width_val">500</span>X<span class="height_val">300</span></div>
                                    </div>
                                    <p class="text_pos mb-0">Text will be put here</p>
                                </div>
                                <p>
                                    <a href="#" class="blog_sponsored_btn float-left" target="_blank">Join Now</a>
                                    <a href="#" class="blog_sponsored_btn float-right">Sponsored</a>
                                </p>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="status" class="form-control-label">Active?</label>
                            <div>
                                <span class="m-switch m-switch--icon ml-1 mr-1 m-switch--info">
                                    <label>
                                        <input type="checkbox" checked="checked" id="status" name="status">
                                        <span></span>
                                    </label>
                                </span>
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
    <script src="{{asset('assets/js/admin/directoryAds/type.js')}}"></script>
@endsection
