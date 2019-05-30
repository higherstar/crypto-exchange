<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>{{ config('app.name', 'YallaBit') }}</title>

    <meta name="description" content="Buy & Sell Cryptocurrencies in Kuwait using KNET. Bitcoin, Ethereum, Litecoin, Ripple & Bitcoin Cash are available!"/>
    <meta name="author" content="YallaBit"/>
    <meta property="og:title" content="YallaBit" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.yallabit.com/" />
    <meta property="og:image" content="{{ asset('images/logo/blue.jpg') }}" />
    <meta property="og:description" content="Buy & Sell Cryptocurrencies in Kuwait using KNET. Bitcoin, Ethereum, Litecoin, Ripple & Bitcoin Cash are available!"/>



    <link rel="shortcut icon" href="{{ asset('images/yallabit-favicon.ico') }}">

    <link href="{{ asset('css/coming_soon.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Global site tag (gtag.js) - Google AdWords: 828225248 -->
    @if(App::environment("production"))
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-828225248"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'AW-828225248');
        </script>
        @include('js.zendesk')
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
        <h1>Buy & Sell Cryptocurrencies in Kuwait</h1>
    </div>
    <div class="" style="color: #B2FF59; margin-top: 20px;text-align: center">
        <h2>We are currently selling Cryptocurrency via Live Chat!</h2>
        <h3 style="display:none; color:#FF9494" id="status">We are currently offline, please leave your buy/sell order via the support button and we will get back to you within 24 hours.</h3>
    </div>
    <div class="counter spacecounter">
        <div class="container">
            <ul class="countdown_2">
                <li>
                    <span class="days">30</span>
                    <p class="days_ref">days</p>
                </li>
                <li>
                    <span class="hours">00</span>
                    <p class="hours_ref">hours</p>
                </li>
                <li>
                    <span class="minutes">00</span>
                    <p class="minutes_ref">minutes</p>
                </li>
                <li>
                    <span class="seconds last">00</span>
                    <p class="seconds_ref">seconds</p>
                </li>
            </ul>
            <div class="spacenotify mid" style="color: #eee">
                <div style="margin: 10px 0 20px 0">
                    {{--<p>We're launching soon. Giving the people access to the Crypto ecosystem. Subscribe to get notified of the launch!</p>--}}
                    <h2>Going live soon. Subscribe to get notified of the launch.</h2>
                </div>
                <div class="field">
                    <div id="result"></div>
                    <div class="form">
                        <!-- Begin MailChimp Signup Form -->
                        <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
                        <style type="text/css">
                            #mc_embed_signup{clear:left; font:14px Helvetica,Arial,sans-serif; }
                            /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
                               We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
                            #mce-responses{
                                display:inline-block;
                                margin-top: 10px;
                            }
                            #mce-responses a{
                                color: #3DA0DB;
                            }
                            .mce_inline_error{
                                color: #ff6b6b;
                                margin-top: 10px;
                            }
                        </style>
                        <div id="mc_embed_signup form">
                            <form action="https://yallabit.us17.list-manage.com/subscribe/post?u=05c8a95c3a2b6518857ed8a5c&amp;id=14691fdc1f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                <div id="mc_embed_signup_scroll">
                                    <div class="mc-field-group">
                                        <div class="field">
                                            <input type="email" placeholder="E-mail Address" class="" required="" name="EMAIL" id="mce-EMAIL">
                                            <input type="submit" name="subscribe" value="NOTIFY ME">
                                        </div>
                                    </div>
                                    <div id="mce-responses" class="clear">
                                        <div class="response" id="mce-error-response" style="display:none"></div>
                                        <div class="response" id="mce-success-response" style="display:none"></div>
                                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_05c8a95c3a2b6518857ed8a5c_14691fdc1f" tabindex="-1" value=""></div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        </div>

                        <!--End mc_embed_signup-->
                    </div>
                </div>
                <center>
                    <h2 style="margin: 30px 0;">Available Cryptocurrencies</h2>
                    <style>
                        .inline-list li{
                            display: inline-block;
                        }
                    </style>
                    <div class="inline-list">
                        <ul>
                            <li>

                                <img class="img-circle" src="{{ asset('images/bitcoin-icon.png') }}" alt="Generic placeholder image" width="140" height="140">
                                <div>Bitcoin (BTC)</div>
                            </li>
                            <li>

                                <img class="img-circle" src="{{ asset('images/ethereum-icon.png') }}" alt="Generic placeholder image" width="140" height="140">
                                <div>Ethereum (ETH)</div>
                            </li>
                            <li>

                                <img class="img-circle" src="{{ asset('images/litecoin-icon.png') }}" alt="Generic placeholder image" width="140" height="140">
                                <div>Litecoin (LTC)</div>
                            </li>
                            <li>

                                <img class="img-circle" src="{{ asset('images/ripple-icon.png') }}" alt="Generic placeholder image" width="140" height="140">
                                <div>Ripple (XRP)</div>
                            </li>
                            <li>

                                <img style="padding: 25px 0px;" src="{{ asset('images/bitcoincash-white-no-text.png') }}" alt="Generic placeholder image" width="140" >
                                <div>Bitcoin Cash (BCH)</div>
                            </li>
                        </ul>
                    </div>
                </center>
            </div>
        </div>
        <div class="clear"></div>
        <div class="spacesocial">
            <ul>
                <li><a href="https://www.facebook.com/yallabit" class="fa fb"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://www.twitter.com/yallabit" class="fa tw"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/yallabit" class="fa in"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
</div>

<!-- end counter -->
<div class="clear"></div>

<!-- start footer -->

<div class="spacefooter">
    <div class="container">
        <p>Copyrights © 2017 YallaBit - All Rights Reserved.</p>
    </div>
    {{--<div class="knet-image"></div>--}}
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

<script type="text/javascript" src="{{ asset('js/coming_soon/jparticle.jquery.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset('js/coming_soon/functions.js') }}"></script>--}}
<script>
    $(function(){
        $("body.space").jParticle({
            color: "#fff"
        });
    });
</script>

<script type='text/javascript' src='https://s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<script>
    $('#mce-success-response').bind("DOMSubtreeModified",function(){
        window.location.replace("mc/launch/subscribed");
    });
</script>

@if(App::environment("production"))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110539959-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-110539959-1');
    </script>
    <script>
        $zopim(function() {
            $zopim.livechat.setOnStatus(callback);
            function callback(status) {
                if (status == 'online') {
                    $("status").hide();
                }
                else{
                    $("#status").show();
                }
            }
        });
    </script>
@endif
</body>
</html>