
<div class="container">
    {{-- Bizinabox main account webhook handler, stripe account connect to withdraw --}}
    {{-- @if(count(option("gateway", []))==0)
        <div class="alert alert-primary  m-alert m-alert--air m-alert--outline text-dark" role="alert">
            You didn't add any payment gateway yet. Please add your payment gateway first. <a href="{{route('admin.setting.payment.index')}}">Set Payment</a>.
        </div>
    @endif --}}
    @if(!$price->price)
        <div class="text-right">
            <a href="javascript:void(0);" class="btn m-btn--square m-btn btn-outline-success btn-sm addPriceBtn">+ Add Price Plan</a>
        </div>
    @else
        <p>
            Standard Price
        </p>
        <div class="table-responsive">
            <table class="table table-bordered ajaxTable datatable">
                <thead>
                <tr>
                    <th>Price</th>
                    <th>Slashed Price</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="price_area">
                    <tr>
                        <td>${{$price->price}}</td>
                        <td>
                            @if($price->slashed_price)
                                <span class="">${{$price->slashed_price}}</span>
                            @endif
                        </td>
                        <td>
                            @if($price->recurrent===0)
                                Onetime
                            @else
                                Every {{periodName($price->period, $price->period_unit)}} (Recurrent)
                            @endif
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-price="{{$price}}">
                                Edit Price
                            </a>
                            <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon delPriceBtn">
                                Delete Price
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
            @if($product->size||$product->color||$product->variant)
            <p>
                Variants Prices
            </p>
            <div class="table-responsive">
                <table class="table table-bordered ajaxTable datatable">
                    <thead>
                    <tr>
                        <th>Variant Type</th>
                        <th>Price</th>
                        <th>Slashed Price</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="price_area">
                        @foreach($product->getAllVariants() as $key=>$item)
                            <tr class="variants-{{$key}}">
                                <td>{{$item['name']}}</td>
                                <td class="price">
                                    @if(isset($mix[$item['size_id'].$item['color_id'].$item['variant_id']]))
                                        <input type="text" class="form-control width-80px m-auto" value="{{$mix[$item['size_id'].$item['color_id'].$item['variant_id']]['price']}}">
                                    @else
                                        <input type="text" class="form-control width-80px m-auto" value="{{$price->price}}">
                                    @endif
                                </td>
                                <td class="slashed_price">
                                    @if(isset($mix[$item['size_id'].$item['color_id'].$item['variant_id']]))
                                        <input type="text" class="form-control width-80px m-auto " value="{{$mix[$item['size_id'].$item['color_id'].$item['variant_id']]['slashed_price']}}">
                                    @else
                                        <input type="text" class="form-control width-80px m-auto " value="{{$price->slashed_price}}">
                                    @endif
                                </td>
                                <td>
                                    @if($price->recurrent===0)
                                        Onetime
                                    @else
                                        Every {{periodName($price->period, $price->period_unit)}} (Recurrent)
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon updatePriceBtn"
                                       data-size="{{$item['size_id']}}"
                                       data-color="{{$item['color_id']}}"
                                       data-variant="{{$item['variant_id']}}"
                                    >
                                        Update Price
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</div>
