@extends('layouts.master')

@section('title', 'Appointments')
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
                    <span class="m-nav__link-text">Appointments</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" href="#"> Appointments </a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50">
        <div class="m-portlet__body">
            <div class="container">
                <form action="{{route('admin.appointment.listing.update', $list->id)}}" id="submit_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 offset-md-3">

                            <div class="text-right">
                                <img src="{{$list->user->avatar()}}" title="{{$list->user->name}}" class='user-avatar-50'><br>
                                <a href="{{route("admin.userManage.detail", $list->user->id)}}">{{$list->user->name}}</a><br>
                                ({{$list->user->email}})
                            </div>
                            <div class="form-group">
                                <label for="product">Product</label>
                                <input type="text" class="form-control" value="{{$list->meeting->model->getName()?? ''}}" readonly>
                                <div class="form-control-feedback error-product"></div>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" class="form-control selectpicker" id="category" name="category">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if($list->category_id==$category->id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-feedback error-category"></div>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" class="form-control" value="{{$list->date}}" readonly id="date" name="date">
                                <div class="form-control-feedback error-date"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_time">Start Time</label>
                                        <input type="text" class="form-control timepicker" value="{{$list->start_time}}" readonly id="start_time" name="start_time">
                                        <div class="form-control-feedback error-start_time"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_time">End Time</label>
                                        <input type="text" class="form-control timepicker" value="{{$list->end_time}}" readonly id="end_time" name="end_time">
                                        <div class="form-control-feedback error-end_time"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control selectpicker" id="status">
                                    <option value="pending" @if($list->status=='pending') selected @endif>Pending</option>
                                    <option value="approved" @if($list->status=='approved') selected @endif>Approved</option>
                                    <option value="canceled" @if($list->status=='canceled') selected @endif>Canceled</option>
                                    <option value="done" @if($list->status=='done') selected @endif>Done</option>
                                </select>
                                <div class="form-control-feedback error-status"></div>
                            </div>
                            <div class="form-group">
                                <label for="reason">Reason</label>
                                <textarea class="form-control" id="reason" name="reason">{{$list->reason}}</textarea>
                                <div class="form-control-feedback error-reason"></div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control minh-100" id="description" name="description">{{$list->description}}</textarea>
                                <div class="form-control-feedback error-description"></div>
                            </div>
                            <div class="text-right">
                                <a href="{{route('admin.appointment.listing.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
                                <button type="submit" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 smtBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>var id = "{{$list->id}}"</script>
    <script src="{{asset('assets/js/admin/appointment/listingEdit.js')}}"></script>
@endsection
