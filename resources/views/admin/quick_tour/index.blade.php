@extends('layouts.master')

@section('title', 'Quick Tour')
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
                    <span class="m-nav__link-text">Quick Tour</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info sortBtn mb-2">Sort Order</a>
        <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success createBtn mb-2">Create</a>
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
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Items (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#active" href="#/active"> Active Items (<span class="active_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#inactive" href="#/inactive"> InActive Items (<span class="inactive_count">0</span>)</a></li>
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
                    <h5 class="modal-title" id="exampleModalLabel">Quick Tour</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <form id="create_modal_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="item_id" id="item_id"/>

                        <div class="form-group">
                            <label for="title" class="form-control-label">
                                Title
                                <i class="la la-info-circle tooltip_1"
                                    title="This is title of quick tour item.">
                                </i>
                            </label>
                            <input type="text" class="form-control m-input--square" name="title" id="title">
                            <div class="form-control-feedback error-title"></div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-control-label">
                                Description
                                <i class="la la-info-circle tooltip_1"
                                    title="This is description">
                                </i>
                            </label>
                            <textarea class="form-control m-input--square minh-200" name="description" id="description"></textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>

                        <div class="form-group">
                            <label for="targetID" class="form-control-label">Target ID</label>
                            <select name="targetID" id="targetID" class="form-control">
                                @foreach($targetIDs as $targetID => $targetIDLabel)
                                    <option value="{{$targetID}}">{{$targetIDLabel}}</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-targetID"></div>
                        </div>

                        <div class="form-group">
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
                        <button type="submit" class="btn m-btn--square m-btn btn-outline-success ">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.global.sortModal')

    <style>
        .select2.select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/admin/quick-tour/index.js')}}"></script>
@endsection
