@extends('layouts.master')

@section('title', 'Appointment Category')
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
                    <span class="m-nav__link-text">Appointment</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Category</span>
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
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Appointment Category Create
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body">
            <form action="{{route('admin.appointment.category.store')}}" id="submit_form">
                @csrf
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Name:</label>
                                <input type="text" class="form-control m-input--square minh-50" name="name" id="name">
                                <div class="form-control-feedback error-name"></div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-control-label">Description:</label>
                                <textarea class="form-control m-input--square minh-100" name="description" id="description" required></textarea>
                                <div class="form-control-feedback error-description"></div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Status</label> <br>
                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                        <label>
                                            <input type="checkbox" checked="checked" name="status">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3 text-right">
                                        <a href="{{route('admin.appointment.category.index')}}" class="m-1 btn m-btn-square btn-outline-info m-btn m-btn--custom">Back</a>
                                        <button type="submit" class="m-1 btn m-btn-square btn-outline-success m-btn m-btn--custom smtBtn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                Appointment Availability Setting
                <hr>
                <div class="row seven-cols">
                    @php
                        $key = 0;
                    @endphp
                    @foreach($weekArray as $item)
                        <div class="col-md-1">
                            <label class="m-checkbox m-checkbox--state-primary">
                                <input type="checkbox" name="{{$item}}"
                                       class="checkbox"
                                       data-name="{{$item}}"
                                > {{ucfirst($item)}}
                                <span></span>
                            </label>
                            <div class="{{$item}}_table_area" style="display:@if(isset($data[$item])) block @else none @endif">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info p-1 mb-3 add_time_btn" data-name="{{$item}}">+ Add time</a>
                                <table class="table custom-table">
                                    <tbody id="{{$item}}_table">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>var $count = "{{$key}}";</script>
    <script src="{{asset('assets/js/admin/appointment/categoryCreate.js')}}"></script>
@endsection
