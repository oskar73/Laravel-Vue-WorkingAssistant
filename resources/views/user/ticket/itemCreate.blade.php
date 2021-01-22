@extends('layouts.master')

@section('title', 'Ticket Create')
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
                    <span class="m-nav__link-text">Create</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Create Ticket</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('user.ticket.store')}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="category" class="form-control-label">Choose Category:</label>
                                <select name="category" id="category" class="category selectpicker" data-live-search="true" data-width="100%">
                                    <option value="" disabled selected>Choose Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-feedback error-category"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="priority" class="form-control-label">Priority:</label>
                                <select name="priority" id="priority" class="priority selectpicker" data-width="100%">
                                    <option value="low" selected>Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                <div class="form-control-feedback error-priority"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="form-control-label">Subject:</label>
                        <textarea class="form-control m-input--square minh-50" name="subject" id="subject"></textarea>
                        <div class="form-control-feedback error-subject"></div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-control-label">Description:</label>
                        <textarea class="form-control m-input--square minh-100" name="description" id="description"></textarea>
                        <div class="form-control-feedback error-description"></div>
                    </div>
                    <div class="form-group">
                        <label for="attachment">File Attachments</label> <br>
                        <input type="file" id="attachments" name="attachments[]" multiple>
                        <div class="form-control-feedback error-attachmenets"></div>
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{route('user.ticket.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                        <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/user/ticket/itemCreate.js')}}"></script>
@endsection
