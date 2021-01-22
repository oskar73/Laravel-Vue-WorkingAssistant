@extends('layouts.master')

@section('title', 'Purchase Management - Invoice')
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
                    <span class="m-nav__link-text">Invoice</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.purchase.transaction.index')}}" class="btn m-btn--square  btn-outline-info m-btn m-btn--custom">
            Back
        </a>
        <a href="{{route('admin.purchase.transaction.invoiceDownload', $invoice->id)}}" class="btn m-btn--square  btn-outline-success m-btn m-btn--custom" id="downloadBtn">
           <i class="fa fa-download"></i> Download
        </a>
    </div>
@endsection

@section('content')
    <div class="invoice_area mt-5"></div>
@endsection
@section('script')
    <script>var invoice_id = "{{$invoice->id}}";</script>
    <script src="{{asset('assets/js/admin/purchase/invoice.js')}}"></script>
@endsection
