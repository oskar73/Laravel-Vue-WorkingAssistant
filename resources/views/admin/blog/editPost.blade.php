@extends('layouts.master')

@section('title', 'Edit Blog Post')
@section('style')
<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Blog', 'Post', 'Edit']" :menuLinks="[]" />
    </div>
@endsection

@section('content')
    <x-form.form action="{{route('admin.blog.post.update', $post->id)}}">
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <x-layout.portlet label="Edit Post (Author: <a href=''>{{$post->user->name}}</a> )" active="1">
                    <x-form.input name="title" label="Post Title" value="{{$post->title}}"/>
                    <x-form.select label="Choose Category" name="category">
                        <option></option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if($post->category_id==$category->id) selected @endif data-tags="{{$category->approvedTags->pluck('id')}}">{{$category->name}}</option>
                        @endforeach
                    </x-form.select>

                    <x-form.select label="Select Tags" name="tags[]" id="tag" multiple="multiple">
                        <option></option>
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}" @if(in_array($tag->id, $post->tags->pluck("id")->toArray())) selected @endif>{{$tag->name}}</option>
                        @endforeach
                    </x-form.select>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="m-radio-inline p-4">
                                <label class="m-radio">
                                    <input type="radio" name="publish" value="1"  @if($post->is_published==1) checked @endif> Ready to publish to Blog
                                    <i class="la la-info-circle tooltip_icon"
                                       title='{{$tooltip[4]}}'
                                       data-page="{{$view_name}}"
                                       data-id="4"
                                    ></i>
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="publish" value="0" @if($post->is_published==0) checked @endif> Draft
                                    <i class="la la-info-circle tooltip_icon"
                                       title='{{$tooltip[5]}}'
                                       data-page="{{$view_name}}"
                                       data-id="5"
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($post->is_free==true)
                                <x-form.input
                                    name="visible_date"
                                    label="Live Date"
                                    value="{{$post->visible_date}}"
                                    readonly="readonly"
                                />
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-form.selectpicker label="Featured" name="featured" search="false">
                                <option value="1" @if($post->featured==true) selected @endif>Featured</option>
                                <option value="0" @if($post->featured==false) selected @endif>Unfeatured</option>
                            </x-form.selectpicker>
                        </div>
                        <div class="col-md-6">

                            <x-form.selectpicker label="Status" name="status" search="false">
                                <option value="approved" @if($post->status=='approved') selected @endif>Approved</option>
                                <option value="pending" @if($post->status=='pending') selected @endif>Pending Approval</option>
                                <option value="denied" @if($post->status=='denied') selected @endif>Denied</option>
                            </x-form.selectpicker>

                        </div>
                    </div>
                    <div class="form-group reason_area" style="display:@if($post->status!='approved') block @else none @endif">
                        <x-form.textarea name="denied_reason" label="Reason">
                            {{$post->denied_reason}}
                        </x-form.textarea>
                    </div>
                </x-layout.portlet>
            </div>
            <div class="col-lg-5 col-md-12">
                <x-layout.portlet label="Featured Image" active="1" id="featured_image">
                    <x-form.thumbnail label="Upload Image">
                        {{$post->getFirstMediaUrl("image")}}
                    </x-form.thumbnail>
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
                <textarea id="description" name="description" hidden>{{$post->body}}</textarea>
                {{-- <div class="tinymce_area" id="description">
                    {!!html_entity_decode($post->body)!!}
                </div> --}}
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
                    <x-form.addImage >
                        @foreach($post->getMedia('images') as $key=>$image)
                            <tr>
                                <td>
                                    <input type="text" class="form-control m-input--square" value="{{$image->getUrl()}}" readonly>
                                    <input type="hidden" name='oldItems[]' value="{{$image->id}}">
                                </td>
                                <td class="text-center">
                                    <figure data-href="{{$image->getUrl()}}" class="width-150 progressive replace m-auto">
                                        <img class='width-150 preview' src="{{$image->getUrl('thumb')}}"/>
                                    </figure>
                                </td>
                                <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                            </tr>
                        @endforeach

                    </x-form.addImage>

                    <x-form.addLink >
                        @foreach($post->getLinks() as $key1=>$link)
                            <tr>
                                <td><input type="url" name='links[]' class="form-control m-input--square" value="{{$link}}"></td>
                                <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                            </tr>
                        @endforeach
                    </x-form.addLink>

                    <x-form.uploadVideo>

                        @foreach($post->getMedia('video') as $key2=>$video)
                            <tr>
                                <td>
                                    <input type="text" class="form-control m-input--square" value="{{$video->getUrl()}}" readonly>
                                    <input type="hidden" name='oldItems[]' value="{{$video->id}}">
                                </td>
                                <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                            </tr>
                        @endforeach
                    </x-form.uploadVideo>

                    <x-form.galleryOrder value="{{$post->gallery_order}}"/>
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
    <script src="{{asset('assets/js/admin/blog/editPost.js')}}"></script>
@endsection
