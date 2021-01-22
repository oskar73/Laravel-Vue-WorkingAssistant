@extends('layouts.master')

@section('title', 'Purchase Management - Products')
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
                    <span class="m-nav__link-text">Purchase Management</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Products</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('user.purchase.'.$type.'.index')}}" class="btn m-btn--square  btn-outline-info m-btn m-btn--custom">
            Back
        </a>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile md-pt-50">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{$detail->name}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h3> {{$detail->name}}</h3>
                    </div>
                    <div class="col-md-4">
                        <p class="fs-14 mb-0"><b>Payment</b>: {{$item->orderItem->recurrent==1?'Recurrent':'Onetime'}}</p>
                        <p class="fs-14 mb-0">
                           <b>Price</b>:
                           @if($item->orderItem->recurrent==1)
                               ${{$item->orderItem->getRecurrentPrice()}}
                           @else
                            ${{formatNumber($item->orderItem->price)}}
                           @endif
                        </p>
                        @if($item->orderItem->recurrent==1)
                            <br>
                            <b>Subscription</b> <a href="{{route('user.purchase.subscription.detail', $item->orderItem->id)}}" class="underline">View Detail</a>
                            <p class="fs-14 mb-0">
                                <b>Start Date</b>: {{$item->created_at}}
                            </p>
                            <p class="fs-14 mb-0">
                                <b>Due Date</b>: {{$item->orderItem->due_date}}
                            </p>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="fs-14">
                    <b>Status</b>: <span class="c-badge {{$item->status=='active'?'c-badge-success':'c-badge-info'}}">{{ucfirst($item->status)}}</span> <br>
                    <b>Description</b>: {{$detail->description}} <br>
                    <b>Details</b>: <br>
                    <div class="pl-3">
                        <b>Quantity</b>: {{$item->quantity}} <br>
                        @php
                            $parameters = unserialize($item->parameter)
                        @endphp
                        @if (isset($parameters['category_name']))
                            <b>Category</b>: {{ $parameters['category_name'] }} <br>
                        @endif
                        @if (isset($parameters['sizes']))
                            <b>Sizes</b>: {{ implode(', ', array_column($parameters['sizes'], 'name'))  }} <br>
                        @endif
                        @if (isset($parameters['colors']))
                            <b>Colors</b>: {{ implode(', ', array_column($parameters['colors'], 'name'))  }} <br>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
