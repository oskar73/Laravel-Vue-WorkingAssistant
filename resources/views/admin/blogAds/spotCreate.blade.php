@extends('layouts.master')

@section('title', 'Blog Advertisement Spot Create')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6 text-left">
        <x-layout.breadcrumb :menus="['Blog Advertisement', 'Spot', 'Create']"/>
    </div>
@endsection

@section('content')
    <x-layout.tabs-wrapper>
        <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Spot Detail</a></li>
        <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Price</a></li>
        <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Default Listing</a></li>
    </x-layout.tabs-wrapper>

    <x-layout.portletBody id="all_area" active="1">
        <x-form.form action="{{route('admin.blogAds.spot.store')}}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-form.input name="name" label="Name"/>

                    <x-form.textarea label="Description" name="description"></x-form.textarea>

                    <x-form.select label="Page Type" name="page_type" class="non_search_select2">
                        <option ></option>
                        <option value="home" >Blog Home Page</option>
                        <option value="category" >Blog Category Home Page</option>
                        <option value="tag" >Blog Tag Home Page</option>
                        <option value="detail" >Blog Detail Page</option>
                    </x-form.select>

                    <div class="d-none category_area page_area">
                        <x-form.select label="Blog Category Home Page:" name="category" class="non_search_select2">
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="d-none tag_area page_area">

                        <x-form.select label="Blog Tag Home Page:" name="tag" class="non_search_select2">
                            <option ></option>
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="d-none detail_area page_area">

                        <x-form.select label="Blog Detail Page:" name="detail" class="non_search_select2">
                            <option ></option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}} Category Blog Detail Page</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="form-group">
                        <label for="position_name">Select Ads Position</label>
                        <div class="input-group">
                            <input type="text" class="form-control m-input" id="position" name="position" readonly>
                            <input type="hidden" id="position_id" name="position_id">
                            <div class="input-group-append">
                                <span class="btn btn-success" id="select_position">Select Position</span>
                            </div>
                        </div>
                        <div class="form-control-feedback error-position_id"></div>
                        <div class="preview_position"></div>
                    </div>

                    <x-form.select label="Select New Ads Type" name="type" class="non_search_select2">
                        <option ></option>
                        @foreach($types as $i_type)
                            <option value="{{$i_type->id}}">{{$i_type->name}} (Width: {{$i_type->width}}px, Height: {{$i_type->height}}px, Title Char: {{$i_type->title_char}}, Text Char: {{$i_type->text_char}})</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="thumbnail" class="form-control-label">Screenshot</label>
                        <input type="file" accept="image/*" class="form-control m-input--square uploadImageBox" id="thumbnail" name="image" data-target="thumbnail_image">
                        <div class="form-control-feedback error-thumbnail"></div>
                        <img id="thumbnail_image" class="w-100"/>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <x-form.status label="Featured?" name="featured"/>
                        </div>
                        <div class="col-sm-3">
                            <x-form.status label="New?" name="new"/>
                        </div>
                        <div class="col-sm-3">
                            <x-form.status label="Sponsored Link Visible?" name="sponsored_visible"/>
                        </div>
                        <div class="col-sm-3">
                            <x-form.status label="Approve?" name="status" disabled="disabled"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mt-4">
                <x-form.a link="{{route('admin.blogAds.spot.index')}}" label="Back" />
                <x-form.smtBtn type="success" label="Next" />
            </div>
        </x-form.form>
    </x-layout.portletBody>

    <div class="modal fade" id="position_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Position</h5> <br>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="position_area">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/blogAds/spotCreate.js')}}"></script>
@endsection
