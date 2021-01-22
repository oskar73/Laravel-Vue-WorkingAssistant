@extends('layouts.master')

@section('title', 'Tickets')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Ticket', 'List']"/>
    </div>
    <div class="col-md-6 text-right">
        <x-form.a link="{{route('user.ticket.create')}}" label="Create" type="success"/>
    </div>
@endsection

@section('content')

    <x-layout.tab-btn-area>
        <x-layoutItems.switch-action-btn action="close" name="Close"/>
    </x-layout.tab-btn-area>


    <x-layout.tabs-wrapper>
        <x-layoutItems.tab-item name="opened" label="Opened Tickets" active="1"/>
        <x-layoutItems.tab-item name="all" label="All Tickets" active="0"/>
        <x-layoutItems.tab-item name="answered" label="Answered Tickets" active="0"/>
        <x-layoutItems.tab-item name="closed" label="Closed Tickets" active="0"/>
    </x-layout.tabs-wrapper>

    <x-layout.portletBody id="opened_area" active="1">
        @include("components.user.ticketTable", ['selector'=>'datatable-opened'])
    </x-layout.portletBody>
    <x-layout.portletBody id="all_area" active="0">
        @include("components.user.ticketTable", ['selector'=>'datatable-all'])
    </x-layout.portletBody>

    <x-layout.portletBody id="answered_area" active="0">
        @include("components.user.ticketTable", ['selector'=>'datatable-answered'])
    </x-layout.portletBody>

    <x-layout.portletBody id="closed_area" active="0">
        @include("components.user.ticketTable", ['selector'=>'datatable-closed'])
    </x-layout.portletBody>
@endsection
@section('script')
    <script src="{{asset('assets/js/user/ticket/item.js')}}"></script>
@endsection
