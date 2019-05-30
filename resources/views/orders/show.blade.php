@extends('layouts.app')

@section('header')
<style>
    .navbar-wrapper {
        position:static;
    }
    .form-group{
        margin-bottom: 15px;
    }
</style>
@endsection


@section('no-container-content')
    <div class="container" style="margin-top: 20px">
        <div class="" style="display: flex;">
            <br>
            <form action="{{ route('payments.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="col-md-7 col-sm-6 col-xs-12">
                        <!--SHIPPING METHOD-->
                        <div class="panel panel-default">
                            <div class="panel-heading text-center"><h4>Account Information</h4></div>
                            <div class="same-height panel-body">
                                <p>Please provide your information to be able to process the transaction.
                                <div class="form-group">
                                    <input type="text" placeholder="Email Address / البريد الإلكتروني" class="form-control" name="country" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Full Name / أسم الكامل" name="first_name" class="form-control" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Mobile Number / رقم الموبايل" name="phone_number" class="form-control" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Bitcoin Address / بريد البتكوين" name="email_address" class="form-control" value="" />
                                </div>
                                <div class="text-center">
                                   Already have an account? <a href="#">Login</a>
                                </div>
                            </div>
                        </div>
                        <!--SHIPPING METHOD END-->
                    </div>
                    <div class="col-md-5 col-sm-6 col-xs-12">
                        <!--REVIEW ORDER-->
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h4>Review Order</h4>
                            </div>
                            <div class="same-height panel-body">

                                @foreach ($order->order_items as $order_item)
                                <div class="col-md-12">
                                    <strong>{{ $order_item->cryptocurrency->name }}(s)</strong>
                                    <div class="pull-right"><span style="font-family: 'Lucida Console', Monaco, monospace">{{ $order_item->crypto_amount }} {{ $order_item->cryptocurrency->shortname }} @ {{ $order_item->price_per_unit  }} KWD</span></div>
                                </div>
                                <div class="col-md-12">
                                    <small>BTC/KWD</small>
                                    <div class="pull-right"><span></span></div>
                                    <hr>
                                </div>
                                @endforeach
                                <div class="col-md-12">
                                    <strong>Order Total</strong>
                                    <div class="pull-right"><span style="font-family: 'Lucida Console', Monaco, monospace">{{ number_format($order->getDueAmount(), 3) }} KWD</span></div>
                                    <hr>
                                </div>
                                <div >
                                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Pay via KNET"/>
                                    <div style="padding: 5px; text-align:justify; line-spacing: 1em">
                                        <small><i><b>
                                            Disclaimer: The price above updates every 60 seconds.
                                            In times of high volatility, your price will automatically update.
                                            Please process your payment as soon as possible to guarantee the above quote(s).
                                            </b></i></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--REVIEW ORDER END-->
                    </div>
                </div>
                <input type="hidden" value="{{ encrypt($order->id) }}" name="oid"/>
            </form>
        </div>
    </div>
    <div class="device-xs visible-xs"></div>
    <div class="device-sm visible-sm"></div>
    <div class="device-md visible-md"></div>
    <div class="device-lg visible-lg"></div>
@endsection

@section('additional-script')
    <script>
        function isBreakpoint( alias ) {
            return $('.device-' + alias).is(':visible');
        }
        $(document).ready(function($) { //noconflict wrapper
            var heights = $(".same-height").map(function() {
            return $(this).height();
            }).get(),
            maxHeight = Math.max.apply(null, heights);
            if( !isBreakpoint('xs') ) {
                $(".same-height").height(maxHeight);
            }
        });
    </script>
@endsection