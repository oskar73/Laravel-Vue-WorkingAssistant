@extends('layouts.master')

@section('title', 'Blog Package')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Blog', 'Package']" :menuLinks="[]" />
    </div>
    <div class="col-md-6 text-right">
        <x-form.a link="javascript:void(0);" class="sortBtn" label="Sort Order"/>
        <x-form.a link="{{route('admin.blog.package.create')}}" type="success" label="Create"/>
    </div>
@endsection

@section('content')
    <x-layout.tab-btn-area>
        <x-layoutItems.switch-action-btn action="active" name="Active"/>
        <x-layoutItems.switch-action-btn action="inactive" name="Inactive" class="info"/>
        <x-layoutItems.switch-action-btn action="featured" name="Featured" />
        <x-layoutItems.switch-action-btn action="unfeatured" name="Unfeatured" class="info"/>
        <x-layoutItems.switch-action-btn action="new" name="New" />
        <x-layoutItems.switch-action-btn action="undonew" name="Undo New" class="info"/>
        <x-layoutItems.switch-action-btn action="delete" name="Delete" class="danger"/>
    </x-layout.tab-btn-area>

    <x-layout.tabs-wrapper>
        <x-layoutItems.tab-item name="all" label="All Packages" active="1"/>
        <x-layoutItems.tab-item name="active" label="Active Packages" active="0"/>
        <x-layoutItems.tab-item name="inactive" label="Inactive Packages" active="0"/>
    </x-layout.tabs-wrapper>

    <x-layout.portletBody id="all_area" active="1">
        <x-layoutItems.loading />
    </x-layout.portletBody>

    <x-layout.portletBody id="active_area" active="0">
        <x-layoutItems.loading />
    </x-layout.portletBody>

    <x-layout.portletBody id="inactive_area" active="0">
        <x-layoutItems.loading />
    </x-layout.portletBody>

    @include('components.global.sortModal')

@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/admin/blog/package.js')}}"></script>
@endsection
