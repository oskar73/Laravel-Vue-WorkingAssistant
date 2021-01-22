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
        <a href="{{route('admin.purchase.form.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
        <a href="{{route('admin.purchase.form.edit', $form->id)}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2">Edit</a>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{$form->title}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="needtofill" @if($form->status=='need to fill') selected @endif>Need to fill</option>
                                <option value="filled" @if($form->status=='filled') selected @endif>Filled</option>
                                <option value="needrevision" @if($form->status=='need revision') selected @endif>Need revision</option>
                                <option value="completed" @if($form->status=='completed') selected @endif>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <br>
                        <button type="submit" class="ml-auto btn m-btn--square btn-outline-success mt-2 smtBtn" data-id="{{$form->id}}">Update</button>
                    </div>
                </div>
                <hr>
                <div class="modal fade" id="reason_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">X</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea name="reason" id="reason" class="form-control" rows="5">{{$form->reason}}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn m-btn--square btn-outline-primary" data-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                @if($form->status!='completed'&&$form->reason!=null)
                    <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="m-alert__icon">
                            <i class="flaticon-exclamation-1"></i>
                            <span></span>
                        </div>
                        <div class="m-alert__text">
                            <strong>Reason! </strong> {{$form->reason}}
                        </div>
                        <div class="m-alert__close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    </div>
                @endif
                <div class="fs-20">{{$form->title}}
                    <span class="c-badge {{$form->status=='completed'? 'c-badge-success':'c-badge-danger'}}">{{$form->status}}</span>
                </div>
                <p class="fs-14">{{$form->description}}</p>
                <div class="form-content-area border p-3">
                    <div id="build-wrap"></div>
                </div>
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
    <script src="{{asset('assets/js/admin/purchase/formDetail.js')}}"></script>
@endsection
