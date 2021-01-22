@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Cart')

@section('meta')
    @include("components.front.seo", $seo?? [])
@endsection
@section('style')
@endsection
@section('content')
<div class="container">
    <form action="{{route('cart.update')}}" id="updateCartForm">
        @csrf
        <div class="row my-5">
            <div class="col-12 shop-cart-table table-responsive">
                <table class="table shop-cart text-center v-align-c-td">
                    <thead>
                        <tr>
                            <th class="border-bottom-0"></th>
                            <th class="border-bottom-0 text-left">Product</th>
                            <th class="border-bottom-0">Price</th>
                            <th class="border-bottom-0">Qty</th>
                            <th class="border-bottom-0">Discount</th>
                            <th class="border-bottom-0">Sub Total</th>
                            <th class="border-bottom-0">
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="emptyCrtBtn">Empty Cart</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="cart_item_area border-bottom">
                        <tr>
                            <td colspan="6" class="text-center">
                                <i class="loading_div fas fa-spinner fa-spin fa-fw fa-3x"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <div class="text-right">
                    <button type="submit" class="btn btn-success updateCrtBtn tw-bg-green-600">Update Cart</button>
                    <a href="javascript:void(0);" class="btn btn-primary">Continue Shopping</a>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group maxw-300">
                            <input type="text" class="form-control" name="coupon" placeholder="Coupon Code" value="{{ old('coupon') }}">
                            <button type="submit" class="btn btn-success mt-2 tw-bg-green-600">Apply Coupon</button>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="form-group maxw-400 ml-auto">
                            <p class="my-3"><b>Onetime SubTotal:</b> <span class="c_onetotal_price">$0.00</span></p>
                            <p class="my-3"><b>Subscription SubTotal:</b> <span class="c_subtotal_price">$0.00</span></p>
                            <p class="my-3"><b>Shipping and Handling:</b> <span>Free</span></p>
                            <hr class="my-3">
                            <p class="my-3"><b>Grand Total:</b> <span class="c_total_price">$0.00</span></p>
                            <hr class="my-3">
                            <a href="{{route('cart.checkout')}}" class="btn btn-success">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
    .md-theme-default a:not(.md-button) {
        color: #fff !important;
    }
</style>
@endsection
@section('script')
    <script src="{{asset('assets/js/front/cart/index.js')}}"></script>
@endsection
