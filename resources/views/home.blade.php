@extends('layouts.app')

@section('header')
    <style>
        .navbar-wrapper {
            position: absolute;
        }
    </style>
@endsection

@section('no-container-content')
{{--<!-- Carousel--}}
{{--================================================== -->--}}
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" >
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Bitcoin, Litecoin & Ripple</h1>
                        <p>Buy your desired cryptocurrency using KNET.</p>
                        {{--<p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>--}}
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" >
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Instant Delivery</h1>
                        <p>We will deliver your coins in less than 5 minutes after payment!</p>
                        {{--<p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>--}}
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" >
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Large Supply</h1>
                        <p>Buy as many coins as you'd like, we have a lot in store!</p>
                        {{--<p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>--}}
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="forth-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" >
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Lightning-fast confirmations</h1>
                        <p>We guarantee fast confirmations by using high network fees for the transaction.</p>
                        {{--<p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>--}}
                    </div>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div><!-- /.carousel -->
@endsection

@section('container-content')
{{--<!-- Marketing messaging and featurettes--}}
{{--================================================== -->--}}
{{--<!-- Wrap the rest of the page in another container to center all the content. -->--}}
{{--<!-- Three columns of text below the carousel -->--}}
<div class="row">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-lg-4">
        <img class="img-circle" src="{{ asset('images/small-bitcoin-icon.png') }}" alt="Generic placeholder image" width="140" height="140">
        <h2>Bitcoin (BTC)</h2>
        <h3 class="text-success"><div id="btckwd-arrow" class=""></div> <span id="btckwd-ticker">{{ \App\TradingPair::btcusd_kwd_last_price() }}</span> <small>KWD</small></h3>
        <form action="{{route('orders.store')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="trading_pair" value="btckwd"/>
            <input type="hidden" id='btckwd-fiat_based' name="fiat_based" value='1'/>
            <div class="form-group input-calculators">
                <p>Buy BTC for Kuwaiti Dinars.</p>
                <div class="input-group full-size">
                    <span class="input-group-addon swap-button" style="cursor:auto" data-pair="btckwd"><img src="{{ asset('images/flip-128.png') }}" width="16px" height="16px"></span>
                    <div class="input-group">
                        <input class="form-control" type="number" step='0.001' min="5.000" max="3000.000" placeholder="1000.000" value="100.000" name="btckwd[kwd]" data-pair="btckwd" data-type="fiat"/>
                        <span class="input-group-addon"  >KWD</span>
                    </div>
                    <div class="input-group">
                        <input class="form-control" type="number" step='0.00000001'  placeholder="1.0000000" name="btckwd[btc]" data-pair="btckwd" readonly data-type="crypto" />
                        <span class="input-group-addon" style="padding-right: 16px;padding-left: 15px;">BTC</span>
                    </div>
                </div>
            </div>
            <p><button type="submit" class="btn btn-default btn-primary" role="button">Buy now &raquo;</button></p>
        </form>
    </div><!-- /.col-lg-4 -->

    <div class="col-lg-4">
        <img class="img-circle" src="{{ asset('images/small-litecoin-icon.png') }}" alt="Generic placeholder image" width="140" height="140">
        <h2>Litecoin (LTC)</h2>
        <h3 class="text-success"><div id="ltckwd-arrow" class=""></div> <span id="ltckwd-ticker">{{ \App\TradingPair::ltcusd_kwd_last_price() }}</span> <small>KWD</small></h3>
        <form action="{{route('orders.store')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="trading_pair" value="ltckwd"/>
            <input type="hidden" id='ltckwd-fiat_based' name="fiat_based" value='1'/>
            <div class="form-group input-calculators">
                <p>Buy LTC for Kuwaiti Dinars.</p>
                <div class="input-group full-size">
                    <span class="input-group-addon swap-button" style="cursor:auto" data-pair="ltckwd"><img src="{{ asset('images/flip-128.png') }}" width="16px" height="16px"></span>
                    <div class="input-group">
                        <input class="form-control" type="number" step='0.001' value="100.000" min="5.000" max="3000.000" placeholder="1000.000" name="ltckwd[kwd]" data-pair="ltckwd" data-type="fiat" />
                        <span class="input-group-addon" >KWD</span>
                    </div>
                    <div class="input-group">
                        <input class="form-control" type="number" step="0.00000001" placeholder="1.0000000" name="ltckwd[ltc]" data-pair="ltckwd" readonly data-type="crypto" />
                        <span class="input-group-addon" style="padding-right: 17px;padding-left: 16px;">LTC</span>
                    </div>
                </div>
            </div>
            <p><button type="submit" class="btn btn-default btn-primary" href="#" role="button">Buy now &raquo;</button></p>
        </form>
    </div><!-- /.col-lg-4 -->

    <div class="col-lg-4">
        <img class="img-circle" src="{{ asset('images/ripple-icon.png') }}" alt="Generic placeholder image" width="140" height="140">
        <h2>Ripple (XRP)</h2>
        <h3 class="text-success"><div id="xrpkwd-arrow" class=""></div> <span id="xrpkwd-ticker">{{ \App\TradingPair::xrpusd_kwd_last_price() }}</span> <small>KWD</small></h3>
        <form action="{{route('orders.store')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="trading_pair" value="xrpkwd"/>
            <input type="hidden" id='xrpkwd-fiat_based' name="fiat_based" value='1'/>
            <div class="form-group input-calculators">
                <p>Buy XRP for Kuwaiti Dinars.</p>
                <div class="input-group full-size">
                    <span class="input-group-addon swap-button" style="cursor:auto" data-pair="xrpkwd"><img src="{{ asset('images/flip-128.png') }}" width="16px" height="16px"></span>
                    <div class="input-group">
                        <input class="form-control" type="number" value="100.000" step='0.001' min="5.000" max="3000.000" placeholder="1000.000" name="xrpkwd[kwd]" data-pair="xrpkwd" data-type="fiat" />
                        <span class="input-group-addon" >KWD</span>
                    </div>
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="1.0000000" name="xrpkwd[xrp]" data-pair="xrpkwd" readonly data-type="crypto"/>
                        <span class="input-group-addon" style="padding-right: 16px;padding-left: 15px;">XRP</span>
                    </div>
                </div>
            </div>
            <p><button type="submit" class="btn btn-default btn-primary" role="button">Buy now &raquo;</button></p>
        </form>
    </div><!-- /.col-lg-4 -->

</div><!-- /.row -->
<div class="knet-image"></div>
@endsection


@section('additional-script')
    <script src="{{ asset('js/homepage.js') }}"></script>
@endsection
