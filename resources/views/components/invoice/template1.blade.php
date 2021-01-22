<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - #{{$invoice->id}}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            background-color:#fff;
            padding: 30px;
            border: 1px solid #35b273;
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box .text-right {
            text-align: right;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }
        .invoice-box table tr td:nth-child(3) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(3) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="3">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{$website->logo?? asset('assets/img/default_logo.png')}}" style="width:100%; max-width:300px;min-width:200px;">
                        </td>

                        <td class="text-right">
                            Invoice #: <b>{{$invoice->id}}</b><br>
                            Status: <b>{{$invoice->paid==1?"PAID":"UNPAID"}}</b><br>
                            Created: <b>{{$invoice->created_at->toDateString()}}</b><br>
{{--                            Due: February 1, 2015--}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="3">
                <table>
                    <tr>
                        <td>
                            Bizinabox, LLC.<br>
                            12345 Sunny Road<br>
                            Boca Raton, FL 33486
                        </td>

                        <td class="text-right">
                            {{$invoice->user->name?? ''}}.<br>
                            {{$invoice->user->email?? ''}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="heading">
            <td>
                Item
            </td>
            <td>
                Qty
            </td>

            <td>
                Price
            </td>
        </tr>

        @if($invoice->transaction->recurrent==1)
            <tr class="item last">
                <td>
                    {{json_decode($invoice->transaction->orderItem->product_detail)->name?? json_decode($invoice->transaction->orderItem->product_detail)->title?? ''}} ({{$invoice->transaction->orderItem->product_type}})
                </td>
                <td>
                    {{$invoice->transaction->orderItem->quantity}}
                </td>
                <td>
                    ${{formatNumber($invoice->transaction->orderItem->sub_total)}}
                </td>
            </tr>
        @else
            @foreach($invoice->transaction->onetimeItems as $onetime)
            <tr class="item @if($loop->last) last @endif">
                <td>
                    {{json_decode($onetime->product_detail)->name?? ''}} ({{$onetime->product_type}})
                </td>

                <td>
                    {{$onetime->quantity}}
                </td>
                <td>
                    ${{formatNumber($onetime->sub_total)}}
                </td>
            </tr>
            @endforeach
        @endif
        <tr class="total">
            <td></td>
            <td></td>
            <td>
                Total: ${{formatNumber($invoice->transaction->amount)}}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
