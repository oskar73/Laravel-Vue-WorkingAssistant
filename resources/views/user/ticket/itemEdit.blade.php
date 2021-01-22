@extends('layouts.master')

@section('title', 'Ticket Reply')
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
                    <span class="m-nav__link-text">Reply</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Reply Ticket</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50 ticket_area" id="all_area">
        <div class="m-portlet__body p-1 p-md-3">
            <form action="{{route('user.ticket.update', $item->id)}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
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

                    <div class="border p-3 mb-5">
                        <h4>Reply</h4>
                        <hr>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Description:</label>
                            <textarea class="form-control m-input--square minh-100" name="description" id="description"></textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="attachment">File Attachments</label> <br>
                                    <input type="file" id="attachments" name="attachments[]" multiple>
                                    <div class="form-control-feedback error-attachmenets"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <br>
                                <label class="m-checkbox m-checkbox--check-bold">
                                    <input type="checkbox" name="close"> Close after submit
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-right mt-4">
                            <a href="{{route('user.ticket.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                            <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                        </div>
                    </div>
                    <div class="item_result">
                        <div class="text-center p-3"><i class="fa fa-spin fa-spinner fa-2x"></i></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>var item_id = "{{$item->id}}"; </script>
    <script src="{{asset('assets/js/user/ticket/itemEdit.js')}}"></script>
@endsection
