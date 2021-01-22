@extends('layouts.master')

@section('title', 'Legal Pages')
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
                    <span class="m-nav__link-text">Content</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Legal Page</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Edit</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile md-pt-50">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{$legalPage->name}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body">
            <div class="container">
                <form action="{{route('admin.content.legalPage.update', $legalPage->id)}}" id="submit_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Name
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is name of this page."
                                    ></i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="name" id="name" value="{{$legalPage->name}}">
                                <div class="form-control-feedback error-name"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url">
                                    Page URL
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is Page URL"
                                    ></i>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary" type="button">{{Request::root()}}/</button>
                                    </div>
                                    <input type="text" class="form-control" placeholder="page-url" name="url" value="{{$legalPage->url}}">
                                </div>
                                <div class="form-control-feedback error-url"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">
                                    Status
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is the status of this page"> </i>
                                </label>

                                <div class="form-group m-form__group">
                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" {{$legalPage->status==1? 'checked': ''}} id="status" name="status">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">
                            Page Content
                            <i class="la la-info-circle tipso2"
                               data-tipso-title="What is this?"
                               data-tipso="This is content of this page."
                            ></i>
                        </label>
                        <textarea class="form-control m-input m-input--square" name="content" id="content">{!! $legalPage->content !!}</textarea>
                        <div class="form-control-feedback error-content"></div>
                    </div>

                    <div class="m-accordion m-accordion--default m-accordion--toggle-arrow mt-3" id="accordion" role="tablist">
                        <div class="m-accordion__item m-accordion__item--info">
                            <div class="m-accordion__item-head collapsed" role="tab" id="accordion_head" data-toggle="collapse" href="#accordion_body" aria-expanded="false">
                                <span class="m-accordion__item-icon">
                                    <i class="fa fa-eye"></i>
                                </span>
                                <span class="m-accordion__item-title">Show Advanced Settings &#8675;&#8675;&#8675;</span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body collapse" id="accordion_body" role="tabpanel" aria-labelledby="accordion_head" data-parent="#accordion">
                                <div class="m-accordion__item-content">
                                    <div class="font-size20"><b>Navigation Setting</b></div>
                                    <hr>
                                    <div x-data="{status:{{$seo['nav_status']==1?'true':'false'}}}">
                                        <div class="form-group">
                                            <label class="m-checkbox">
                                                <input type="checkbox" name="nav_status" class="checkbox_item" x-model:checked="status" x-on:click="status=!status">
                                                Enable Navigation Area Section <span></span>
                                            </label>
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will enable navigation part of this page."
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
                                                <textarea class="form-control m-input m-input--square" name="nav_title" id="nav_title">{{$seo['nav_title']}}</textarea>
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
                                                <input type="file" class="custom-file-input uploadImageBox" id="nav_image" name="nav_image" data-target="nav_preview">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                            <img src="{{$seo['nav_image']}}" id="nav_preview" class="w-100 mt-3">
                                        </div>
                                    </div>
                                    <div class="font-size20"><b>SEO Setting</b></div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <label for="meta_title">
                                                    Meta Title
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="Meta Title"
                                                    ></i>
                                                </label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control m-input m-input--square" name="meta_title" id="meta_title" value="{{$seo['meta_title']}}">
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
                                                    <input type="text" class="form-control m-input m-input--square" name="meta_keywords" id="meta_keywords" value="{{$seo['meta_keywords']}}">
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
                                                    <textarea class="form-control m-input m-input--square minh-100px" name="meta_description" id="meta_description">{{$seo['meta_description']}}</textarea>
                                                </div>
                                                <div class="form-control-feedback error-meta_description"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group m-form__group">
                                                <label for="meta_image" class="form-control-label">
                                                    Meta Image
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="Meta Image"
                                                    ></i>
                                                </label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input uploadImageBox" id="meta_image" name="meta_image" data-target="preview">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                                <img src="{{$legalPage->getFirstMediaUrl("seo")}}" id="preview" class="w-100 mt-3">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="font-size20"><b>Additional Code</b></div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="head_code">
                                            Head Code
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is additional head code. You can put third party css or script including code, or you can put additional style code for this page."
                                            ></i>
                                        </label>
                                        <div class="position-relative">
                                            <textarea class="form-control m-input m-input--square minh-100px" name="head_code" id="head_code">{{$legalPage->css}}</textarea>
                                        </div>
                                        <div class="form-control-feedback error-head_code"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bottom_code">
                                            Bottom Area Code
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is additional bottom area code"
                                            ></i>
                                        </label>
                                        <div class="position-relative">
                                            <textarea class="form-control m-input m-input--square minh-100px" name="bottom_code" id="bottom_code">{{$legalPage->script}}</textarea>
                                        </div>
                                        <div class="form-control-feedback error-bottom_code"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{route('admin.content.legalPage.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
                        <button class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 smtBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/admin/content/legalPageEdit.js')}}"></script>
@endsection
