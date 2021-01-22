@extends('layouts.master')

@section('title', 'Profile & Security')
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
                    <span class="m-nav__link-text">Account</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Profile</span>
                </a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#profile" href="#/profile">Profile</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#password" href="#/password">Password</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="profile_area">
        <div class="m-portlet__body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group position-relative text-center pt-5">
                            <label for="image" class="btn btn-outline-info m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill m-btn--air choose_btn_container">
                                <i class="la la-edit"></i>
                            </label>
                            <input type="file" accept="image/*" class="form-control m-input--square d-none" id="image" >
                            <img id="avatar" class="image_upload_output width-300" src="{{auth()->user()->avatar()}}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{route('account.profile.update')}}" id="profileForm">
                            @csrf
                            <div class="form-group pt-3 pb-3">
                                <label for="name">
                                    Name
                                    <i class="fa fa-info-circle tooltip_1" title="Name"></i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="name" id="name" placeholder="Name" value="{{user()->name}}">
                                <div class="form-control-feedback error-name"></div>
                            </div>
                            <div class="form-group pt-3 pb-3">
                                <label for="email">
                                    Email address
                                    <i class="fa fa-info-circle tooltip_1" title="Email Address"></i>
                                </label>
                                <input type="email" class="form-control m-input m-input--square" name="email" id="email" placeholder="Email Address" value="{{user()->email}}">
                                <div class="form-control-feedback error-email"></div>
                            </div>
                            <div class="form-group pt-3 pb-3">
                                <label for="timezone">
                                   Timezone
                                    <i class="fa fa-info-circle tooltip_1" title="Timezone"></i>
                                </label>
                                {!! getTimezoneList("name='timezone' class='form-control selectpicker' id='timezone' data-live-search='true' value='".user()->timezone."'") !!}
                                <div class="form-control-feedback error-timezone"></div>
                            </div>

                            <div class="form-group m-form__group">
                                <label for="username">Time Format:
                                    <i class="fa fa-info-circle tooltip_1"
                                       title="This is your time format.">
                                    </i>
                                </label>
                                <select name="time_format" id="timeformat" class="form-control selectpicker">
                                    <option value="Y-m-d H:i:s">2020-05-16 07:30:00</option>
                                    <option value="m/d/Y H:i:s">05/16/2020 07:30:00</option>
                                </select>
                                <div class="form-control-feedback error-time_format"></div>
                            </div>
                            <div class="form-group text-right">
                                <button class="btn m-btn--square  btn-outline-info m-btn m-btn--custom smtBtn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="password_area">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form action="{{route('account.password.update')}}" id="passwordForm">
                        @csrf
                        @if(user()->password!=null)
                        <div class="form-group m-form__group">
                            <label for="old_password">Old Password:</label>
                            <input type="password" class="form-control m-input--square" name="old_password" id="old_password" placeholder="Old Password">
                            <div class="form-control-feedback error-old_password"></div>
                        </div>
                        @endif
                        <div class="form-group m-form__group">
                            <label for="new_password">New Password:</label>
                            <input type="password" class="form-control m-input--square" name="new_password" id="new_password" placeholder="New Password">
                            <div class="form-control-feedback error-new_password"></div>
                        </div>
                        <div class="form-group m-form__group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control m-input--square" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                            <div class="form-control-feedback error-confirm_password"></div>
                        </div>
                        <div class="mt-3 text-right">
                            <button type="submit" class="btn m-btn--square  btn-outline-info m-btn m-btn--custom pswBtn">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script>
        var timezone = "{{user()->timezone}}",
            format = "{{user()->timeformat}}"
    </script>
    <script type="text/javascript" src="{{asset('assets/js/account/profile.js')}}"></script>
@endsection
