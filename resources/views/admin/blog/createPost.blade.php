@extends('layouts.master')

@section('title', 'Create Blog Post')

@section('style')
    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
@endsection

@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Blog', 'Post', 'Create']" :menuLinks="[]" />
    </div>
@endsection

@section('content')
    <x-form.form action="{{route('admin.blog.post.store')}}">
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <x-layout.portlet label="New Post" active="1" id="post_detail">
                    <x-form.input name="title" label="Post Title" />
                    <x-form.select label="Choose Category" name="category">
                        <option></option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" data-tags="{{$category->approvedTags->pluck('id')}}">{{$category->name}}</option>
                        @endforeach
                    </x-form.select>
                    <x-form.select label="Select Tags" name="tags[]" id="tag" multiple="multiple">
                        <option></option>
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                        @endforeach
                    </x-form.select>

                    <div class="m-radio-inline p-4">
                        <label class="m-radio">
                            <input type="radio" name="publish" value="1" checked> Ready to publish to Blog
                            <span></span>
                            <i class="la la-info-circle tooltip_icon"
                               title='{{$tooltip[4]}}'
                               data-page="{{$view_name}}"
                               data-id="4"
                            ></i>
                        </label>
                        <label class="m-radio">
                            <input type="radio" name="publish" value="0"> Draft
                            <span></span>
                            <i class="la la-info-circle tooltip_icon"
                               title='{{$tooltip[5]}}'
                               data-page="{{$view_name}}"
                               data-id="5"
                            ></i>
                        </label>
                    </div>
                </x-layout.portlet>
            </div>
            <div class="col-lg-5 col-md-12">
                <x-layout.portlet label="Featured Image" active="1" id="featured_image">
                    <x-form.thumbnail label="Upload Image"></x-form.thumbnail>
                </x-layout.portlet>
            </div>
        </div>

        <x-layout.portletFrame active="1" id="description_area">
            <x-layout.portletHead label="Description">
                <x-layout.portletNav>
                    <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                        <i class="la la-expand  text-white"></i>
                    </a>
                </x-layout.portletNav>
            </x-layout.portletHead>
            <div class="m-portlet__body">
                {{-- <div class="tinymce_area" id="description"></div> --}}
                <textarea id="description" name="description" hidden></textarea>
            </div>
            <div class="m-portlet__foot text-right">
                <x-form.a link="{{route('admin.blog.post.index')}}" label="Back"/>
                <x-form.smtBtn type="success" label="Submit" />
            </div>
        </x-layout.portletFrame>

        <x-layout.portletFrame active="1" id="gallery_area">
            <x-layout.portletHead label="Gallery">
                <li class="m-portlet__nav-item">
                    <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                        <i class="la la-angle-down  text-white"></i>
                    </a>
                </li>
                <li class="m-portlet__nav-item">
                    <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                        <i class="la la-expand  text-white"></i>
                    </a>
                </li>
            </x-layout.portletHead>
            <div class="m-portlet__body p-3">
                <x-layout.container>
                    <x-form.addImage ></x-form.addImage>

                    <x-form.addLink ></x-form.addLink>

                    <x-form.uploadVideo></x-form.uploadVideo>

                    <x-form.galleryOrder></x-form.galleryOrder>
                </x-layout.container>
            </div>
        </x-layout.portletFrame>
    </x-form.form>
@endsection
@section('script')
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script>
        var ratio_width = "{{config("custom.variable.blog_image_ratio_width")}}",
            ratio_height="{{config("custom.variable.blog_image_ratio_height")}}"
    </script>
    <script src="{{asset('assets/js/account/image_crop.js')}}"></script>

    <script src="{{asset('assets/js/admin/blog/createPost.js')}}"></script>
@endsection
