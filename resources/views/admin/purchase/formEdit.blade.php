@extends('layouts.master')

@section('title', 'Purchase Forms')
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
                    <span class="m-nav__link-text">Purchase</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Forms</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="container">
                <div class="fs-20">{{$form->title}}
                    <span class="c-badge {{$form->status=='completed'? 'c-badge-success':'c-badge-danger'}}">{{$form->status}}</span>
                </div>
                <p class="fs-14">{{$form->description}}</p> <br>
                <form action="{{route('admin.purchase.form.update', $form->id)}}" method="POST" id="submit_form">
                    @csrf
                    <div class="form-content-area border p-3">
                        <div id="build-wrap"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="need to fill" @if($form->status=='need to fill') selected @endif>Need to fill</option>
                                    <option value="filled" @if($form->status=='filled') selected @endif>Filled</option>
                                    <option value="need revision" @if($form->status=='need revision') selected @endif>Need revision</option>
                                    <option value="completed" @if($form->status=='completed') selected @endif>Completed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Reason</label>
                                <textarea name="reason" id="reason" class="form-control">{{$form->reason}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <br>
                            <a href="{{route('admin.purchase.form.index')}}" class="ml-auto btn m-btn--square btn-outline-info mb-2">Back</a>
                            <button type="submit" class="ml-auto btn m-btn--square btn-outline-success mb-2 smtBtn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/formbuilder/form-render.min.js')}}" type="text/javascript"></script>
    <script>
        var formData = '{!!$form->body!!}',
        result = '{!! addslashes($form->result) !!}';
    </script>
    <script src="{{asset('assets/js/admin/purchase/formEdit.js')}}"></script>
@endsection
