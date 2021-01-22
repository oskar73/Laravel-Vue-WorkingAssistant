@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Directory Listing Advertisement Spots')

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
@endsection
@section('content')
    <x-front.directory-ads-hero></x-front.directory-ads-hero>

    <div class="container pt-5 pb-5" >
        <x-front.directory-nav></x-front.directory-nav>

        <div class="search_append_area py-4 directory_ads_append_area">
            <div class="text-center minh-100 pt-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
        </div>
    </div>
    <input type="hidden" id="disable_listings" value="1">
@endsection
@section('script')
    <script>
        var directoryads_url = "{{route('directoryAds.index')}}",
            directory_url="{{route('directory.index')}}";
    </script>
    <script src="{{asset('assets/js/front/directory/index.js')}}"></script>
    <script src="{{asset('assets/js/front/directoryAds/index.js')}}"></script>
@endsection
