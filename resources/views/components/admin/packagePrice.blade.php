@forelse($prices as $price)
    <tr >
        <td>${{$price->price}}</td>
        <td>
            @if($price->slashed_price)
                <span class="slashed_price_text">${{$price->slashed_price}}</span>
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
            @if($price->standard===1)
                <span class="c-badge c-badge-success">Standard</span>
            @endif
        </td>
        <td>
            @if($price->status===1)
                <span class="c-badge c-badge-success">Active</span>
            @else
                <span class="c-badge c-badge-danger" >InActive</span>
            @endif
        </td>
        <td>
            <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-price="{{$price}}">
                Edit Price
            </a>
            <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon delBtn" data-id="{{$price->id}}">
                Delete Price
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6">No record</td>
    </tr>
@endforelse
