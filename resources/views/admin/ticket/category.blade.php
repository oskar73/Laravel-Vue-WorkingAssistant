@extends('layouts.master')

@section('title', 'Ticket Category')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Ticket', 'Category']"/>
    </div>
    <div class="col-md-6 text-right">
        <x-form.a link="javascript:void(0);" label="Sort Order" class="sortBtn"/>
        <x-form.a link="javascript:void(0);" label="Create" class="createBtn" type="success"/>
    </div>
@endsection

@section('content')

    <x-layout.tab-btn-area>
        <x-layoutItems.switch-action-btn action="active" name="Active"/>
        <x-layoutItems.switch-action-btn action="inactive" name="Inactive" class="info"/>
        <x-layoutItems.switch-action-btn action="delete" name="Delete" class="danger"/>
    </x-layout.tab-btn-area>

    <x-layout.tabs-wrapper>
        <x-layoutItems.tab-item name="all" label="All Categories" active="1"/>
        <x-layoutItems.tab-item name="active" label="Active Categories" active="0"/>
        <x-layoutItems.tab-item name="inactive" label="InActive Categories" active="0"/>
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

    <x-form.form action="{{route('admin.ticket.category.store')}}">
        <x-form.modal id="create_modal" title="Ticket Category" smtBtnClass="smtBtn">
            <input type="hidden" name="category_id" id="category_id"/>

            <x-form.input name="name" label="Name"/>

            <x-form.textarea name="description" label="Description"/>

            <x-form.status name="status" label="Active?" checked="checked"/>

        </x-form.modal>
    </x-form.form>

    @include('components.global.sortModal')

@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/admin/ticket/category.js')}}"></script>
@endsection
