@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Checkout')

@section('style')
@endsection
@section('content')
    <div class="container my-5">
        <div class="back-link mb-3">
            <a href="{{route('cart.index')}}" class="hover-none">
                <i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Cart
            </a>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="payment_gateway mb-5">
                    @guest
                        <div class="alert" role="alert">
                            If you already have account, please <a href="{{route('cart.login')}}?redirect={{route("cart.checkout")}}" class="cart_login text-primary">login</a> first.
                            If you don't have account yet, type email here.  <br>If null, we will send email to your payment email.
                            <br>
                            <label>
                                <input type="email" name="guest_email" class="fcustom-input" autocomplete="off" id="guest_email">
                            </label>
                        </div>
                    @endguest

                    <div class="tw-flex tw-flex-col md:tw-w-full">
                        <h2 class="tw-mb-4 tw-font-bold md:tw-text-xl tw-text-heading">Shipping Address</h2>
                        <form id="checkout_form" action="{{ route('cart.checkout.items') }}" class="tw-justify-center tw-w-full tw-mx-auto">
                          <div>
                            <div class="tw-space-x-0 lg:tw-flex lg:tw-space-x-4">
                              <div class="tw-w-full lg:tw-w-1/2">
                                <label for="first_name" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500">First Name</label>
                                <input
                                  name="first_name"
                                  type="text"
                                  placeholder="First Name"
                                  class="tw-w-full tw-px-4 tw-py-3 tw-text-sm tw-border tw-border-gray-300 tw-rounded lg:tw-text-sm focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                  required
                                />
                              </div>
                              <div class="tw-w-full lg:tw-w-1/2">
                                <label for="last_name" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500">Last Name</label>
                                <input
                                  name="last_name"
                                  type="text"
                                  placeholder="Last Name"
                                  class="tw-w-full tw-px-4 tw-py-3 tw-text-sm tw-border tw-border-gray-300 tw-rounded lg:tw-text-sm focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                  required
                                />
                              </div>
                            </div>
                            <div class="tw-mt-4">
                              <div class="tw-w-full">
                                <label for="email" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500">Email</label>
                                <input
                                  name="email"
                                  type="text"
                                  placeholder="Email"
                                  class="tw-w-full tw-px-4 tw-py-3 tw-text-sm tw-border tw-border-gray-300 tw-rounded lg:tw-text-sm focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                  required
                                />
                              </div>
                            </div>
                            <div class="tw-mt-4">
                              <div class="tw-w-full">
                                <label for="address" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500">Address</label>
                                <textarea
                                  class="tw-w-full tw-px-4 tw-py-3 text-xs tw-border tw-border-gray-300 tw-rounded lg:tw-text-sm focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                  name="address"
                                  cols="20"
                                  rows="4"
                                  placeholder="Address"
                                  required
                                ></textarea>
                              </div>
                            </div>
                            <div class="tw-mt-4 tw-space-x-0 lg:tw-flex lg:tw-space-x-4">
                              <div class="tw-w-full lg:tw-w-1/3">
                                <label for="city" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500">City</label>
                                <input
                                  name="city"
                                  type="text"
                                  placeholder="City"
                                  class="tw-w-full tw-px-4 tw-py-3 tw-text-sm tw-border tw-border-gray-300 tw-rounded lg:tw-text-sm focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                  required
                                />
                              </div>
                              <div class="tw-w-full lg:tw-w-1/3">
                                <label for="state" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500">State</label>
                                <input
                                  name="state"
                                  type="text"
                                  placeholder="State"
                                  class="tw-w-full tw-px-4 tw-py-3 tw-text-sm tw-border tw-border-gray-300 tw-rounded lg:tw-text-sm focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                  required
                                />
                              </div>
                              <div class="tw-w-full lg:tw-w-1/3">
                                <label for="zip" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500"> Postcode</label>
                                <input
                                  name="zip"
                                  type="text"
                                  placeholder="Post Code"
                                  class="tw-w-full tw-px-4 tw-py-3 tw-text-sm tw-border tw-border-gray-300 tw-rounded lg:tw-text-sm focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                  required
                                />
                              </div>
                            </div>
                            <div class="tw-mt-4 tw-space-x-0 lg:tw-flex lg:tw-space-x-4">
                              <div class="tw-w-full lg:tw-w-1/2">
                                <label for="phone" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500">Phone</label>
                                <input
                                  name="phone"
                                  type="text"
                                  placeholder="+1 (123) 456 7890"
                                  class="tw-w-full tw-px-4 tw-py-3 tw-text-sm tw-border tw-border-gray-300 tw-rounded lg:tw-text-sm focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                  required
                                />
                              </div>
                            </div>
                            <div class="tw-flex tw-items-center mt-4">
                              <label class="tw-flex tw-items-center tw-text-sm group tw-text-heading">
                                <input name="saveInfo" type="checkbox" class="tw-w-5 tw-h-5 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-1" />
                                <span class="tw-ml-2">Save this information for next time</span></label
                              >
                            </div>
                            <div class="tw-relative pt-3 xl:pt-6">
                              <label for="note" class="tw-block tw-mb-3 tw-text-sm tw-font-semibold tw-text-gray-500"> Notes (Optional)</label
                              ><textarea
                                name="notes"
                                class="tw-flex tw-items-center tw-w-full tw-px-4 tw-py-3 tw-text-sm tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-1 focus:tw-ring-blue-600"
                                rows="4"
                                placeholder="Notes for delivery"
                              ></textarea>
                            </div>

                            <div class="tw-mt-4 tw-flex tw-justify-center tw-gap-2">
                                @if(in_array('stripe', $gateway))

                                    @guest
                                        <a
                                            href="{{route('cart.login')}}?redirect={{route("cart.checkout")}}"
                                            class="submit-btn tw-w-full tw-px-6 tw-py-2 tw-text-white text-center tw-bg-blue-500 hover:tw-bg-blue-800 hover:tw-text-white disabled:tw-bg-gray-200"
                                        >
                                            Process with Stripe
                                        </a>
                                    @else
                                        <button
                                            {{ count($cart->items) ? '' : 'disabled' }}
                                            type="submit"
                                            data-type="stripe"
                                            class="submit-btn tw-w-full tw-px-6 tw-py-2 text-blue-200 tw-bg-blue-600 hover:tw-bg-blue-900 tw-text-white disabled:tw-bg-gray-200"
                                        >
                                            Process with Stripe
                                        </button>
                                    @endguest

                                @endif

                                @if(in_array('paypal', $gateway))

                                    @guest
                                        <a
                                            href="{{route('cart.login')}}?redirect={{route("cart.checkout")}}"
                                            class="submit-btn tw-w-full tw-px-6 tw-py-2 tw-text-white text-center tw-bg-blue-500 hover:tw-bg-blue-800 hover:tw-text-white disabled:tw-bg-gray-200"
                                        >
                                            Process with Paypal
                                        </a>
                                    @else
                                        <button
                                            {{ count($cart->items) ? '' : 'disabled' }}
                                            type="submit"
                                            data-type="paypal"
                                            class="submit-btn tw-w-full tw-px-6 tw-py-2 text-blue-200 tw-bg-blue-500 hover:tw-bg-blue-800 tw-text-white disabled:tw-bg-gray-200"
                                        >
                                            Process with Paypal
                                        </button>
                                    @endguest

                                @endif
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="checkout-cart">
                    <h3>Your Cart</h3>
                    <ul class="product-list">
                        @foreach($cart->items as $item)
                            <li>
                                <div class="pl-thumb">
                                    <img src="{{$item['image']}}" alt="{{$item['front']}}" class="width-80px">
                                </div>
                                <div class="m-0" style="line-height:18px;">
                                    <h6>{{$item['front']?? ''}}</h6>
                                    @if($item['type']==='ecommerce')
                                        @if($item['parameter']['color_id'])
                                            <span class="font-size12">color: {{$item['parameter']['color']}}</span><br>
                                        @endif
                                        @if($item['parameter']['size_id'])
                                            <span class="font-size12">size: {{$item['parameter']['size']}}</span><br>
                                        @endif
                                        @if($item['parameter']['custom_id'])
                                            <span class="font-size12">{{$item['parameter']['custom_name']?? ''}}: {{$item['parameter']['custom']}} </span><br>
                                        @endif
                                    @endif
                                </div>
                                <p>
                                    @if(in_array($item['type'], ['blogAds', 'siteAds', 'directoryAds'])&&$item['item']['price']['type']=='period')
                                        Period: <br>
                                        @foreach($item['parameter']['start'] as $key2=>$start)
                                            <span class="font-size14">{{$start}} ~ {{$item['parameter']['end'][$key2]}}</span>
                                            <br>
                                        @endforeach
                                    @else
                                        Quantity: {{$item['quantity']}}
                                    @endif
                                </p>
                                <p>
                                    Price: ${{$item['price']}}
                                    @if($item['recurrent']==1)
                                        / {{periodName($item['parameter']['period'], $item['parameter']['period_unit'])}} <br>(Subscription)
                                    @endif
                                </p>
                            </li>
                            <div class="clearfix"></div>
                            <hr class="my-2">
                        @endforeach
                    </ul>
                    <ul class="price-list">
                        <li>
                            Onetime Total: <span>${{$cart->onetimeTotalPrice}}</span>
                        </li>
                        <li>
                            Subscription Total: <span>${{$cart->subTotalPrice}}</span>
                        </li>
                        <li class="total">
                            Total: <span>${{$cart->totalPrice}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
<script src="{{asset('assets/js/front/cart/checkout.js')}}"></script>
<script>
        $(".paypal_smt_btn").on("click", function(e) {
            e.preventDefault();
            $(".guest_email_input").val($("#guest_email").val());
            $(".paypal_smt_btn").append("<i class='fa fa-spin fa-spinner ml-3'></i>").prop("disabled", true);
            $("#paypal_submit_form").submit();
        });
    </script>
@endsection
