@extends('layouts.master')

@section('title', 'Edit Comments')
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
                    <span class="m-nav__link-text">Blog</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Edit Comments</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#edit" href="#/edit"> Edit Comment</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="edit_area">
        <div class="m-portlet__body">
            <a href="{{route('admin.blog.post.show', $comment->post->id)}}" class="text-dark hover-none">
                <h5>
                    {{$comment->post->title}}
                </h5>
            </a>
            <hr>
            <div class="d-flex align-center">
                <a href="{{route('blog.author', $comment->user->id)}}" class="mr-3">
                    <img src="{{$comment->user->avatar()}}" alt="{{$comment->user->name}}" class="rounded-circle width-50px">
                </a>
                <span class="mr-auto">
                    <a href="{{route('blog.author', $comment->user->id)}}">{{$comment->user->name}}</a> <br>
                    {{$comment->created_at->toDateString()}}
                </span>
            </div>

            <form action="{{route('admin.blog.comment.update', $comment->id)}}" method="POST" class="comment_form">
                @csrf
                <div class="leave_comment_area my-3">
                    <div id="comment" class="minh-100 comment_box comment default_comment">
                        {!! $comment->comment !!}
                    </div>
                    <div class="form-control-feedback error-comment"></div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-control-label">Status:</label>
                                <select name="status" id="status" class="status form-control" >
                                    <option value="1" @if($comment->status==1) selected @endif>Approved</option>
                                    <option value="0" @if($comment->status==0) selected @endif>Pending</option>
                                    <option value="-1" @if($comment->status==-1) selected @endif>Denied</option>
                                </select>
                                <div class="form-control-feedback error-status"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <br>
                            <div class="text-right mt-2 ">
                                <a href="{{route('admin.blog.comment.index')}}" class="btn m-btn--square btn-outline-info">Back</a>
                                <button class="btn btn-outline-success smtBtn" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/admin/blog/editComment.js')}}"></script>
@endsection
