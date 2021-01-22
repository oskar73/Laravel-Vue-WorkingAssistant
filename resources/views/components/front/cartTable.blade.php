@if($cart&&$cart->items)
    @forelse($cart->items as $key=>$item)
    <tr>
        <td>
            <img src="{{$item['image']}}" alt="" class="width-100px my-0">
        </td>
        <td class="text-left">
            @if (!moduleName( $item['type'] ?? '') == '')
                <span class="text-grey font-size14" >({{moduleName( $item['type'] ?? '')}})</span> <br>
            @else
                <span class="text-grey font-size14" >&nbsp;</span>
            @endif
            <div class="m-0" style="line-height:18px;">
                <p class="m-0">{{$item['front']?? ''}}</p>
                @if($item['type']==='ecommerce')
                    @if($item['parameter']['color_id'])
                        <span class="font-size12">color: {{$item['parameter']['color']}}</span><br>
                    @endif
                    @if($item['parameter']['size_id'])
                         <span class="font-size12">sicze: {{$item['parameter']['size']}}</span><br>
                    @endif
                    @if($item['parameter']['custom_id'])
                         <span class="font-size12">{{$item['parameter']['custom_name']?? ''}}: {{$item['parameter']['custom']}} </span><br>
                    @endif
                @endif
            </div>
            <a href="{{$item['url']?? ''}}"><i class="fas fa-eye"></i> View</a>
        </td>
        <td class="text-center">
            ${{$item['price']}}
            @if($item['recurrent']==1)
                / {{periodName($item['parameter']['period'], $item['parameter']['period_unit'])}} <br>(Subscription)
            @endif
        </td>
        <td class="text-right">
            @if(in_array($item['type'], ['blogAds', 'siteAds', 'directoryAds'])&&$item['item']['price']['type']=='period')
                @foreach($item['parameter']['start'] as $key2=>$start)
                    {{$start}} ~ {{$item['parameter']['end'][$key2]}} <br>
                @endforeach
                <input type="hidden" name="items[{{$key}}]" class="fcustom-input" value="1"/>
            @else
                <div class="w-70px m-auto">
                    <input type="number" name="items[{{$key}}]" class="fcustom-input" value="{{$item['quantity']?? 0}}"/>
                </div>
            @endif
        </td>
        <td>
            @if (isset($item['discount']))
                {{ $item['discount'] }}%
            @else
                N/A
            @endif
        </td>
        <td>
            ${{formatNumber($item['price']*$item['quantity'])}}
        </td>
        <td>
            <a href="javascript:void(0);" class="c_rm_btn" data-id="{{$key}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center">No items</td>
    </tr>
    @endforelse
@else
    <tr>
        <td colspan="6" class="text-center">No items</td>
    </tr>
@endif
