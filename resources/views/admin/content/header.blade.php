@extends('layouts.master')

@section('title', 'Content - Header Items')
@section('style')
    <style>

    </style>
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
                    <span class="m-nav__link-text">Content</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Header Items</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success addCustomMenu mb-2">Add Custom Menu</a>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Header Items
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body md-plr-10">
            <div class="container">
                <div class="result_area">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Custom Menu Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <form id="create_modal_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="menu_id" id="menu_id"/>
                        <div class="form-group">
                            <label for="name" class="form-control-label">Name:
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is name of custom menu item.Maximum characters are 45.">
                                </i>
                            </label>
                            <input type="text" class="form-control" name="name" id="name" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="link" class="form-control-label">Link:
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is link of custom menu item.Please put with http:// or https://. If it doesn't have any link, please put #.">
                                </i>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-secondary" type="button">http(s)://</button>
                                </div>
                                <input type="text" class="form-control" name="link" id="link" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn m-btn--square  btn-outline-primary" data-dismiss="modal">Back</button>
                        <button type="submit" class="btn m-btn--square  btn-outline-info" >Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery.nestable.js')}}"></script>
    <script src="{{asset('assets/js/admin/content/header.js')}}"></script>
@endsection
