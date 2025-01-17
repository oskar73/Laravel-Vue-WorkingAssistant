@extends('layouts.master')

@section('title', 'Blog Front Setting')
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
                    <span class="m-nav__link-text">Front Setting</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <form action="{{route('admin.blog.front.store')}}" id="submit_form">
        @csrf
        <div class="tabs-wrapper">
            <ul class="tab-nav">
                <li class="tab-item"><a class="tab-link tab-active" data-area="#front-setting" href="#/front-setting">Front
                        Setting</a></li>
                <li class="tab-item"><a class="tab-link" data-area="#seo-setting" href="#/seo-setting">Seo Setting</a>
                </li>
            </ul>
        </div>
        <div class="m-portlet m-portlet--mobile tab_area area-active" id="front-setting_area">
            <div class="col-12 py-5">
                <div class="row">
                    <div class="col-md-4">
                        <h4>Blog Template</h4>
                    </div>
                    <div class="col-md-8">
                        <select name="template" id="template" class="form-control">
                            <option value="template1" @if($template=="template1") selected @endif>Template 1
                            </option>
                            <option value="template2" @if($template=="template2") selected @endif>Template 2
                            </option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <h4>Front Header</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">
                                        Name in Header
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is title in header"
                                        ></i>
                                    </label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control m-input m-input--square" name="name"
                                               id="name" value="{{$name}}">
                                    </div>
                                    <div class="form-control-feedback error-name"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">
                                        URL
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is url of blog page. If you want to set blog page as home page of website, you can set null. It should be without any space or special characters."
                                        ></i>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-secondary" type="button">{{Request::root()}}/
                                            </button>
                                        </div>
                                        <input type="text" class="form-control" name="url"
                                               value="{{config("custom.route.details")}}">
                                    </div>
                                    <div class="form-control-feedback error-url"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">
                                        Detail URL
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is url of blog page detail."
                                        ></i>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-secondary" type="button">{{Request::root()}}/{{config("custom.route.blog")}}{{config("custom.route.blog") ? '/' : ''}}
                                            </button>
                                        </div>
                                        <input type="text" class="form-control" name="detailUrl"
                                               value="{{config("custom.route.blogDetail")}}">
                                    </div>
                                    <div class="form-control-feedback error-url"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <h4>Blog Navigation Setting</h4>
                    </div>
                    <div class="col-lg-8" x-data="{status:{{$front['nav_status']==1?'true':'false'}}}">
                        <div class="form-group">
                            <label class="m-checkbox">
                                <input type="checkbox" name="nav_status" class="checkbox_item"
                                       x-model:checked="status" x-on:click="status=!status">
                                Enable Navigation Area Section <span></span>
                            </label>
                            <i class="la la-info-circle tipso2"
                               data-tipso-title="What is this?"
                               data-tipso="This will enable blog page navigation part."
                            > </i>
                        </div>
                        <div class="form-group" x-show="status">
                            <label for="navbar_title">
                                Blog Navigation Title
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is Blog Navigation Area Title"
                                ></i>
                            </label>
                            <div class="position-relative">
                                <textarea class="form-control m-input m-input--square" name="nav_title"
                                          id="nav_title">{{$front['nav_title']}}</textarea>
                            </div>
                            <div class="form-control-feedback error-nav_title"></div>
                        </div>
                        <div class="form-group m-form__group" x-show="status">
                            <label for="nav_image" class="form-control-label">
                                Blog Navigation Background Image
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is Blog Navigation Area Background Image"
                                ></i>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input uploadImageBox" id="nav_image"
                                       name="nav_image" data-target="nav_preview">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            <img src="{{$front['nav_image']}}" id="nav_preview" class="w-100 mt-3">
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="ml-auto btn m-btn--square btn-outline-success mb-2 smtBtn">Submit</button>
                </div>
            </div>
        </div>
        <div class="m-portlet m-portlet--mobile tab_area" id="seo-setting_area">
            <div class="col-12 py-5">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group m-form__group">
                            <label for="meta_image" class="form-control-label">
                                Meta Image
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is seo meta image. Size recommend: 1200x627px, max upload size: 5 MB."
                                ></i>
                                <a href="https://www.iloveimg.com/crop-image" class="underline" target="_blank">Resize</a>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input uploadImageBox" id="meta_image"
                                       name="meta_image" data-target="preview">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            <img src="{{$front['meta_image']}}" id="preview" class="w-100 mt-3">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="meta_title">
                                Meta Title
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="Meta Title"
                                ></i>
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control m-input m-input--square" name="meta_title"
                                       id="meta_title" value="{{$front['meta_title']}}">
                            </div>
                            <div class="form-control-feedback error-meta_title"></div>
                        </div>
                        <div class="form-group">
                            <label for="meta_keywords">
                                Meta Keywords
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="Meta Keywords"
                                ></i>
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control m-input m-input--square" name="meta_keywords"
                                       id="meta_keywords" value="{{$front['meta_keywords']}}">
                            </div>
                            <div class="form-control-feedback error-meta_keywords"></div>
                        </div>
                        <div class="form-group">
                            <label for="meta_description">
                                Meta Description
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="Meta Description"
                                ></i>
                            </label>
                            <div class="position-relative">
                            <textarea class="form-control m-input m-input--square minh-100px"
                                      name="meta_description"
                                      id="meta_description">{{$front['meta_description']}}</textarea>
                            </div>
                            <div class="form-control-feedback error-meta_description"></div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="ml-auto btn m-btn--square btn-outline-success mb-2 smtBtn">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/admin/blog/front.js')}}"></script>
@endsection
