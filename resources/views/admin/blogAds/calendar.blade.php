@extends('layouts.master')

@section('title', 'Blog Advertisement Listing')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendors/calendar/fullcalendar.css')}}">
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
                    <span class="m-nav__link-text">Blog Advertisement</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Calendar View</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <select name="spot" id="spot" class="form-control select2 maxw-500" onchange="window.location.href=this.value;">
            <option value="{{route('admin.blogAds.calendar.index')}}">All Spots</option>
            @foreach($spots as $i_spot)
                <option value="{{route('admin.blogAds.calendar.spot', $i_spot->id)}}" @if(isset($spot)&&$spot->id==$i_spot->id) selected @endif>{{$i_spot->name}}</option>
            @endforeach
        </select>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" href="#">Calendar View</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50">
        <div class="m-portlet__body">
            <div id="calendar"></div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/vendors/calendar/fullcalendar.js') }}"></script>
    <script src="{{asset('assets/js/admin/blogAds/calendar.js')}}"></script>
@endsection
