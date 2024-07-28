<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteTitle}}</title>
    <link rel="icon" href="{{ asset("images/".setting('fav_icon')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        @media print {

            html,
            body {
                width: 80mm;
                height: auto;
                margin-left: auto;
                margin-right: auto;
                color: #000;
                /* position: absolute; */
            }
        }

        .tax-table {
            font-size: 12px;
            width: 100%;
            margin-bottom: 1rem;
        }

        .tax-table td {
            text-align: left;
        }

        .tax-table th {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container pt-5" style="width:310px !important;font-family:monospace;font-size:12px;">

        <div class="printDiv" style="width:300px" id="printDiv">
            <!-- <div class="logo d-flex justify-content-center">
                <img width="80px" src="http://picsum.photos/seed/{{ rand(0, 100000) }}/50" alt="">
            </div> -->
            <div class="d-flex justify-content-between mt-2">
                <span>{{date('d.m.Y', strtotime($order->created_at))}}</span>
                <span>{{date('H:i:s', strtotime($order->created_at))}}</span>
            </div>
            <p class="text-center mt-2 mb-0"><b>{{ trans('order_type.'.$order->order_type)}}</b> - {{$order->order_code}}</p>
            <div class="customer-details">
                <p class="mb-1"><b>{{ ucfirst($order->user->name)}},</b></p>
                <p class="mb-0"><b>{{ $order->user->address }}</b></p>
                <!-- <p class="mb-0"><b>{{-- $address->postcode --}},{{-- $address->city --}}</b></p> -->
                <p class="mb-0"><b>{{__('levels.tel')}}. {{$order->user->phone}}</b></p>
            </div>
            <hr class="m-0" style="opacity: 0.9 !important; border-top:2px solid">

            <h3 class="m-1 text-center">Order time:</h3>

            @if($order->time_slot != 'As soon as possible')
            <h3 class="m-1 text-center"><b>{{ date('H:i:s', strtotime($order->time_slot)) }} </b></h3>
            @else
            <h5 class="m-1 text-center"><b>{{ __('frontend.as_soon_as_possible') }}</b></h5>
            @endif
            <hr class="m-0" style="opacity: 0.9 !important; border-top:2px solid">
            <div class="items px-2 mt-1 ">
                @foreach($items as $item)
                <div class="d-flex justify-content-between">
                    <div class="d-flex" style="width:70%">
                        <p class="mb-0" style="width:20%">{{$item->quantity}}x</p>
                        <p style="margin-left:.5rem;width:80%;font-weight:600;font-size:18px;" class="mb-0">{{$item->menuItem->name}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class=""> {{currencyFormat($item->item_total)}}</div>
                        <div class="float-right" style="margin-left:.5rem;"><b> {{ isset($item->menuItem->taxInfo) ? $item->menuItem->taxInfo->label : '' }}</b></div>
                    </div>
                </div>
                <?php
                $option = explode(',', $item->Options);
                ?>

                <p class="mb-0" style="margin-left: 2.7rem;">
                    {{ $item->variation ? ' (' . ($item->variation->relatedMenuItem?->name ?: $item->variation->name) . ')' : '' }}

                </p>
                @if ($item->options)
                @foreach (json_decode($item->options, true) as $option)
                <p class="mb-0" style="margin-left: 2.7rem;">{{ $option['name'] }}</p>

                @endforeach
                @endif
                <h2 style="font-size:14px; font-weight:600; padding-top:13px; ">{{ __('levels.instructions') }}<span style="font-weight:600; padding-left:15px;">{{ $item->instructions }}</span></h2>
                <hr class="m-0" style="opacity: 0.9 !important; border-top:2px solid">
                @endforeach

            </div>
            {{-- <hr class="m-0" style="opacity: 0.9 !important; border-top:2px solid"> --}}
            <div class="px-2" style="float:right">
                <div class="d-flex">
                    <span style="margin-right:2rem">{{ __('levels.sub_total') }}</span>
                    <span> {{currencyFormat($order->sub_total)}}</span>
                    @if(isset($delivery_tax))
                    <p class="float-right" style="margin-left:.5rem;margin-bottom:0;"> <b>{{$delivery_tax->label}}</b></p>
                    @endif
                </div>
            </div>
            <div class="px-2" style="float:right">
                <div class="d-flex">
                    <span style="margin-right:2rem">{{__('levels.delivery_charge')}}</span>
                    <span> {{currencyFormat($order->delivery_charge)}}</span>
                    @if(isset($delivery_tax))
                    <p class="float-right" style="margin-left:.5rem;margin-bottom:0;"> <b>{{$delivery_tax->label}}</b></p>
                    @endif
                </div>
            </div>

            <div class="px-2" style="float:right">
                <div class="d-flex">
                    <span style="margin-right:2rem;font-weight: bold">{{__('levels.our_total')}}</span>
                    <span style="font-weight: bold"> {{ currencyFormat($order->total)}}</span>
                    @if(isset($delivery_tax))
                    <p class="float-right" style="margin-left:.5rem;margin-bottom:0;"> <b>{{$delivery_tax->label}}</b></p>
                    @endif
                </div>
            </div>
            <p class="mb-0 text-center" style="clear:right;"><b></b></p>
            <p class="mb-0" style="margin-top: 5px !important;"><b>{{ request()->getHost() }}</b></p>
            <div class="d-flex justify-content-between" style="width:90%; height: 25px !important;">
                <p class="mb-0"><b>

                        @if($order->payment_method =='5')
                        {{ __('levels.Barzahlung bei Lieferung') }}
                        @endif
                        @if($order->payment_method =='30')
                        {{__('EC-Karte')}}
                        @endif
                        @if($order->payment_method =='10')
                        {{('Paypal')}}
                        @endif
                        @if($order->payment_method <>'10' && $order->payment_method <>'30'&& $order->payment_method <>'5')
                                    {{__('levels.paid_online')}}
                                    @endif
                    </b></p>
                @if($order->payment_method == '10')
                <p class=""><b>{{ currencyFormat($order->paid_amount )}}</b></p>
                @endif
                @if($order->payment_method <> '10')
                    <p class=""><b>{{ currencyFormat($order->total) }}</b></p>
                    @endif

            </div>
            @if(!blank($taxes))
            <table class="tax-table">
                <thead>
                    <tr>
                        <th>{{__('levels.tax')}}</th>
                        <th>{{__('levels.included')}}</th>
                        <th>{{__('levels.net')}}</th>
                        <th>{{__('levels.gross')}}</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($taxes as $key => $value)
                    <tr>
                        <td>{{$key." = ".$value."%"}}</td>
                        <td>{{$taxIncluded[$key]}}</td>
                        <td>{{$taxNet[$key]}}</td>
                        <td>{{$taxGross[$key]}}</td>

                    </tr>
                    @endforeach
                    <tr>
                        <td>{{$delivery_tax->label.' = '.$delivery_tax->rate.'%'}}</td>
                        <td>{{number_format(($order->delivery_charge*$delivery_tax->rate)/100,2)}}</td>
                        <td>{{number_format($order->delivery_charge - (($order->delivery_charge*$delivery_tax->rate)/100),2)}}</td>
                        <td>{{number_format($order->delivery_charge,2)}}</td>

                    </tr>
                </tbody>
            </table>
            @endif
            <p class=" text-center" style="font-size: 1rem;"><b>{{__('levels.thanks_for_your_order')}}</b></p>
            <p class="mb-0"><b>{{__('levels.internet_order_from')}} </b> {{date('H:i:s', strtotime($order->created_at))}}</p>
            <p class="mb-0">{{__('order.tax_id')}} <b>217/5276/6302</b></p>
        </div>
        <div class="mt-5 d-flex justify-content-between">
            <button onclick="printDiv('printDiv')" class=" btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> {{__('levels.print')}}</button>
            <a class="btn btn-info" href="{{route('admin.orders.index')}}"> {{__('levels.go_back')}}</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/printInvoice.js') }}"></script>
</body>

</html>