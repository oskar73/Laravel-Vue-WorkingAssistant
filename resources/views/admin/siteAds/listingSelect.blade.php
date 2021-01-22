@extends('layouts.master')

@section('title', 'Site Advertisement Listing')
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
                <a href="{{route('admin.siteAds.listing.index')}}" class="m-nav__link">
                    <span class="m-nav__link-text">Listing</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Select Spot</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.siteAds.listing.index')}}" class="btn m-btn--square m-btn m-btn--custom btn-outline-info">Back</a>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#spot" href="#/spot">Select Spot</a></li>
            <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Listing Detail</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="spot_area">
        <div class="m-portlet__body" x-data="{table:false}">
            <div class="text-right">
                <span class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2 tooltip_3" x-bind:class="table? 'active': ''" x-on:click="table=true" title="Table View"><i class="fa fa-th"></i></span>
                <span class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2 tooltip_3" x-bind:class="table? '': 'active'" x-on:click="table=false" title="List View"><i class="fa fa-list-ul"></i></span>
            </div>
            <div class="table_view" x-show="table">
                <table class="table table-hover ajaxTable datatable">
                    <thead>
                        <tr>
                            <th class="text-center">Spot Name</th>
                            <th class="text-center">Page</th>
                            <th class="text-center">Ad Position (Type) </th>
                            <th class="text-center">Spot Price</th>
                            <th class="text-center">Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($spots as $spot)
                            <tr>
                                <td class="text-center">{{$spot->name}}</td>
                                <td class="text-center">{{$spot->page->name}}</td>
                                <td class="text-center">
                                    (Width:{{$spot->parentType->width}}px, Height:{{$spot->parentType->height}}px)
                                </td>
                                <td class="text-center">
                                    @if($spot->standardPrice)
                                        <span class="slashed_price_text">
                                            {{$spot->standardPrice->slashed_price? '$'.formatNumber($spot->standardPrice->slashed_price) : ''}}
                                        </span>
                                        <span>${{$spot->standardPrice->price?? ''}} / {{$spot->standardPrice->getUnit()?? ''}}</span>
                                    @else
                                        Unset price
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{route('admin.siteAds.listing.create', $spot->slug)}}" class="btn btn-outline-info">Select</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="list_view" x-show="!table">
                <div class="row justify-content-center">
                    @foreach($spots as $spot)
                        <div class="col-lg-3 col-md-4 mb-3">
                            <div class="spot-grid h-100">
                                <a href="{{route('admin.siteAds.listing.create', $spot->slug)}}" class="hover-none text-dark">
                                    <div class="position-relative">
                                        <div class="position-absolute w-100 p-2 z-index-999">
                                            @if($spot->featured)
                                                <span class="float-left text-success border border-success pl-1 pr-1">Featured</span>
                                            @endif
                                            @if($spot->new)
                                                <span class="float-right text-danger border pl-1 pr-1 border-danger">New</span>
                                            @endif
                                        </div>
                                        <figure data-href="{{$spot->getFirstMediaUrl('image')}}" class="w-100 progressive replace img-bg-effect-container height-300 mb-0">
                                            <img src="{{$spot->getFirstMediaUrl('image', 'thumb')}}" alt="{{$spot->name}}" class="preview img-bg img-bg-effect z-index-99"/>
                                        </figure>
                                    </div>
                                    <div class="spot-desc p-2 text-center">
                                        <p class="mt-2 mb-1 font-size20">{{$spot->name}}</p>
                                        <span class="mb-2">({{$spot->page->name}})</span> <br>
                                        <div class="mt-3">
                                            (Width:{{$spot->parentType->width}}px, Height:{{$spot->parentType->height}}px)
                                        </div> <br><br>

                                        @if($spot->standardPrice)
                                            <span class="slashed_price_text">
                                                 {{$spot->standardPrice->slashed_price? '$'.formatNumber($spot->standardPrice->slashed_price) : ''}}
                                            </span>
                                            <span>${{formatNumber($spot->standardPrice->price)}} / {{$spot->standardPrice->getUnit()}}</span>
                                        @else
                                            Unset price
                                        @endif
                                        <br>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
