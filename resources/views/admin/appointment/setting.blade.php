@extends('layouts.master')

@section('title', 'Appointment Setting')
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
                        Appointment  Setting
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body">
            <form action="{{route('admin.appointment.setting.store')}}" id="submit_form">
                @csrf
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
                                       @if(isset($data[$item])) checked @endif
                                > {{ucfirst($item)}}
                                <span></span>
                            </label>
                            <div class="{{$item}}_table_area" style="display:@if(isset($data[$item])) block @else none @endif">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info p-1 mb-3 add_time_btn" data-name="{{$item}}">+ Add time</a>
                                <table class="table custom-table">
                                    <tbody id="{{$item}}_table">
                                        @if(isset($data[$item]))
                                            @foreach($data[$item]->hours as $key=>$hour)
                                                <tr id="rowe_{{$item.$key}}">
                                                    <td><input class="form-control timepicker start_time_area" name="start_time_{{$item}}[]" placeholder="start" readonly type="text" value="{{$hour->start}}"/></td>
                                                    <td><input class="form-control timepicker end_time_area" placeholder="end" name="end_time_{{$item}}[]" readonly type="text" value="{{$hour->end}}"/></td>
                                                    <td><a href="javascript:void(0);" data-id="rowe_{{$item.$key}}" class="btn m-btn--square  btn-danger btn-sm p-1 btn_remove">X</a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3 text-right">
                    <button type="submit" class="m-1 btn m-btn-square btn-outline-success m-btn m-btn--custom smtBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>var $count = "{{$key}}";</script>
    <script src="{{asset('assets/js/admin/appointment/setting.js')}}"></script>
@endsection
