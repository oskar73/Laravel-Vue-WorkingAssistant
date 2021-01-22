@extends('layouts.master')

@section('title', 'Blog Post Detail')
@section('style')

@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Blog', 'Post', 'Detail']" :menuLinks="[]" />
    </div>
    <div class="ml-auto">
        <x-form.a link="{{route('admin.blog.post.index')}}" label="Back" type="primary" />
        <x-form.a link="{{route('admin.blog.post.edit', $post->id)}}" label="Edit" type="success"/>

        @if($post->status=='approved'||$post->status=='pending')
            <x-form.a link="javascript:void(0)" label="Deny Now!" type="danger" title="Click for Deny" class="deny_btn"/>
        @endif
        @if($post->status=='denied'||$post->status=='pending')
            <x-form.a link="javascript:void(0)" label="Approve Now!" title="Click for Approve" class="approve_btn"/>
        @endif

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12">
            @if($post->status!='approved'&&$post->denied_reason!=null)
                <x-form.alert-danger title="Denied Reason">
                    {{$post->denied_reason}}
                </x-form.alert-danger>
            @endif

            <x-layout.portletFrame active="1" id="description_area">
                <x-layout.portletHead label="Description">
                    <x-layout.portletNav>
                        <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-expand  text-white"></i>
                        </a>
                    </x-layout.portletNav>
                </x-layout.portletHead>
                <div class="m-portlet__body">
                    <h3 class="br-padding-15">{{ $post->title }}</h3>
                    <hr>
                    <p>Posted By <b> <a href="javascript:;">{{ $post->user->name }}</a></b> on {{ $post->created_at }}</p>
                    <a href="{{$post->getFirstMediaUrl('image')}}" class="w-100 progressive replace m-auto">
                        <img src="{{$post->getFirstMediaUrl('image', 'thumb')}}"
                             alt="{{$post->title}}"
                             class="w-100 preview"
                        >
                    </a>
                    <div class="mt-3 br-padding-15">{!!html_entity_decode($post->body)!!}</div>
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

                    <x-form.addImage>
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
                            </tr>
                        @endforeach
                    </x-form.addImage>
                    <x-form.addLink>
                        @foreach($post->getLinks() as $key1=>$link)
                            <tr>
                                <td><input type="url" name='links[]' class="form-control m-input--square" value="{{$link}}" readonly></td>
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
                            </tr>
                        @endforeach
                    </x-form.uploadVideo>

                    <x-form.galleryOrder value="{{$post->gallery_order}}" />

                </div>
            </x-layout.portletFrame>

        </div>
        <div class="col-lg-4 col-md-12">
            <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
                <div class="m-portlet__head" style="height:3.1rem">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Post Status
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body" style="padding:1rem;">
                    @if($post->status=='approved')
                        <a href="javascript:void(0);" class="btn m-btn--square btn-outline-success">Approved</a>
                    @elseif($post->status=='denied')
                        <a href="javascript:void(0);" class="btn m-btn--square btn-outline-danger">Denied</a>
                    @elseif($post->status=='pending')
                        <a href="javascript:void(0);" class="btn m-btn--square btn-outline-info">Pending Approval</a>
                    @else
                        <a href="javascript:void(0);" class="btn m-btn--square btn-outline-primary">{{$post->status}}</a>
                    @endif
                </div>
            </div>
            <div class="m-portlet m-portlet--primary m-portlet--head-solid-bg">
                <div class="m-portlet__head" style="height:3.1rem">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Blogging Type
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body" style="padding:1rem;">
                    @if($post->is_free==true)
                        <button type="button" class="btn m-btn--square btn-outline-primary p-2">Free Blogging</button>
                    @else
                        <button type="button" class="btn m-btn--square btn-outline-info p-2">Paid Blogging
                            @if($post->package)
                                : (<a href="{{route('admin.purchase.blog.detail', $post->package->id?? 0)}}">{{$post->package->getName()}}</a>)
                            @endif
                        </button>
                    @endif
                </div>
            </div>
            <div class="m-portlet m-portlet--success m-portlet--head-solid-bg">
                <div class="m-portlet__head" style="height:3.1rem">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Category
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body" style="padding:1rem;">
                    <span class="btn m-btn--square btn-outline-primary p-2 ">
                        {{$post->category->name?? 'Deleted Category'}}
                    </span>
                </div>
            </div>
            <div class="m-portlet m-portlet--info m-portlet--head-solid-bg">
                <div class="m-portlet__head" style="height:3.1rem">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Tags
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body" style="padding:1rem;">
                    @foreach($post->tags as $tag)
                        <span class="btn m-btn--square btn-outline-info p-2">
                            @if(!empty($tag->name)){{$tag->name}}@endif
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-form.form id="denied_reason_form" action="{{route('admin.blog.post.switchPost')}}">
        <x-form.modal id="denied_reason_modal" title="Denied Reason" smtBtnClass="smtBtn">
            <x-form.textarea label="Reason" name="denied_reason" />
        </x-form.modal>
    </x-form.form>
@endsection
@section('script')
    <script>var id = "{{$post->id}}"</script>
    <script src="{{asset('assets/js/admin/blog/showPost.js')}}"></script>
@endsection
