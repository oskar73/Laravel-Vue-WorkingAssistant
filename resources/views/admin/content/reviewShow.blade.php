@extends('layouts.master')

@section('title', 'Review Detail')
@section('style')

@endsection
@section('breadcrumb')
    <div class="col-md-6 text-left">
        <x-layout.breadcrumb :menus="['Review', 'Detail']" :menuLinks="[]" />
    </div>
    <div class="col-md-6">
        <br>
        <div class="text-right mt-2 ">
            <x-form.a link="{{route('admin.content.review.index')}}" type="info" label="Back"/>
            <a href="javascript:void(0);" class="btn btn-outline-success m-btn--custom m-1 m-btn m-btn--icon editBtn"  data-id="{{$review->id}}"> Edit</a>
        </div>
    </div>
@endsection

@section('content')
    <x-layout.portlet active="1" id="review_detail" label="Review Detail">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status" class="form-control-label">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" @if($review->status==1) selected @endif>Active</option>
                        <option value="0" @if($review->status==0) selected @endif>Inactive</option>
                    </select>
                    <div class="form-control-feedback error-status"></div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <button type="button"
                        class="btn m-btn--square m-btn m-btn--custom btn-outline-success updateBtn mt-2"
                        data-id="{{$review->id}}">Update Status</button>
            </div>
        </div>
        <hr>
        <div class="form-group font-size20">
            Product: {!! $review->getProduct() !!} <br>
            User: @if(isset($review->user->id)) <a href="{{route('admin.userManage.detail', $review->user->id)}}">{{$review->user->name}} {{$review->user->email}}</a> @else {{$review->name}} (Unregistered)
            {{$review->email}} @endif
            <br>
            Rating: {{$review->rating}} <br>
            Comment: {{$review->comment}}
        </div>
    </x-layout.portlet>

    <div class="modal fade" id="item_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <form id="item_modal_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="item_id" id="item_id"/>
                        <div class="form-group">
                            <label for="rating" class="form-control-label">Rating:</label>
                            <select name="rating" id="rating" class="selectpicker" data-width="100%">
                                <option value="5">5 stars</option>
                                <option value="4">4 stars</option>
                                <option value="3">3 stars</option>
                                <option value="2">2 stars</option>
                                <option value="1">1 star</option>
                            </select>
                            <div class="form-control-feedback error-rating"></div>
                        </div>
                        <div class="form-group">
                            <label for="comment" class="form-control-label">Comment:</label>
                            <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="comment" id="comment"></textarea>
                            <div class="form-control-feedback error-comment"></div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="form-control-label">Active?</label>
                            <div>
                                <span class="m-switch m-switch--icon ml-1 mr-1 m-switch--info">
                                    <label>
                                        <input type="checkbox" checked="checked" id="status" name="status">
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info m-btn m-btn--custom m-btn--square" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn m-btn--square m-btn btn-outline-success smtBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/content/reviewShow.js')}}"></script>
@endsection
