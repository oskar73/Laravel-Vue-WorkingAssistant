@extends('layouts.master')

@section('title', 'Site Advertisement Spot Create')
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
                    <span class="m-nav__link-text">Site Advertisement</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="{{route('admin.siteAds.spot.index')}}" class="m-nav__link">
                    <span class="m-nav__link-text">Spot</span>
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
    <div class="col-md-6 text-right">
        <a href="{{route('admin.siteAds.spot.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Spot Detail</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#default" href="#/default">Default Listing</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#price" href="#/price">Price</a></li>
            <li class="tab-item"><a class="tab-link" href="{{route('admin.siteAds.spot.editPosition', $spot->id)}}#site-ads-spot-{{$spot->position_id}}">Position <i class="fa fa-external-link-alt"></i></a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.siteAds.spot.update', $spot->id)}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="page" class="form-control-label">
                                Page:
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is name of site ads page "></i>
                            </label>
                            <input type="text" class="form-control" name="page" id="page" value="{{$spot->page->name}}" readonly>
                            <div class="form-control-feedback error-page"></div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="form-control-label">
                                Type:
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is site ads type "></i>
                            </label>
                            <input type="text" class="form-control" name="type" id="type" value="{{$spot->parentType->name}} ({{$spot->parentType->width}} x {{$spot->parentType->height}})" readonly>
                            <div class="form-control-feedback error-type"></div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-control-label">
                                Name:
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is name of site ads spot"></i>
                            </label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$spot->name}}">
                            <div class="form-control-feedback error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">
                                Description:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is description about site ads spot"></i>
                            </label>
                            <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="description" id="description">{{$spot->description}}</textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thumbnail" class="form-control-label">
                                Screenshot

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is screenshot about site ads spot"></i>
                            </label>
                            <input type="file" accept="image/*" class="form-control m-input--square uploadImageBox" id="thumbnail" name="image" data-target="thumbnail_image">
                            <div class="form-control-feedback error-thumbnail"></div>
                            <img src="{{$spot->getFirstMediaUrl("image")}}" id="thumbnail_image" class="w-100"/>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label for="featured" class="form-control-label">
                                    Featured?

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will set a spot featured"></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" name="featured" id="featured" {{$spot->featured? "checked": ""}}>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="new" class="form-control-label">
                                    New?
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will set a spot new"></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox"  name="new" id="new" {{$spot->new? "checked": ""}}>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="sponsored_visible" class="form-control-label">
                                    Sponsored Link Visible?

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will set visible sponsored link button"></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" checked name="sponsored_visible" id="sponsored_visible" {{$spot->sponsored_visible? "checked": ""}}>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="status" class="form-control-label">Approve?
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="Until you set price and position, it will be disabled."></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" name="status" id="status" {{$spot->status? "checked": ""}}>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area" id="price_area">
        <div class="m-portlet__body">
            <div class="container">
                <div class="text-right">
                    <a href="javascript:void(0);" class="btn m-btn--square m-btn btn-outline-success btn-sm addPriceBtn">+ Add Price Plan</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered ajaxTable datatable">
                        <thead>
                        <tr>
                            <th>Price</th>
                            <th>Slashed Price</th>
                            <th>Type</th>
                            <th>Period/Impression</th>
                            <th>Standard</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="price_area">
                            <tr><td colspan="7"><i class='fa fa-spinner fa-spin fa-2x fa-fw'></i></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area" id="default_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.siteAds.spot.updateListing', $spot->id)}}" id="listing_form">
                @csrf
                <div class="container">

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="m-option h-cursor">
                            <span class="m-option__control">
                                <span class="m-radio m-radio--brand m-radio--check-bold">
                                    <input type="radio" name="google_ads" value="-1" @if(!$spot->gag()->exists()) checked @endif>
                                    <span></span>
                                </span>
                            </span>
                                <span class="m-option__label">
                                <span class="m-option__head">
                                    <span class="m-option__title">
                                        None
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This won't put any default listing on this spot until user purchase it."></i>
                                    </span>
                                </span>
                            </span>
                            </label>
                        </div>

                        <div class="col-lg-4">
                            <label class="m-option h-cursor">
                                <span class="m-option__control">
                                    <span class="m-radio m-radio--brand m-radio--check-bold">
                                        <input type="radio" name="google_ads" value="0" @if($spot->gag()->exists()&&$spot->gag->google_ads==0) checked @endif>
                                        <span></span>
                                    </span>
                                </span>
                                <span class="m-option__label">
                                    <span class="m-option__head">
                                        <span class="m-option__title">
                                             Ads Listing
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="You can put your default site ads listing"></i>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-lg-4">
                            <label class="m-option h-cursor">
                                <span class="m-option__control">
                                    <span class="m-radio m-radio--brand m-radio--check-bold">
                                        <input type="radio" name="google_ads" value="1" @if($spot->gag()->exists()&&$spot->gag->google_ads==1) checked @endif>
                                        <span></span>
                                    </span>
                                </span>
                                <span class="m-option__label">
                                    <span class="m-option__head">
                                        <span class="m-option__title">
                                             Google Ads
                                            <i class="la la-info-circle tipso2"
                                               data-tipso-title="What is this?"
                                               data-tipso="You can put google ads code and earn money from it. See <a href=''>Here</a> in detail."></i>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="default_listing_select @if(!$spot->gag()->exists()||$spot->gag->google_ads!=0) d-none @endif">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group mt-5">
                                    <label for="ads_image">Ads Image ({{$spot->parentType->width}}x{{$spot->parentType->height}}px)</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input ads_image" id="ads_image" name="ads_image" data-target="ads_image_disp">
                                        <label class="custom-file-label" for="ads_image">Choose file</label>
                                    </div>
                                    <img @if($spot->gag->getFirstMediaUrl("image")!='') src="{{$spot->gag->getFirstMediaUrl("image")}}" @endif
                                    alt="{{$spot->title}}"
                                         id="ads_image_disp"
                                         class="border border-success mt-2"
                                         style="max-width:100%;width:{{$spot->parentType->width}}px;height:{{$spot->parentType->height}}px"
                                    >
                                </div>

                                @if($spot->parentType->title_char!==0)
                                    <div class="form-group">
                                        <label for="ads_title" class="form-control-label">Ads Title:</label>
                                        <input type="text" class="form-control ads_title" name="ads_title" id="ads_title" maxlength="{{$spot->parentType->title_char}}" value="{{$spot->gag->title}}">
                                        <div class="form-control-feedback error-ads_title"></div>
                                    </div>
                                @endif

                                @if($spot->parentType->text_char!==0)
                                    <div class="form-group">
                                        <label for="ads_text" class="form-control-label">Ads Text:</label>
                                        <textarea class="form-control ads_text minh-100px" name="ads_text" maxlength="{{$spot->parentType->text_char}}">{{$spot->gag->text}}</textarea>
                                        <div class="form-control-feedback error-ads_text"></div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="ads_url" class="form-control-label">Ads Url:</label>
                                    <input type="text" class="form-control ads_url" name="ads_url" id="ads_url" value="{{$spot->gag->url}}">
                                    <div class="form-control-feedback error-ads_url"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="google_ads_select @if(!$spot->gag()->exists()||$spot->gag->google_ads!=1) d-none @endif">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group mt-5">
                                    <label for="ads_google_code" class="form-control-label">Google Ads Code:</label>
                                    <textarea class="form-control ads_text minh-100px" name="ads_google_code">{{$spot->gag->code}}</textarea>
                                    <div class="form-control-feedback error-ads_google_code"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn m-btn--square m-btn btn-outline-success smtBtn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="price_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <form id="price_modal_form" action="{{route('admin.siteAds.spot.createPrice', $spot->id)}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="edit_price" name="edit_price">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_type" class="form-control-label">
                                        Payment Type:
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="You can choose payment depends on either per impression or per period."></i>
                                    </label>
                                    <select name="payment_type" id="payment_type" class="payment_type selectpicker" data-width="100%">
                                        <option value="impression" selected>Per Impression</option>
                                        <option value="period" >Per Period</option>
                                    </select>
                                    <div class="form-control-feedback error-payment_type"></div>
                                </div>
                            </div>
                            <div class="col-md-6 period_select d-none payment_type_select">
                                <label for="period" class="form-control-label">
                                    Choose Period Unit:

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="It is period unit for per period type."></i>
                                </label>
                                <select class="form-control m-bootstrap-select selectpicker" name="period" id="period">
                                    <option value="1">1 day</option>
                                    <option value="7">1 week</option>
                                    <option value="14">2 weeks</option>
                                    <option value="30" selected>1 month</option>
                                </select>
                                <div class="form-control-feedback error-period"></div>
                            </div>
                            <div class="col-md-6 impression_select payment_type_select">
                                <div class="form-group">
                                    <label for="impression" class="form-control-label">
                                        Per Impression:
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="It is impression limit for per impression payment type."></i>
                                    </label>
                                    <input type="text" class="form-control impression" name="impression" id="impression">
                                    <div class="form-control-feedback error-impression"></div>
                                </div>
                                <div class="form-control-feedback error-impression"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-control-label">
                                        Price:
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is price for this spot per payment impression/period."></i>
                                    </label>
                                    <input type="text" class="form-control price" name="price" id="price">
                                    <div class="form-control-feedback error-price"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slashed_price" class="form-control-label">
                                        Slashed Price:
                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is slashed price. You can show to customers discounted price. Optional."></i>
                                    </label>
                                    <input type="text" class="form-control price" name="slashed_price" id="slashed_price">
                                    <div class="form-control-feedback error-slashed_price"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="standard" class="form-control-label">
                                    Set As Standard?
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will set this price plan as standard price for this spot"></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" name="standard" id="price_standard">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-control-label">
                                    Status
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is status of this price plan"></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" name="status" checked id="price_status">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info m-btn m-btn--custom m-btn--square" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn m-btn--square m-btn btn-outline-success smtBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>var width="{{$spot->parentType->width}}", height="{{$spot->parentType->height}}", g_item_id="{{$spot->id}}"</script>
    <script src="{{asset('assets/js/admin/siteAds/spotEdit.js')}}"></script>
@endsection
