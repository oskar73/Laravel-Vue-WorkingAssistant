@extends('layouts.master')

@section('title', 'Ticket Detail')
@section('style')
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
                    <span class="m-nav__link-text">Ticket</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Detail</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.ticket.item.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info  mb-2">Back</a>
        <a href="{{route('admin.ticket.item.edit', $item->id)}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success  mb-2">Reply</a>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Ticket Detail</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50 ticket_area" id="all_area">
        <div class="m-portlet__body p-1 p-md-3">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <div>
                        Ticket ID: #{{$item->id}},
                        Category: {{$item->category->name}},
                        Priority: {{ucfirst($item->priority)}},
                        Status: <span class="status_box">{{ucfirst($item->status)}}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="d-flex">Created at: {{$item->created_at}}</span>
                    </div>
                </div>
                <div class="subject_box mb-3">
                    <h2>{{$item->text}}</h2>
                </div>

                <div class="item_result">
                    <div class="text-center p-3"><i class="fa fa-spin fa-spinner fa-2x"></i></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>var item_id = "{{$item->id}}"; </script>
    <script src="{{asset('assets/js/admin/ticket/itemShow.js')}}"></script>
@endsection
