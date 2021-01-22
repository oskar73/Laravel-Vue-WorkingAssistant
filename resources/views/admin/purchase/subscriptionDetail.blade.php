@extends('layouts.master')

@section('title', 'Purchase Management - Subscriptions')
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
                    <span class="m-nav__link-text">Subscription Detail</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.purchase.subscription.index')}}" class="btn m-btn--square  btn-outline-info m-btn m-btn--custom">
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
                        Subscription &nbsp; <b> #{{$subscription->id}}</b>
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
                        <h4><b>Price</b>: ${{$subscription->getRecurrentPrice()}}</h4>
                        <h5><b>Start Date</b>: {{$subscription->created_at->toDateString()}}</h5>
                        <h5><b>Due Date</b>: {{$subscription->due_date}}</h5>
                        <h5><b>Payment</b>: {{ucfirst($subscription->order->gateway)}}</h5>
                        <h5><b>Status</b>:
                            <span class="c-badge {{$subscription->status=='active'?'c-badge-success':'c-badge-info'}}">{{ucfirst($subscription->status)}}</span>
                            @if($subscription->status=='active')
                                <a href="#" class="c-badge c-badge-danger hover-none cancel_subscription" data-id="{{$subscription->id}}}">Cancel Subscription</a>
                            @endif
                        </h5>
                    </div>
                    <div class="col-md-4">
                        <h5><b>Product Type</b>: {{moduleName($subscription->product_type)}} </h5>
                        <h5><b>Name</b>: <a href="/admin/purchase/{{$subscription->product_type=='blogPackage'?'blog':$subscription->product_type}}/detail/{{$subscription->getItem->id}}">{{$subscription->getName()}}</a></h5>
                    </div>
                    <div class="col-md-4 text-right">
                        <img src="{{$subscription->user->avatar()}}" title="{{$subscription->user->name}}" class='user-avatar-50'><br>
                        <a href="{{route("admin.userManage.detail", $subscription->user->id)}}">{{$subscription->user->name}}</a><br>
                        ({{$subscription->user->email}})
                    </div>
                </div>
                <hr>
                <h3 class="text-center">Recurrent Transaction Details</h3>
                <table class="table table-bordered table-item-center datatable">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Paid Date</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Invoice</th>
                        </tr>
                    </thead>
                    <tbody id="video_area">
                    @foreach($subscription->transactions()->latest()->get() as $key=>$transaction)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$transaction->created_at->toDateString()}}</td>
                            <td>${{formatNumber($transaction->amount)}}</td>
                            <td>
                                <a href="{{route('admin.purchase.transaction.invoice', $transaction->invoice->id?? 0)}}" class="text-black">
                                    <i class="fa fa-file-invoice-dollar font-size30 text-dark"></i>
                                </a>
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
    <script src="{{asset('assets/js/admin/purchase/subscriptionDetail.js')}}"></script>
@endsection
