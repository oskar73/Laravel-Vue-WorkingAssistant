@extends('layouts.master')

@section('title', 'Page Create')
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
                    <span class="m-nav__link-text">Page</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Create</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" href="#"> Page Detail</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile md-pt-50 tab_area area-active">
        <div class="m-portlet__body">
            <div class="container">
                <form action="{{route('admin.content.page.store')}}" id="submit_form">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Page Name
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is Page Name"
                                    ></i>
                                </label>
                                <div class="position-relative">
                                    <input type="text" class="form-control m-input m-input--square" name="name" id="name">
                                </div>
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
                                    <input type="text" class="form-control" placeholder="page-url" name="url">
                                </div>
                                <div class="form-control-feedback error-url"></div>
                            </div>
                        </div>
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
                                    <div class="font-size20">SEO Setting</div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <label for="title">
                                                    Meta Title
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="Meta Title"
                                                    ></i>
                                                </label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control m-input m-input--square" name="title" id="title">
                                                </div>
                                                <div class="form-control-feedback error-title"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="keywords">
                                                    Meta Keywords
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="Meta Keywords"
                                                    ></i>
                                                </label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control m-input m-input--square" name="keywords" id="keywords">
                                                </div>
                                                <div class="form-control-feedback error-keywords"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">
                                                    Meta Description
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="Meta Description"
                                                    ></i>
                                                </label>
                                                <div class="position-relative">
                                                    <textarea class="form-control m-input m-input--square minh-100px" name="description" id="description"></textarea>
                                                </div>
                                                <div class="form-control-feedback error-description"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group m-form__group">
                                                <label for="image" class="form-control-label">
                                                    Meta Image
                                                    <i class="la la-info-circle tipso2"
                                                       data-tipso-title="What is this?"
                                                       data-tipso="Meta Image"
                                                    ></i>
                                                </label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input uploadImageBox" id="image" name="image" data-target="preview">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                                <img id="preview" class="w-100 mt-3">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="font-size20">Additional Code</div>
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
                                            <textarea class="form-control m-input m-input--square minh-100px" name="head_code" id="head_code"></textarea>
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
                                            <textarea class="form-control m-input m-input--square minh-100px" name="bottom_code" id="bottom_code"></textarea>
                                        </div>
                                        <div class="form-control-feedback error-bottom_code"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{route('admin.content.page.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
                        <button class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 smtBtn">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/content/pageCreate.js')}}"></script>
@endsection
