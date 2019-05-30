<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>{{ config('app.name', 'YallaBit') }} - Thank you</title>

    <meta name="description" content="Thank you for subscribing to our mailing list!"/>
    <meta name="author" content="YallaBit"/>
    <meta property="og:title" content="YallaBit - Thank you" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.yallabit.com/mc/launch/subscribed" />
    <meta property="og:image" content="{{ asset('images/logo/blue.jpg') }}" />
    <meta property="og:description" content="Thank you for subscribing to our mailing list!"/>



    <link rel="shortcut icon" href="{{ asset('images/yallabit-favicon.ico') }}">

    <link href="{{ asset('css/coming_soon.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@if(App::environment("production"))
    @include('js.zendesk')
    <!-- Global site tag (gtag.js) - Google AdWords: 828225248 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-828225248"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-828225248');
    </script>
    <!-- Event snippet for Mailchimp Launch list subscription conversion page -->
    <script>
        gtag('event', 'conversion', {'send_to': 'AW-828225248/MBTPCP-Sq3oQ4O32igM'});
    </script>
@endif
</head>


<body class="space" >
<div style="background-color: rgba(0,0,0,0.5); position: fixed; width: 100%; height: 100%; top:0; left:0; z-index: -1">
</div>


<!-- started id wrap  -->

<div id="wrap">

    <!--starts logo div -->

    <div class="logo">
        <div class="container"> <a href="#."><img class="logo" src="{{ asset('images/logo/white-transparent.png') }}" alt="Yallabit logo" /></a> </div>
        <div class="clear"></div>
    </div>

    <!--ended logo div -->

    <div class="clear"></div>

    <!-- starts counter -->
    <div class="" style="color: #eee; text-align: center">
        <h1>Thank you for subscribing to our list. We will notify you once we launch!</h1>
        <br><br>
        <div style="width: 50%; left: 25%; position: relative">
            <h1>To join the CryptoMENA Telegram community, join the group at <a href="https://t.me/CRYPTOmena" style="color: white; text-decoration: white underline solid">https://t.me/CRYPTOmena</a>, or scan the QR code below.</h1>
            <br>
            <img width="200px" src="{{ asset('images/qrcodes/QR_Code_CryptoMENA_Telegram.png') }}"/>
        </div>
    </div>
    <div class="clear">
    </div>
</div>

<!-- end counter -->
<div class="clear"></div>

<!-- start footer -->

<div class="spacefooter">
    <div class="container">
        <p>Copyrights © 2017 YallaBit - All Rights Reserved.</p>
    </div>
    <div class="clear"></div>
</div>

<!--end footer -->

</div>

<!-- ended id wrap  -->

<!-- JS File -->

<script type="text/javascript" src="{{ asset('js/coming_soon/jquery.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/coming_soon/jquery.downCount.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.countdown_2').downCount({
            date: '12/31/2017 23:59:59',
            offset: +3
        });
    });
</script>
{{--<script type="text/javascript" src="{{ asset('js/coming_soon/functions.js') }}"></script>--}}


@if(App::environment("production"))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110539959-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-110539959-1');
    </script>

    <!-- Google Code for Mailchimp Launch list subscription Conversion Page -->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 828225248;
        var google_conversion_label = "MBTPCP-Sq3oQ4O32igM";
        var google_remarketing_only = false;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/828225248/?label=MBTPCP-Sq3oQ4O32igM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
@endif


</body>
</html>