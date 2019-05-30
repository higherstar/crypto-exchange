@extends('layouts.app')

@section('header')

@endsection

@section('container-content')
<div class="container">
    <div class="row">
        <div class="well col-xs-12 col-sm-10 col-md-6 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div><strong>YallaBit Customer</strong></div>
                    <div><abbr title="Phone">P:</abbr> +965 96061886</div>
                    <div><abbr title="Email">E:</abbr> support@yallabit.com</div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>
                        <em>{{ $order->payment->paid_at->format('Y-m-d h:i A') }}</em>
                    </p>
                    <p>
                        <em>Receipt #: {{$order->payment->track_id}}</em>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <h1>Receipt</h1>
                </div>
                </span>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        {{--<th>Cryptocurrency</th>--}}
                        <th>Amount</th>

                        <th class="text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $order->order_items as $order_item)
                    <tr>
                        {{--<td class="col-md-4"><em>Bitcoin (BTC)</em></h4></td>--}}
                        <td class="col-md-8" style="font-family: 'Lucida Console', Monaco, monospace">{{$order_item->crypto_amount}} {{ $order_item->cryptocurrency->shortname }}</td>
                        <td class="col-md-4 text-right" style="font-family: 'Lucida Console', Monaco, monospace">{{$order_item->fiat_amount}} KWD</td>
                    </tr>
                    @endforeach
                    <tr>
                        {{--<td>  </td>--}}
                        <td class="text-right"><h4><strong>Total</strong></h4></td>
                        <td class="text-right text-success"><h4 ><strong>{{$order->getDueAmount()}} KWD</strong></h4></td>
                    </tr>
                    </tbody>
                </table>
                <div>
                    <h2 style="text-align:center;">
                        Thank you for your order.
                    </h2>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection