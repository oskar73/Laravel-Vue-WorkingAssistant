@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Blog Advertisement Spots')

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
@endsection
@section('content')
    <x-front.site-ads-hero></x-front.site-ads-hero>

    <div class="container pt-5 pb-5" >
        <div class="items_result">
            <div class="text-center minh-100 pt-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
        </div>
    </div>
    <div class="blog_append_section"></div>
@endsection
@section('script')
    <script>var siteads_url="{{route('siteAds.index')}}"</script>
    <script src="{{asset('assets/js/front/siteAds/index.js')}}"></script>
@endsection
