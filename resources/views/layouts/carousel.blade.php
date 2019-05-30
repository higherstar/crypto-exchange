<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="YallaBit, gives you the ability to buy Cryptocurrencies in Kuwait using KNET. Bitcoins, etheruems, litecoins and ripple is Available now!">
  <meta name="author" content="YallaBit.com">
  <link rel="icon" href="../../favicon.ico">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'YallaBit') }}</title>

  {{--<!-- Bootstrap core CSS -->--}}
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  {{--<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->--}}
  <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

  {{--<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->--}}
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  {{--<!-- Custom styles for this template -->--}}
  <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
  <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      /* display: none; <- Crashes Chrome on hover */
      -webkit-appearance: none;
      margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
  </style>
</head>
{{--<!-- NAVBAR--}}
{{--================================================== -->--}}
<body>
<div class="navbar-wrapper">
  <div class="container">
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">{{ config('app.name', 'YallaBit') }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            {{--<li class="dropdown">--}}
              {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>--}}
              {{--<ul class="dropdown-menu">--}}
                {{--<li><a href="#">Action</a></li>--}}
                {{--<li><a href="#">Another action</a></li>--}}
                {{--<li><a href="#">Something else here</a></li>--}}
                {{--<li role="separator" class="divider"></li>--}}
                {{--<li class="dropdown-header">Nav header</li>--}}
                {{--<li><a href="#">Separated link</a></li>--}}
                {{--<li><a href="#">One more separated link</a></li>--}}
              {{--</ul>--}}
            {{--</li>--}}
          </ul>
        </div>
      </div>
    </nav>

  </div>
</div>


<!-- Carousel
================================================== -->
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


<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container marketing">

  <!-- Three columns of text below the carousel -->
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
              <input class="form-control" type="number" step='0.001' min="5.000" max="5000.000" placeholder="1000.000" value="100.000" name="btckwd[kwd]" data-pair="btckwd" data-type="fiat"/>
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
              <input class="form-control" type="number" step='0.001' value="100.000" min="5.000" max="5000.000" placeholder="1000.000" name="ltckwd[kwd]" data-pair="ltckwd" data-type="fiat" />
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
        <input type="hidden" name="trading_pair" value="ltckwd"/>
        <input type="hidden" id='ltckwd-fiat_based' name="fiat_based" value='1'/>
        <div class="form-group input-calculators">
          <p>Buy XRP for Kuwaiti Dinars.</p>
          <div class="input-group full-size">
            <span class="input-group-addon swap-button" style="cursor:auto" data-pair="xrpkwd"><img src="{{ asset('images/flip-128.png') }}" width="16px" height="16px"></span>
            <div class="input-group">
              <input class="form-control" type="number" value="100.000" step='0.001' min="5.000" max="5000.000" placeholder="1000.000" name="xrpkwd[kwd]" data-pair="xrpkwd" data-type="fiat" />
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
  <!-- FOOTER -->
  <footer style="margin-top: 30px; text-align:center">
    <p>&copy; 2017 YallaBit &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>

</div><!-- /.container -->

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>
<script src="{{ asset('js/homepage.js') }}"></script>
</body>
</html>
