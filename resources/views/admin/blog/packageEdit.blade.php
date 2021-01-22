@extends('layouts.master')

@section('title', 'Blog Package')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Blog', 'Package', 'Edit']" :menuLinks="[]" />
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.blog.package.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
    </div>
@endsection

@section('content')
    <x-layout.tabs-wrapper>
        <x-layoutItems.normal-tab active="1" link="all" title="Package Detail"/>
        <x-layoutItems.normal-tab active="0" link="price" title="Set Price"/>
        <x-layoutItems.normal-tab active="0" link="meeting" title="Meeting and Attach Form"/>
        <x-layoutItems.normal-tab active="0" link="status" title="Status"/>
    </x-layout.tabs-wrapper>

    <x-layout.portletBody active="1" id="all_area">
        <x-form.form action="{{route('admin.blog.package.update', $item->id)}}">
            <div class="row">
                <div class="col-md-7">
                    <x-form.input name="name" label="Name" value="{{$item->name}}"/>
                    <x-form.textarea name="description" label="Description" >
                        {{$item->description}}
                    </x-form.textarea>

                    <div class="row" x-data="{unlimit:'{{$item->post_number==-1?1:0}}'}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="post_number" class="form-control-label">
                                    Posting limit number:
                                </label>
                                <input type="number" class="form-control" name="post_number" id="post_number" x-bind:disabled="unlimit==1" value="{{$item->post_number!=-1?$item->post_number:''}}">
                                <div class="form-control-feedback error-post_number"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <br>
                            <label class="m-checkbox m-checkbox--state-success">
                                <input type="checkbox" name="unlimit" x-on:click="unlimit=unlimit==1?0:1" x-bind:checked="unlimit==1"> Set Unlimit
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <x-form.addImage >
                        @foreach($item->getMedia('image') as $key=>$image)
                            <tr>
                                <td>
                                    <input type="text" class="form-control m-input--square" value="{{$image->getUrl()}}" readonly>
                                    <input type="hidden" name='oldItems[]' value="{{$image->id}}">
                                </td>
                                <td><img class='width-150' src="{{$image->getUrl()}}"/></td>
                                <td><button class='btn btn-danger btn-sm delRowBtn'>X</button></td>
                            </tr>
                        @endforeach
                    </x-form.addImage>
                    <x-form.addLink >
                        @foreach($item->getLinks() as $key1=>$link)
                            <tr>
                                <td><input type="url" name='links[]' class="form-control m-input--square" value="{{$link}}"></td>
                                <td><button class='btn btn-danger btn-sm delRowBtn'>X</button></td>
                            </tr>
                        @endforeach
                    </x-form.addLink>
                    <x-form.uploadVideo >
                        @foreach($item->getMedia('video') as $key2=>$video)
                            <tr>
                                <td>
                                    <input type="text" class="form-control m-input--square" value="{{$video->getUrl()}}" readonly>
                                    <input type="hidden" name='oldItems[]' value="{{$video->id}}">
                                </td>
                                <td><button class='btn btn-danger btn-sm delRowBtn'>X</button></td>
                            </tr>
                        @endforeach
                    </x-form.uploadVideo>

                    <x-form.galleryOrder value="{{$item->order}}"/>
                </div>
                <div class="col-md-5">
                    <x-form.thumbnail>{{$item->getFirstMediaUrl("thumbnail")}}</x-form.thumbnail>
                    <div class="row">
                        <div class="col-4">
                            <x-form.status label="Featured?" name="featured" checked="{{$item->featured? 'checked': ''}}"/>
                        </div>
                        <div class="col-4">
                            <x-form.status label="New?" name="new" checked="{{$item->new? 'checked': ''}}"/>
                        </div>
                        <div class="col-4">
                            <x-form.status label="Approve?" name="status" checked="{{$item->status? 'checked': ''}}"/>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <x-form.a link="{{route('admin.blog.package.index')}}" label="Back"/>
                        <x-form.smtBtn type="success" label="Next" />
                    </div>
                </div>
            </div>
        </x-form.form>
    </x-layout.portletBody>

    <x-layout.portletBody id="price_area" active="0">
        <x-layout.container>
            <h2>Set Prices</h2>
        </x-layout.container>
        @include("components.admin.common.priceArea")
    </x-layout.portletBody>

    @include("components.admin.common.meetingForm", ['action'=>route('admin.blog.package.updateMeetingForm', $item->id)])

    @include("components.admin.common.addPriceModal", ['action'=>route('admin.blog.package.createPrice', $item->id)])

    @include("components.admin.common.statusArea", ['action'=>route('admin.blog.package.switch'), 'status'=>$item->status])

@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script>
        var item_id = "{{$item->id}}",
            getPriceUrl="{{route('admin.blog.package.edit', $item->id)}}",
            delPriceUrl="{{route('admin.blog.package.deletePrice', $item->id)}}",
            ratio_width = "{{config("custom.variable.package_image_ratio_width")}}",
            ratio_height="{{config("custom.variable.package_image_ratio_height")}}";
    </script>
    <script src="{{asset('assets/js/account/image_crop.js')}}"></script>
    <script src="{{asset('assets/js/admin/blog/packageEdit.js')}}"></script>
    <script src="{{asset('assets/js/admin/common/meetingForm.js')}}"></script>
    <script src="{{asset('assets/js/admin/common/price.js')}}"></script>
@endsection
