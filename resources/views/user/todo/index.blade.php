@extends('layouts.master')

@section('title', 'TODO List')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['ToDo List']" :menuLinks="[]" />
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <x-layout.portlet active="1" id="first_screen">
                    <div class="text-center pt-5">
                        <h1 class="fs-3-5"><b>You don't have anything to do now!</b></h1>
                    </div>
                </x-layout.portlet>
                <div class="row">
{{--                    <div class="col-lg-4">--}}
{{--                        <a href="{{route('package.index')}}" class="biz-card m-option btn-bizinabox">--}}
{{--                            Create Website--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-4">--}}
{{--                        <a href="{{route('blog.package')}}" class="biz-card m-option btn-bizinabox to_domain">--}}
{{--                            Post Blog--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-4">--}}
{{--                        <a href="{{route('blogAds.index')}}" class="biz-card m-option btn-bizinabox">--}}
{{--                            Advertise--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
