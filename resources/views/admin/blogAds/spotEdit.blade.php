@extends('layouts.master')

@section('title', 'Blog Advertisement Spot Edit')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6 text-left">
        <x-layout.breadcrumb :menus="['Blog Advertisement', 'Spot', 'Edit']"/>
    </div>

    <div class="col-md-6 text-right">
        <x-form.a link="{{route('admin.blogAds.spot.index')}}" type="info" label="Back"/>
    </div>
@endsection

@section('content')

    <x-layout.tabs-wrapper>
        <x-layoutItems.normal-tab title="Spot Detail" link="all" active="1"/>
        <x-layoutItems.normal-tab title="Price" link="price" active="0"/>
        <x-layoutItems.normal-tab title="Default Listing" link="default_listing" active="0"/>
        <x-layoutItems.normal-tab active="0" link="status" title="Status"/>
    </x-layout.tabs-wrapper>

    <x-layout.portletBody id="all_area" active="1">
        <x-form.form action="{{route('admin.blogAds.spot.update', $spot->id)}}">
            <input type="hidden" name="edit_id" value="{{$spot->id}}" >
            <div class="row">
                <div class="col-md-6">
                    <x-form.input name="name" value="{{$spot->name}}" label="Name"/>

                    <x-form.textarea label="Description" name="description">
                        {{$spot->description}}
                    </x-form.textarea>

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
                            <input type="text" class="form-control m-input" id="position" name="position" readonly value="{{$spot->position->name}}">
                            <input type="hidden" id="position_id" name="position_id" value="{{$spot->position->id}}">
                            <div class="input-group-append">
                                <span class="btn btn-success" id="select_position">Select Position</span>
                            </div>
                        </div>
                        <div class="form-control-feedback error-position_id"></div>
                        <div class="preview_position">
                            <img class="w-100" src="{{$spot->position->image}}"/>
                        </div>
                    </div>
                    @php
                        $type = json_decode($spot->type);
                    @endphp

                    <x-form.select label="Select New Ads Type" name="type" class="non_search_select2">
                        <option ></option>
                        @foreach($types as $i_type)
                            <option value="{{$i_type->id}}">{{$i_type->name}} (Width: {{$i_type->width}}px, Height: {{$i_type->height}}px, Title Char: {{$i_type->title_char}}, Text Char: {{$i_type->text_char}})</option>
                        @endforeach
                    </x-form.select>

                    <div class="form-group border p-2">
                        <p class="form-control-label"><b>Current Ads Type Detail</b></p>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Name: {{$type->name}}</p>
                                <p>Description: {{$type->description}}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Width: {{$type->width}} Px</p>
                                <p>Height: {{$type->height}} Px</p>
                                <p>Title Char: {{$type->title_char}}</p>
                                <p>Text Char: {{$type->text_char}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="thumbnail" class="form-control-label">Screenshot</label>
                        <input type="file" accept="image/*" class="form-control m-input--square uploadImageBox" id="thumbnail" name="image" data-target="thumbnail_image">
                        <div class="form-control-feedback error-thumbnail"></div>
                        <img id="thumbnail_image" class="w-100" src="{{$spot->getFirstMediaUrl("image")}}"/>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <x-form.status label="Featured?" name="featured" checked="{{$spot->featured? 'checked': ''}}"/>
                        </div>
                        <div class="col-sm-3">
                            <x-form.status label="New?" name="new" checked="{{$spot->new? 'checked': ''}}"/>
                        </div>
                        <div class="col-sm-3">
                            <x-form.status label="Sponsored Link Visible?" name="sponsored_visible" checked="{{$spot->sponsored_visible? 'checked': ''}}"/>
                        </div>
                        <div class="col-sm-3">
                            <x-form.status label="Approve?" name="status" checked="{{$spot->status? 'checked': ''}}"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mt-4">
                <x-form.smtBtn type="success" label="Next" />
            </div>

        </x-form.form>
    </x-layout.portletBody>

    <x-layout.portletBody id="price_area" active="0">
        <x-layout.container>
            <div class="text-right">
                <x-form.a label="+ Add Price Plan" class="addPriceBtn" />
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
                    <tr>
                        <td colspan="7">
                            <x-layoutItems.loading />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-4">
                <a class="btn btn-outline-info m-btn m-btn--custom m-btn--square tab-link m-1" data-area="#all" href="#/all">Previous</a>
                <a class="btn m-btn--square m-btn m-btn--custom btn-outline-success tab-link m-1" data-area="#default_listing" href="#/default_listing">Next</a>
            </div>

        </x-layout.container>
    </x-layout.portletBody>

    <x-layout.portletBody id="default_listing_area" active="0">
        <x-layout.container>
            <x-form.form action="{{route('admin.blogAds.spot.updateListing', $spot->id)}}" id="listing_form">
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
                                    </span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="default_listing_select @if(!$spot->gag()->exists()||$spot->gag->google_ads!=0) d-none @endif">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-5">
                                <label for="ads_image">Ads Image ({{$type->width}}x{{$type->height}}px)</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input ads_image" id="ads_image" name="ads_image" data-target="ads_image_disp">
                                    <label class="custom-file-label" for="ads_image">Choose file</label>
                                </div>
                                <img @if($spot->gag->getFirstMediaUrl("image")!='') src="{{$spot->gag->getFirstMediaUrl("image")}}" @endif
                                alt="{{$spot->title}}"
                                     id="ads_image_disp"
                                     class="border border-success mt-2"
                                     style="max-width:100%;width:{{$type->width}}px;height:{{$type->height}}px"
                                >
                            </div>

                            @if($type->title_char!==0)
                                <div class="form-group">
                                    <label for="ads_title" class="form-control-label">Ads Title:</label>
                                    <input type="text" class="form-control ads_title" name="ads_title" id="ads_title" maxlength="{{$type->title_char}}" value="{{$spot->gag->title}}">
                                    <div class="form-control-feedback error-ads_title"></div>
                                </div>
                            @endif

                            @if($type->text_char!==0)
                                <div class="form-group">
                                    <label for="ads_text" class="form-control-label">Ads Text:</label>
                                    <textarea class="form-control ads_text minh-100px" name="ads_text" maxlength="{{$type->text_char}}">{{$spot->gag->text}}</textarea>
                                    <div class="form-control-feedback error-ads_text"></div>
                                </div>
                            @endif

                            <x-form.input name="ads_url" value="{{$spot->gag->url}}" label="Ads Url:"/>

                        </div>
                    </div>
                </div>
                <div class="google_ads_select @if(!$spot->gag()->exists()||$spot->gag->google_ads!=1) d-none @endif">
                    <div class="row">
                        <div class="col-md-6 offset-md-6 pt-5">
                            <x-form.textarea name="ads_google_code" label="Google Ads Code:" >
                                {{$spot->gag->code}}
                            </x-form.textarea>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a class="btn btn-outline-info m-btn m-btn--custom m-btn--square tab-link" data-area="#price" href="#/price">Previous</a>
                    <button type="submit" class="btn m-btn--square m-btn--custom m-btn btn-outline-success smtBtn">Next</button>
                </div>
            </x-form.form>
        </x-layout.container>
    </x-layout.portletBody>

    @include("components.admin.common.statusArea", ['action'=>route('admin.blogAds.spot.switch'), 'status'=>$spot->status])

    <div class="modal fade" id="position_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Position</h5> <br>

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

    <div class="modal fade" id="price_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <form id="price_modal_form" action="{{route('admin.blogAds.spot.createPrice', $spot->id)}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="edit_price" name="edit_price">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_type" class="form-control-label">Payment Type:</label>
                                    <select name="payment_type" id="payment_type" class="payment_type selectpicker" data-width="100%">
                                        <option value="impression" selected>Per Impression</option>
                                        <option value="period" >Per Period</option>
                                    </select>
                                    <div class="form-control-feedback error-payment_type"></div>
                                </div>
                            </div>
                            <div class="col-md-6 period_select d-none payment_type_select">
                                <label for="period" class="form-control-label">Choose Period Unit:</label>
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
                                    <label for="impression" class="form-control-label">Per Impression:</label>
                                    <input type="text" class="form-control impression" name="impression" id="impression">
                                    <div class="form-control-feedback error-impression"></div>
                                </div>
                                <div class="form-control-feedback error-impression"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-control-label">Price:</label>
                                    <input type="text" class="form-control price" name="price" id="price">
                                    <div class="form-control-feedback error-price"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slashed_price" class="form-control-label">Slashed Price: <i class="fa fa-info-circle tooltip_1" title="Slashed Price: Nullable"></i></label>
                                    <input type="text" class="form-control price" name="slashed_price" id="slashed_price">
                                    <div class="form-control-feedback error-slashed_price"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="standard" class="form-control-label">Set As Standard? <i class="fa fa-info-circle tooltip_1" title="Set as standard price"></i></label>
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
                                <label for="status" class="form-control-label">Status <i class="fa fa-info-circle tooltip_1" title="Set as standard price"></i></label>
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
                        <button type="submit" class="btn m-btn--square m-btn m-btn--custom m-btn--custom btn-outline-success smtBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        var g_item_id="{{$spot->id}}",
            g_page = "{{$spot->page}}",
            g_page_id = "{{$spot->page_id}}",
            g_type_id="{{$type->id}}",
            g_position_id="{{$spot->position_id}}",
            g_type=@JSON($spot->type)</script>
    <script src="{{asset('assets/js/admin/blogAds/spotEdit.js')}}"></script>
@endsection
