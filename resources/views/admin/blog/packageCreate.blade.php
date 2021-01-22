@extends('layouts.master')

@section('title', 'Blog Package')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Blog', 'Package', 'Create']" :menuLinks="[]" />
    </div>
@endsection

@section('content')
    <x-layout.tabs-wrapper>
        <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Package Detail</a></li>
        <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Set Price</a></li>
        <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Meeting and Attach Form</a></li>
    </x-layout.tabs-wrapper>
    <x-layout.portletBody id="all_area" active="1">
        <x-form.form action="{{route('admin.blog.package.store')}}">

            <div class="row">
                <div class="col-md-7">
                    <x-form.input name="name" label="Name" />
                    <x-form.textarea name="description" label="Description" />

                    <div class="row" x-data="{unlimit:false}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="post_number" class="form-control-label">
                                    Posting limit number:
                                </label>
                                <input type="number" class="form-control" name="post_number" id="post_number" x-bind:disabled="unlimit">
                                <div class="form-control-feedback error-post_number"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <br>
                            <label class="m-checkbox m-checkbox--state-success">
                                <input type="checkbox" name="unlimit" x-on:click="unlimit=!unlimit"> Set Unlimit
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <x-form.addImage ></x-form.addImage>
                    <x-form.addLink ></x-form.addLink>
                    <x-form.uploadVideo ></x-form.uploadVideo>
                    <x-form.galleryOrder></x-form.galleryOrder>
                </div>
                <div class="col-md-5">
                    <x-form.thumbnail></x-form.thumbnail>
                    <div class="row">
                        <div class="col-4">
                            <x-form.status label="Featured?" name="featured" />
                        </div>
                        <div class="col-4">
                            <x-form.status label="New?" name="new" />
                        </div>
                        <div class="col-4">
                            <x-form.status label="Approve?" name="status" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <x-form.a link="{{route('admin.blog.package.index')}}" label="Back"/>
                        <x-form.button type="submit" label="Next"/>
                    </div>
                </div>
            </div>
        </x-form.form>
    </x-layout.portletBody>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script>
        var ratio_width = "{{config("custom.variable.package_image_ratio_width")}}",
            ratio_height="{{config("custom.variable.package_image_ratio_height")}}"
    </script>
    <script src="{{asset('assets/js/account/image_crop.js')}}"></script>
    <script src="{{asset('assets/js/admin/blog/packageCreate.js')}}"></script>
@endsection
