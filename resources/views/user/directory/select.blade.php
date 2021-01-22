@extends('layouts.master')

@section('title', 'Directory Listings')
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
                    <span class="m-nav__link-text">Directory Listings</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Select Package</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('user.directory.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
        <a href="{{route('directory.package')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2">Purchase package</a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 text-center mb-3"><h3>Choose one of your available packages</h3></div>
        @if($setting['permission']==='free'||$setting['permission']==='both')
            <div class="col-lg-4  mb-3">
                <div class="package_item bg-white p-4 pl-3 box-shadow h-100 border border-success ">
                    <div class="d-flex justify-content-between">
                        <h4>Free Listing</h4>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="font-size18">
                                Total Listing Limit: {{$setting['listing_number']==-1? 'Unlimited':$setting['listing_number']}}
                            </p>
                            <p class="font-size18">
                                Current Listing: {{$free_count}}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right pr-5">
                                <b>Thumbnail:</b> <img src="{{checkMark($setting['thumbnail'])}}" alt="" class="width-20px">
                                <br>
                                <b>Social Share:</b> <img src="{{checkMark($setting['social'])}}" alt="" class="width-20px">
                                <br>
                                <b>Tracking:</b> <img src="{{checkMark($setting['tracking'])}}" alt="" class="width-20px">
                                <br>
                                <b>Image Gallery:</b> <img src="{{checkMark($setting['image'])}}" alt="" class="width-20px">
                                <br>
                                <b>Video Links:</b> <img src="{{checkMark($setting['links'])}}" alt="" class="width-20px">
                                <br>
                                <b>Video Upload:</b> <img src="{{checkMark($setting['videos'])}}" alt="" class="width-20px">
                                <br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        @if($setting['listing_number']==-1||($setting['listing_number']-$free_count)>0)
                            <a href="{{route('user.directory.create', 0)}}"
                               class="btn m-btn--square m-btn--sm btn-outline-success"
                            >Select</a>
                        @else
                            <button class="btn m-btn--square m-btn--sm btn-outline-danger hover-prevent" disabled="disabled">Select</button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @forelse($packages as $package)
            <div class="col-lg-4  mb-3">
                <div class="package_item bg-white p-4 pl-3 box-shadow h-100">
                    <div class="d-flex justify-content-between">
                        <h4>{{$package->getName()}}</h4>
                        <div>
                            <span class="c-badge c-badge-{{$package->status=='active'? 'success': 'info'}}">{{ucfirst($package->status)}}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="font-size18">
                                Total Listing Limit: {{$package->listing_number==-1? 'Unlimited':$package->listing_number}}
                            </p>
                            <p class="font-size18">
                                Current Listing: {{$package->current_number}}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right pr-5">
                                <b>Thumbnail:</b> <img src="{{$package->checkMarkProperty('thumbnail')}}" alt="" class="width-20px">
                                <br>
                                <b>Social Share:</b> <img src="{{$package->checkMarkProperty('social')}}" alt="" class="width-20px">
                                <br>
                                <b>Tracking:</b> <img src="{{$package->checkMarkProperty('tracking')}}" alt="" class="width-20px">
                                <br>
                                <b>Image Gallery:</b> <img src="{{$package->checkMarkProperty('image')}}" alt="" class="width-20px">
                                <br>
                                <b>Video Links:</b> <img src="{{$package->checkMarkProperty('links')}}" alt="" class="width-20px">
                                <br>
                                <b>Video Upload:</b> <img src="{{$package->checkMarkProperty('videos')}}" alt="" class="width-20px">
                                <br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        @if($package->isPossibleforListing())
                            <a href="{{route('user.directory.create', $package->id)}}"
                               class="btn m-btn--square m-btn--sm btn-outline-success"
                            >Select</a>
                        @else
                            <button class="btn m-btn--square m-btn--sm btn-outline-danger hover-prevent" disabled="disabled">Select</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty

        @endforelse
    </div>
@endsection
@section('script')
@endsection
