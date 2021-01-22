@extends('layouts.app')

@section('title', $seo['meta_title']?? $page->name)

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
    @if($page->mainCss!=null)
        {!! $page->mainCss !!}
    @endif
    @if($page->sectionCss!=null)
        {!! $page->sectionCss !!}
    @endif
    {!! $page->css !!}
@endsection
@section('content')
    <x-front.legal-nav :data="$data"></x-front.legal-nav>
    <div class="container">
        {!! $page->content !!}
    </div>
@endsection
@section('script')
    {!! $page->script !!}
@endsection
