@extends('layouts.master')

@section('title', 'Blog Posts')
@section('style')

@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Blog', 'Posts']"/>
    </div>
    <div class="col-md-6 text-right">
        <x-form.a link="{{route('admin.blog.post.import')}}" label="Import Wordpress" type="info"/>
        <x-form.a link="{{route('admin.blog.post.create')}}" label="Create" type="success"/>
    </div>
@endsection

@section('content')

    <x-layout.tab-btn-area>
        <x-layoutItems.switch-action-btn action="approve" name="Approve"/>
        <x-layoutItems.switch-action-btn action="deny" name="Deny" class="info"/>
        <x-layoutItems.switch-action-btn action="featured" name="Featured" />
        <x-layoutItems.switch-action-btn action="unfeatured" name="Unfeatured" class="info"/>
        <x-layoutItems.switch-action-btn action="publish" name="Publish" />
        <x-layoutItems.switch-action-btn action="draft" name="Draft" class="info"/>
        <x-layoutItems.switch-action-btn action="delete" name="Delete" class="danger"/>
    </x-layout.tab-btn-area>

    <x-layout.tabs-wrapper>
        <x-layoutItems.tab-item name="pending" label="Pending Approval" active="1"/>
        <x-layoutItems.tab-item name="all" label="All Posts" active="0"/>
        <x-layoutItems.tab-item name="approved" label="Approved Posts" active="0"/>
        <x-layoutItems.tab-item name="draft" label="Drafts" active="0"/>
        <x-layoutItems.tab-item name="denied" label="Denied Posts" active="0"/>
    </x-layout.tabs-wrapper>

    <x-layout.portletBody id="pending_area" active="1">
        @include("components.admin.blogPostTable", ['selector'=>'datatable-pending', 'user'=>1])
    </x-layout.portletBody>

    <x-layout.portletBody id="all_area" active="0">
        @include("components.admin.blogPostTable", ['selector'=>'datatable-all', 'user'=>1])
    </x-layout.portletBody>

    <x-layout.portletBody id="approved_area" active="0">
        @include("components.admin.blogPostTable", ['selector'=>'datatable-approved', 'user'=>1])
    </x-layout.portletBody>

    <x-layout.portletBody id="draft_area" active="0">
        @include("components.admin.blogPostTable", ['selector'=>'datatable-draft', 'user'=>1])
    </x-layout.portletBody>

    <x-layout.portletBody id="denied_area" active="0">
        @include("components.admin.blogPostTable", ['selector'=>'datatable-denied', 'user'=>1])
    </x-layout.portletBody>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/blog/post.js')}}"></script>
@endsection
