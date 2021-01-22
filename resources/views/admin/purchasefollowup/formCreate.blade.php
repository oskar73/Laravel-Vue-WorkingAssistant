@extends('layouts.master')

@section('title', 'Purchase Follow-up')
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
                    <span class="m-nav__link-text">Purchase Follow-up</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Form Create</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">@if(isset($form)) Edit @else Create @endif Form</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.purchasefollowup.form.store')}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label for="form_name" class="form-control-label">Form Name:

                            <i class="la la-info-circle tooltip_icon"
                               title='{{$tooltip[1]}}'
                               data-page="{{$view_name}}"
                               data-id="1"
                            ></i>
                        </label>
                        <input type="text" class="form-control" name="name" id="form_name" @if(isset($form))value="{{$form->name}}"@endif>
                    </div>
                    <div class="col-6">
                        <label for="status" class="form-control-label">Form Approve?

                            <i class="la la-info-circle tooltip_icon"
                               title='{{$tooltip[2]}}'
                               data-page="{{$view_name}}"
                               data-id="2"
                            ></i>
                        </label>
                        <div>
                            <span class="m-switch m-switch--icon m-switch--info">
                                <label>
                                    <input type="checkbox" @if(isset($form)&&$form->status==0)@else checked @endif name="status" id="status">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="build-wrap" class="mt-5 bg-light p-3"></div>
                <div class="text-right mt-4">
                    <a href="{{route('admin.purchasefollowup.form.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                    <button type="button" class="btn btn-outline-danger m-btn m-btn--custom m-btn--square fb-clear-btn">Clear</button>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success fb-save-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/formbuilder/form-builder.min.js')}}" type="text/javascript"></script>
    <script> var formData = @if(isset($form)) '{!!$form->content!!}'@else''@endif, id;@if(isset($form)) id = '{{$form->id}}';@endif</script>
    <script src="{{asset('assets/js/admin/purchasefollowup/formCreate.js')}}"></script>
@endsection
