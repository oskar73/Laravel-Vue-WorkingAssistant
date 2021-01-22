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
    <div class="col-md-6">
        <br>
        <div class="text-right mt-2 ">
            <a href="{{route('admin.blog.comment.index')}}" class="btn m-btn--square btn-outline-info">Back</a>
            <a href="{{route('admin.blog.comment.edit', $comment->id)}}" class="btn btn-outline-success smtBtn" >Edit</a>
        </div>
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
            <div class="comment_card">
                <div class="d-flex align-center">
                    <a href="{{route('blog.author', $comment->user->id)}}" class="mr-3">
                        <img src="{{$comment->user->avatar()}}" alt="{{$comment->user->name}}" class="rounded-circle width-50px">
                    </a>
                    <span class="mr-auto">
                    <a href="{{route('blog.author', $comment->user->id)}}" class="text-dark">{{$comment->user->name}}</a> <br>
                    {{$comment->created_at->toDateString()}}
                </span>
                </div>
                <div class="mt-3">
                    {!! $comment->comment !!}
                </div>

                <hr>

                <div class="d-flex justify-content-between mt-2">
                    <div class="like_dislike_area">
                        <a href="javascript:void(0);"
                           class="thumbs_up_area d-inline-block mr-3 hover-none text-dark"
                        >
                            <i class="far fa-thumbs-up thumb-icon"></i> <span class="thumbs_up_area">{{$comment->favorite_to_users->where('pivot.favorite', 1)->count()}}</span>
                        </a>
                        <a href="javascript:void(0);"
                           class="thumbs_down_area d-inline-block hover-none text-dark"
                        >
                            <i class="far fa-thumbs-down thumb-icon"></i> <span class="thumbs_down_area">{{$comment->favorite_to_users->where('pivot.favorite', 0)->count()}}</span>
                        </a>
                    </div>
                </div>
            </div>
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
            </div>
        </div>
    </div>

@endsection
@section('script')
@endsection
