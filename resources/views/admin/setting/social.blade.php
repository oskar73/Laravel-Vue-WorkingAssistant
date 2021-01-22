@extends('layouts.master')

@section('title', 'Setting - Social Login  Setting')
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
                    <span class="m-nav__link-text">Social Login  Setting</span>
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
                        Social Login Setting
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body md-plr-10">
            <div class="container-fluid pl-0 pl-md-5">
                <form action="{{route('admin.setting.social.store')}}" id="submit_form">
                    @csrf

                    <div class="row mb-3" x-data={facebook:{{optional($social)['facebook']==1?'true':'false'}}}>
                        <div class="col-md-2">
                            <div class="form-group m-form__group icon_area">
                                <div class="checkbox-icon">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="facebook" class="checkbox_item" x-bind:checked="facebook" x-on:click="facebook=!facebook">
                                        <span></span>
                                    </label>
                                </div>
                                <br>
                                <a href="#" class="social_btn twitter bg-fb"><i class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group facebook_area" x-show="facebook">
                                <label for="facebook_client_id">FACEBOOK CLIENT ID:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client id in your facebook account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="facebook_client_id" id="facebook_client_id" value="{{optional($social)['facebook_client_id']}}">
                                <div class="form-control-feedback error-facebook_client_id"></div>
                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="form-group facebook_area" x-show="facebook">
                                <label for="facebook_client_secret">FACEBOOK CLIENT SECRET:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your facebook account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="facebook_client_secret" id="facebook_client_secret" value="{{optional($social)['facebook_client_secret']}}">
                                <div class="form-control-feedback error-facebook_client_secret"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group facebook_area" x-show="facebook">
                                <label>Callback URL:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your github account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" value="{{Request::root()}}/auth/facebook/callback" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" x-data={linkedin:{{optional($social)['linkedin']==1?'true':'false'}}}>
                        <div class="col-md-2">
                            <div class="form-group m-form__group icon_area">
                                <div class="checkbox-icon">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="linkedin" class="checkbox_item" x-bind:checked="linkedin" x-on:click="linkedin=!linkedin">
                                        <span></span>
                                    </label>
                                </div>
                                <br>
                                <a href="#" class="social_btn twitter bg-ln"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group linkedin_area"  x-show="linkedin">
                                <label for="linkedin_client_id">LINKEDIN CLIENT ID:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client id in your linkedin account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="linkedin_client_id" id="linkedin_client_id" value="{{optional($social)['linkedin_client_id']}}">
                                <div class="form-control-feedback error-linkedin_client_id"></div>

                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="form-group m-form__group linkedin_area"  x-show="linkedin">
                                <label for="linkedin_client_secret">LINKEDIN CLIENT SECRET:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your linkedin account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="linkedin_client_secret" id="linkedin_client_secret" value="{{optional($social)['linkedin_client_secret']}}">
                                <div class="form-control-feedback error-linkedin_client_secret"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group linkedin_area" x-show="linkedin">
                                <label>Callback URL:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your github account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" value="{{Request::root()}}/auth/linkedin/callback" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"  x-data={twitter:{{optional($social)['twitter']==1?'true':'false'}}}>
                        <div class="col-md-2">
                            <div class="form-group m-form__group icon_area">
                                <div class="checkbox-icon">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="twitter" class="checkbox_item"  x-bind:checked="twitter" x-on:click="twitter=!twitter">
                                        <span></span>
                                    </label>
                                </div>
                                <br>
                                <a href="#" class="social_btn twitter bg-tw"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group twitter_area" x-show="twitter">
                                <label for="twitter_client_id">TWITTER CLIENT ID:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client id in your twitter account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="twitter_client_id" id="twitter_client_id" value="{{optional($social)['twitter_client_id']}}">
                                <div class="form-control-feedback error-twitter_client_id"></div>

                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="form-group m-form__group twitter_area" x-show="twitter">
                                <label for="twitter_client_secret">TWITTER CLIENT SECRET:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your twitter account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="twitter_client_secret" id="twitter_client_secret" value="{{optional($social)['twitter_client_secret']}}">
                                <div class="form-control-feedback error-twitter_client_secret"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group twitter_area" x-show="twitter">
                                <label>Callback URL:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your github account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" value="{{Request::root()}}/auth/twitter/callback" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"  x-data={google:{{optional($social)['google']==1?'true':'false'}}}>
                        <div class="col-md-2">
                            <div class="form-group m-form__group icon_area">
                                <div class="checkbox-icon">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="google" class="checkbox_item"   x-bind:checked="google" x-on:click="google=!google" >
                                        <span></span>
                                    </label>
                                </div>
                                <br>
                                <a href="#" class="social_btn twitter bg-go"><i class="fab fa-google"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group google_area"  x-show="google">
                                <label for="google_client_id">GOOGLE CLIENT ID:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client id in your google account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="google_client_id" id="google_client_id" value="{{optional($social)['google_client_id']}}">
                                <div class="form-control-feedback error-google_client_id"></div>

                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="form-group m-form__group google_area"  x-show="google">
                                <label for="google_client_secret">GOOGLE CLIENT SECRET:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your google account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="google_client_secret" id="google_client_secret" value="{{optional($social)['google_client_secret']}}">
                                <div class="form-control-feedback error-google_client_secret"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group google_area" x-show="google">
                                <label>Callback URL:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your github account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" value="{{Request::root()}}/auth/google/callback" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"  x-data={instagram:{{optional($social)['instagram']==1?'true':'false'}}}>
                        <div class="col-md-2">
                            <div class="form-group m-form__group icon_area">
                                <div class="checkbox-icon">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="instagram" class="checkbox_item"   x-bind:checked="instagram" x-on:click="instagram=!instagram"  >
                                        <span></span>
                                    </label>
                                </div>
                                <br>
                                <a href="#" class="social_btn twitter bg-ins"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group instagram_area" x-show="instagram">
                                <label for="instagram_client_id">INSTAGRAM CLIENT ID:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client id in your instagram account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="instagram_client_id" id="instagram_client_id" value="{{optional($social)['instagram_client_id']}}">
                                <div class="form-control-feedback error-instagram_client_id"></div>
                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="form-group m-form__group instagram_area" x-show="instagram">
                                <label for="instagram_client_secret">INSTAGRAM CLIENT SECRET:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your instagram account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="instagram_client_secret" id="instagram_client_secret" value="{{optional($social)['instagram_client_secret']}}">
                                <div class="form-control-feedback error-instagram_client_secret"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group instagram_area" x-show="instagram">
                                <label >Callback URL:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your github account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" value="{{Request::root()}}/auth/instagram/callback" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"  x-data={github:{{optional($social)['github']==1?'true':'false'}}}>
                        <div class="col-md-2">
                            <div class="form-group m-form__group icon_area">
                                <div class="checkbox-icon">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="github" class="checkbox_item" x-bind:checked="github" x-on:click="github=!github" >
                                        <span></span>
                                    </label>
                                </div>
                                <br>
                                <a href="#" class="social_btn twitter bg-git"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group github_area" x-show="github">
                                <label for="github_client_id">GITHUB CLIENT ID:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client id in your github account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="github_client_id" id="github_client_id" value="{{optional($social)['github_client_id']}}">
                                <div class="form-control-feedback error-github_client_id"></div>

                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="form-group m-form__group github_area" x-show="github">
                                <label for="github_client_secret">GITHUB CLIENT SECRET:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your github account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" name="github_client_secret" id="github_client_secret" value="{{optional($social)['github_client_secret']}}">
                                <div class="form-control-feedback error-github_client_secret"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group github_area" x-show="github">
                                <label>Callback URL:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can get client secret in your github account.">
                                    </i>
                                </label>
                                <input type="text" class="form-control m-input m-input--square" value="{{Request::root()}}/auth/github/callback" readonly>
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
    <script src="{{asset('assets/js/admin/setting/social.js')}}"></script>
@endsection
