@extends('layouts.master')

@section('title', 'Blog Advertisement Listing Edit')
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
                    <span class="m-nav__link-text">Blog Ads Edit</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#detail" href="javascript:void(0);">Listing Detail</a></li>
        </ul>
    </div>
    <form action="{{route('user.blogAds.update', $listing->id)}}" id="submitForm">
        @csrf
        <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="detail_area">
            <div class="m-portlet__body  px-3 px-md-5">
                <div class="mt-3 border border-success p-2 pt-4">
                    <div class="row">
                        <div class="col-md-7 mb-2">
                            @php
                                $type = json_decode($listing->type);
                            @endphp
                            <div class="form-group">
                                <label for="image" class="form-control-label">Image ({{$type->width}}x{{$type->height}}px)</label>
                                <input type="file" accept="image/*" class="form-control m-input--square" id="image" name="image" data-target="image_preview">
                                <div class="form-control-feedback error-image"></div>
                                <img id="image_preview" class="border border-success mt-2" style="max-width:100%;width:{{$type->width}}px;height:{{$type->height}}px" src="{{$listing->getFirstMediaUrl("image")}}"/>
                            </div>
                            @if($type->title_char!==0)
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title ({{$type->title_char}} char):</label>
                                    <input type="text" class="form-control" name="title" id="title" maxlength="{{$type->title_char}}" value="{{$listing->title}}">
                                    <div class="form-control-feedback error-title"></div>
                                </div>
                            @endif
                            @if($type->text_char!==0)
                                <div class="form-group">
                                    <label for="text" class="form-control-label">Text ({{$type->text_char}} char):</label>
                                    <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="text" id="text" maxlength="{{$type->text_char}}">{{$listing->text}}</textarea>
                                    <div class="form-control-feedback error-text"></div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="url" class="form-control-label">URL (start with http:// or https://):</label>
                                <input type="url" class="form-control" name="url" id="url" value="{{$listing->url}}">
                                <div class="form-control-feedback error-url"></div>
                            </div>
                        </div>
                        <div class="col-md-5" x-data="{cta:{{$listing->cta_action? 'true': 'false'}}}">
                            <label class="m-checkbox m-checkbox--state-success">
                                <input type="checkbox" id="cta_check" name="cta_check" x-on:click="cta=!cta" @if($listing->cta_action) checked @endif>
                                Enable CTA LINK
                                <span></span>
                            </label>
                            <br>
                            <br>
                            <div class="cta_area" x-show="cta">
                                <div class="form-group">
                                    <label for="cta_url" class="form-control-label">CTA URL:</label>
                                    <input type="url" class="form-control" name="cta_url" id="cta_url" value="{{$listing->cta_url}}">
                                    <div class="form-control-feedback error-cta_url"></div>
                                </div>
                                <div class="form-group">
                                    <label for="cta_type" class="form-control-label">Select CTA Type:</label>
                                    <select name="cta_type" id="cta_type" class="form-control">
                                        <option value="buy_now" @if($listing->cta_type=='buy_now') selected @endif>Buy Now</option>
                                        <option value="shop_now" @if($listing->cta_type=='shop_now') selected @endif>Shop Now</option>
                                        <option value="visit_now" @if($listing->cta_type=='visit_now') selected @endif>Visit Now</option>
                                        <option value="learn_more" @if($listing->cta_type=='learn_more') selected @endif>Learn More</option>
                                        <option value="join_now" @if($listing->cta_type=='join_now') selected @endif>Join Now</option>
                                    </select>
                                    <div class="form-control-feedback error-cta_type"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-right">
                    <a href="{{route('user.blogAds.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>var g_type=@JSON($listing->type)</script>
    <script src="{{asset('assets/js/user/blogAds/edit.js')}}"></script>
@endsection
