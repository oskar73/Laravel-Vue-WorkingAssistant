@extends('layouts.master')

@section('title', 'Email Campaign')
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
                    <span class="m-nav__link-text">Email Campaign</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Listing</span>
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
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Campaign Detail</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
         <div class="m-portlet__body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="subject" class="form-control-label">Subject:</label>
                            <input type="text" class="form-control" name="subject" id="subject" value="{{$item->subject}}" readonly>
                        </div>
                        <div class="form-group">
                            <div class="border border-success">
{{--                                @include("components.mail.header", ['campaign_id'=>$item->id])--}}
                                <div id="message_body" class="minh-100px">{!! $item->body !!}</div>
{{--                                @include("components.mail.footer")--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" name="category" id="category" value="{{$item->category->name}}">
                        </div>
                        <div class="form-group template_area d-none">
                            <label for="template">Select Template</label>
                            <select class="form-control m-bootstrap-select selectpicker" name="template" id="template">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notnow" class="form-control-label">Not Now?</label>
                            <div>
                                <span class="m-switch m-switch--icon m-switch--info">
                                    <label>
                                        <input type="checkbox" name="notnow" id="notnow" @if($item->time!=null) checked @endif>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                        <div class="form-group promised_area @if($item->time==null) d-none @endif">
                            <label for="datetime" class="form-control-label">Select date & time</label>
                            <input type="text" class="form-control" id="promised_time" name="promised_time" readonly placeholder="Select date & time" value="{{$item->time}}"/>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control m-bootstrap-select selectpicker" name="status" id="status">
                                <option value="1" @if($item->status==1) selected @endif>Active</option>
                                <option value="0" @if($item->status==0) selected @endif>Inactive</option>
                                <option value="sent" @if($item->status=='sent') selected @endif>Sent</option>
                            </select>
                        </div>
                        <div class="mt-3 text-right">
                            <a href="{{route('admin.email.campaign.index')}}" class="btn m-btn--square  btn-outline-primary">Back</a>
                            <a href="{{route('admin.email.campaign.edit', $item->id)}}" class="btn m-btn--square  btn-outline-info smtBtn">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('script')
@endsection
