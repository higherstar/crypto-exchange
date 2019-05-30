@component('mail::message')
    <div style="font-size: 14px;">


<table style="empty-cells: show;" width="100%">
    <tbody>
    <tr>
        <td style="font-weight: bold">
            {{$customer_name}}
        </td>
        <td>

        </td>
        <td style="text-align: right">
            <em>{{ $order->payment->paid_at->format('Y-m-d h:i A') }}</em>
        </td>
    </tr>
    <tr>
        <td>
            {{$phone_contact}}
        </td>
        <td></td>
        <td style="text-align: right">
            <em>Receipt #: {{$receipt_no}}</em>
        </td>
    </tr>
    <tr>
        <td>
            {{$email_contact}}
        </td>
    </tr>
    </tbody>
</table>

<br><br>
<h1 style="text-align: center; width: 100%; font-weight: 500; font-size: 36px">Receipt</h1>

<style>
    .lucida{
        font-family: 'Lucida Console', Monaco, monospace;
    }
</style>
<table width="100%" style="text-align: left">
    <thead>
    <tr>
        <th style="text-align: left">Amount</th>
        <th></th>
        <th style="text-align: right">Total</th>
    </tr>
    <tr>
        <th colspan="3"><hr></th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderItems as $orderItem)
        <tr>
            <td style="text-align: left" class="lucida">
                {{$orderItem->crypto_amount}} {{ $orderItem->cryptocurrency->shortname }}
            </td>
            <td></td>
            <td style="text-align: right" class="lucida">
                {{$orderItem->fiat_amount}} KWD
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"><hr></td>
        </tr>
        <tr>
            <td>

            </td>
            <td style="text-align: right; font-size: 18px; font-weight: bold;">
                <h4><strong>Total</strong></h4>
            </td>
            <td style="text-align: right; color: #3c763d; font-size: 18px; font-weight: bold;">
                <h4><strong>{{$total}} KWD</strong></h4>
            </td>
        </tr>
    </tfoot>
</table>
    </div>
@endcomponent