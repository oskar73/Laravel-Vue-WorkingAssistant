@extends('layouts.master')

@section('title', 'Ecommerce Store Front Setting')
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
                    <span class="m-nav__link-text">Ecommerce Store</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Setting</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile md-pt-50">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Ecommerce Payment Setting
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="container">
                <div class="row">
                    @if (in_array('stripe', $gateway))
                    <div class="col-md-6">
                        <h5 class="mt-6">Stripe Account</h5>
                        <hr>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="px-3">Charges Enabled</td>
                                    <td class="d-flex">
                                        @if (optional($stripeAccount)->charges_enabled)
                                        <span class="c-badge c-badge-success">Complete</span></p>
                                        @else
                                        <span class="c-badge c-badge-danger">Incomplete</span></p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3">Payouts Enabled</td>
                                    <td class="d-flex">
                                        @if (optional($stripeAccount)->payouts_enabled)
                                        <span class="c-badge c-badge-success">Complete</span></p>
                                        @else
                                        <span class="c-badge c-badge-danger">Incomplete</span></p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3">Details Enabled</td>
                                    <td class="d-flex">
                                        @if (optional($stripeAccount)->details_submitted)
                                        <span class="c-badge c-badge-success">Complete</span></p>
                                        @else
                                        <span class="c-badge c-badge-danger">Incomplete</span></p>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if (!is_null($stripeAccount) && $stripeAccount->charges_enabled && $stripeAccount->payouts_enabled && $stripeAccount->details_submitted )
                        <button data-type="stripe" class="btn m-btn--square m-btn--sm btn-info mt-4 open-account">
                            Open Stripe Account
                        </button>
                        @else
                        <button data-type="stripe" class="btn m-btn--square m-btn--sm btn-info mt-4 connect-account">
                            @if (is_null($stripeAccount))
                            Connect Stripe Account
                            @else
                            Continue
                            @endif
                        </button>
                        @endif
                    </div>
                    @endif

                    @if (in_array('paypal', $gateway))
                    <div class="col-md-6">
                        <h5 class="mt-6">Paypal Account</h5>
                        <hr>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="px-3">Merchant Id</td>
                                    <td class="d-flex">{{ optional($paypalAccount)->merchant_id }}</td>
                                </tr>
                                <tr>
                                    <td class="px-3">Charges Enabled</td>
                                    <td class="d-flex">
                                        @if (optional($paypalAccount)->payments_receivable)
                                        <span class="c-badge c-badge-success">Complete</span></p>
                                        @else
                                        <span class="c-badge c-badge-danger">Incomplete</span></p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3">Email Verification</td>
                                    <td class="d-flex">
                                        @if (optional($paypalAccount)->primary_email_confirmed)
                                        <span class="c-badge c-badge-success">Complete</span></p>
                                        @else
                                        <span class="c-badge c-badge-danger">Incomplete</span></p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3">App Permission</td>
                                    <td class="d-flex">
                                        @if (optional($paypalAccount)->permission_granted)
                                        <span class="c-badge c-badge-success">Complete</span></p>
                                        @else
                                        <span class="c-badge c-badge-danger">Incomplete</span></p>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if (optional($paypalAccount)->payments_receivable )
                        <a href="https://paypal.com" data-type="paypal" class="btn m-btn--square m-btn--sm btn-info mt-4">
                            Open Paypal Account
                        </a>
                        @else
                        <button data-type="paypal" class="btn m-btn--square m-btn--sm btn-primary mt-4 connect-account">
                            @if (is_null($paypalAccount))
                            Connect Paypal Account
                            @else
                            Continue
                            @endif
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/ecommerce/setting.js')}}"></script>
@endsection
