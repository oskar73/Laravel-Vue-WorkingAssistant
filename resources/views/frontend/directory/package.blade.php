@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Directory Package')

@section('meta')
    @include("components.front.seo", $seo)
@endsection

@section('style')
@endsection
@section('content')
    <x-front.directory-hero></x-front.directory-hero>

    <div class="container mt-3" >
        <x-front.directory-nav></x-front.directory-nav>

        <div class="items_result search_append_area pb-5">
           <div class="text-center minh-100 pt-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
        </div>
    </div>

    <input type="hidden" id="tag_id" value="0">
    <input type="hidden" id="category_id" value="0">
    <input type="hidden" id="disable_listings" value="1">
@endsection
@section('script')
    <script>
        var directory_url = "{{route('directory.index')}}",
            directory_package = "{{route('directory.package')}}"
    </script>
    <script src="{{asset('assets/js/front/directory/index.js')}}"></script>
    <script src="{{asset('assets/js/front/directory/package.js')}}"></script>
@endsection
