@extends('layouts.master')

@section('title', 'Setting - Basic Setting')
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
                    <span class="m-nav__link-text">Setting</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Basic Setting</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Basic Setting
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body md-plr-10">
            <div class="container">
                <form action="{{route('admin.setting.basic.store')}}" id="submit_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">
                                            Website Name
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="Give us the name of your website that you want others to know when they are sent emails or other correspondence from your website. Maximum characters are 45."
                                            ></i>
                                        </label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control m-input m-input--square" name="name" id="name" value="{{optional($basic)['name']}}">
                                        </div>
                                        <div class="form-control-feedback error-name"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sign">
                                            Title Link Sign
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This will display links between website name and title. For example: Home | WebsiteName"
                                            ></i>
                                        </label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control m-input m-input--square" name="sign" id="sign" value="{{optional($basic)['sign']}}">
                                        </div>
                                        <div class="form-control-feedback error-sign"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="register">
                                            User Register Allow
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="If you set active this, users can register themselves.
                                               However if you set inactive, you will need to add users yourself."> </i>
                                        </label>

                                        <div class="form-group m-form__group">
                                            <span class="m-switch m-switch--outline m-switch--icon m-switch--info">
                                                <label>
                                                    <input type="checkbox" {{option('register', 0)==1? 'checked': ''}} id="register" name="register">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="verification">
                                            Email Verification Enable
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="If you set this, when new user registers,
                                               he much verify his email address. If you set disable,
                                               then he will register without email verification."> </i>
                                        </label>

                                        <div class="form-group m-form__group">
                                            <span class="m-switch m-switch--outline m-switch--icon m-switch--info">
                                                <label>
                                                    <input type="checkbox" {{option('verification', 1)==1? 'checked': ''}} id="verification" name="verification">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="loading">Loading Screen Style
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="You can set one of 7 spinner styles."> </i>
                                    </label>
                                    <div class="form-group">
                                        <select class="form-control loading" id="loading" name="loading">
                                            <option value="0">None</option>
                                            <option value="1">Style 1</option>
                                            <option value="2">Style 2</option>
                                            <option value="3">Style 3</option>
                                            <option value="4">Style 4</option>
                                            <option value="5">Style 5</option>
                                            <option value="6">Style 6</option>
                                            <option value="7">Style 7</option>
                                        </select>
                                        <div class="form-control-feedback error-loading"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="loading_color">
                                            Loading Screen Background
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is Loading Screen Background. You can set simple color (#333) or gradient color."
                                            ></i>
                                        </label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control m-input m-input--square" name="loading_color" id="loading_color" value="{{optional($basic)['loading_color']}}">
                                        </div>
                                        <div class="form-control-feedback error-loading_color"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="loading_time">
                                            Loading Time to Hide
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="This is Loading Time to Hide. Milisecond."
                                            ></i>
                                        </label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control m-input m-input--square" name="loading_time" id="loading_time" value="{{optional($basic)['loading_time']}}">
                                        </div>
                                        <div class="form-control-feedback error-loading_time"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group m-form__group">
                                <label for="logo" class="form-control-label">
                                    Logo Image
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="Your logo is the image displayed on the top left of your website. Maximum image size is 2M."
                                    ></i>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input uploadImageBox" id="logo" name="logo" data-target="logo_preview">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                                <img src="{{$website->logo}}" id="logo_preview" class="maxw-100 mt-3">
                            </div>
                            <div class="form-group m-form__group">
                                <label for="favicon" class="form-control-label">
                                    Favicon Image
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="A favicon is an icon that is displayed on the address bar. Maximum size is 2M."
                                    ></i>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input uploadImageBox" id="favicon" name="favicon" data-target="favicon_preview">
                                    <label class="custom-file-label" for="favicon">Choose file</label>
                                </div>
                                <img src="{{$website->favicon}}" id="favicon_preview" class="maxw-100 mt-3">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="ml-auto btn m-btn--square btn-outline-success mb-2 smtBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>var loading = "{{optional($basic)['loading']?? 0}}"</script>
    <script src="{{asset('assets/js/admin/setting/basic.js')}}"></script>
@endsection
