@extends('layouts.master')

@section('title', 'Purchase Management - Orders')
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
                    <span class="m-nav__link-text">Order Detail</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.purchase.order.index')}}" class="btn m-btn--square  btn-outline-info m-btn m-btn--custom">
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
                        Order &nbsp;<b> #{{$order->id}}</b>
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
                        <h4><b>Total Price</b>: ${{formatNumber($order->total)}}</h4>
                        @if($order->onetime_total!=0)<h5><b>Onetime Total</b>: {{formatNumber($order->onetime_total)}}</h5>@endif
                        @if($order->recurrent_total!=0)<h5><b>Recurring Total</b>: {{formatNumber($order->recurrent_total)}}</h5>@endif
                        @if($order->discount_total!=0)<h5><b>Discount Total</b>: {{formatNumber($order->discount_total)}}</h5>@endif
                        <h5><b>Payment</b>: <span class="c-badge {{$order->gateway=='paypal'?'c-badge-success':'c-badge-info'}}">{{ucfirst($order->gateway)}}</span></h5>
                    </div>
                    <div class="col-md-4">
                        @if($order->discount_total!=0)
                        @endif
                    </div>
                    <div class="col-md-4 text-right">
                        <img src="{{$order->user->avatar()}}" title="{{$order->user->name}}" class='user-avatar-50'><br>
                        <a href="{{route("admin.userManage.detail", $order->user->id)}}">{{$order->user->name}}</a><br>
                        ({{$order->user->email}})
                    </div>
                </div>
                <hr>
                <table class="table table-bordered table-item-center">
                    <thead>
                        <tr>
                            <th class="text-center">Product Type</th>
                            <th class="text-center">Payment Type</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Payment Status</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="video_area">
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{moduleName($item->product_type)}}</td>
                                <td>{!! $item->recurrent==1?"<span class='c-badge c-badge-success'>Recurrent</span>": "<span class='c-badge c-badge-info'>Onetime</span>" !!}</td>
                                <td>{{$item->getName()}}</td>
                                <td>
                                    @if($item->recurrent==0)
                                        ${{formatNumber($item->price)}}
                                    @else
                                        <a href="{{route('admin.purchase.subscription.detail', $item->id)}}">${{$item->getRecurrentPrice()}}</a>
                                    @endif
                                </td>
                                <td>{!! $item->paid==1?"<span class='c-badge c-badge-success'>PAID</span>": "<span class='c-badge c-badge-danger'>UNPAID</span>"!!}</td>
                                <td>
                                    @if($item->status==='active')
                                        <span class='c-badge c-badge-success'>{{$item->status}}</span>
                                    @else
                                        <span class='c-badge c-badge-danger'>{{ucfirst($item->status)}}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/purchase/orderDetail.js')}}"></script>
@endsection
