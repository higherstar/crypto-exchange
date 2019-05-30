<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Buy & Sell Cryptocurrencies in Kuwait using KNET. Bitcoins, etheruems, litecoins and ripple are Available now!">
    <meta name="author" content="YallaBit.com">
    <link rel="icon" href="../../favicon.ico">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YallaBit') }}</title>

    {{--<!-- Custom styles for this template -->--}}
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
    {{--<!-- Bootstrap core CSS -->--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fa/font-awesome-core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa/font-awesome-solid.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.css') }}">

    {{--<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->--}}
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">



    {{--<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->--}}
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }
    </style>
    @yield('header')

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
                    <a class="navbar-brand" href="{{route('home')}}">{{ config('app.name', 'YallaBit') }}</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::route()->getName() != "home" ?: "active" }}"><a href="{{route('home')}}">Home</a></li>
                        {{--<li><a href="#about">About</a></li>--}}
                        {{--<li><a href="#contact">Contact</a></li>--}}
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
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            @if(!Auth::user()->verified)
                                <li><a href="{{ route('verifications.index') }}" style="color:#ff6b6b">Verification Required!</a></li>
                            @else
                                <li><a style="color:#8ef9a2">Verified Account</a></li>
                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{route('orders.index')}}">Order History</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

    </div>
</div>

@if(route::currentRouteName() != 'home')
    @if(Session::has('success_message'))
        <div class="container">
            <div class="alert alert-success col-md-8 col-md-offset-2">
                {{ Session::get('success_message') }}
            </div>
        </div>
    @endif

    @if(Session::has('message'))
        <div class="container">
            <div class="alert alert-warning col-md-8 col-md-offset-2">
                {{ Session::get('message') }}
            </div>
        </div>
    @endif
@endif

@yield('no-container-content')

<div class="container marketing">


    @yield('container-content')

    {{--<!-- FOOTER -->--}}
    <footer style="margin-top: 30px; text-align:center">
        <p>&copy; 2017 YallaBit &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>

</div>
{{--<!-- /.container -->--}}

{{--<!-- Scripts -->--}}
<script src="{{ asset('js/app.js') }}"></script>
{{--<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->--}}
<script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>

@yield('additional-script')

</body>
</html>
