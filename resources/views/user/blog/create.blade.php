@extends('layouts.master')

@section('title', 'Create Blog Post')
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
                    <span class="m-nav__link-text">Add New Post</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <form id="submit_form" action="{{route('user.blog.store')}}">
        @csrf
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    New Post
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            <label for="title">Post Title</label>
                            <textarea type="text" class="form-control m-input m-input--square" name="title" id="title" placeholder="Title" autofocus ></textarea>
                        </div>
                        <div class="form-group m-form__group">
                            <label for="category">Choose Category</label>
                            <select class="form-control" id="category" name="category" >
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" data-tags="{{$category->approvedTags->pluck('id')}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-category"></div>
                        </div>
                        <div class="form-group m-form__group">
                            <label for="tag">Select Tags</label><br>
                            <select class="form-control" id="tag" name="tags[]" multiple>
                                <option></option>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-tags"></div>
                        </div>
                        <div class="m-radio-inline p-4">
                            <label class="m-radio">
                                <input type="radio" name="publish" value="1" checked> Ready to publish to Blog
                                <span></span>
                            </label>
                            <label class="m-radio">
                                <input type="radio" name="publish" value="0"> Draft
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Featured Image
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body ">
                        <div class="form-group position-relative">
                            <label class="form-label">Upload Image</label>
                            <label for="thumbnail" class="btn btn-outline-info m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill m-btn--air choose_btn_container">
                                <i class="la la-edit"></i>
                            </label>
                            <input type="file" accept="image/*" class="d-none" id="thumbnail" >
                            <div class="form-control-feedback error-thumbnail"></div>
                            <img id="thumbnail_image" class="w-100"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="m-portlet m-portlet--mobile" m-portlet="true">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Description
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="javascript:;" m-portlet-tool="fullscreen" class="btn m-btn--square m-btn m-btn--custom btn-outline-info btn-sm">
                                        <i class="la la-expand"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body p-1">
                        <div class="tinymce_area" id="description" style="border:1px solid #eee;"></div>
                    </div>
                    <div class="m-portlet__foot text-right">
                        <a href="{{route('user.blog.index')}}" class="btn m-btn--square btn-outline-primary" data-dismiss="modal">Back</a>
                        <button type="submit" id="submit_btn" class="btn m-btn--square btn-outline-info smtBtn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/user/blog/create.js')}}"></script>
@endsection
