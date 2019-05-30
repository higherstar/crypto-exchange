$(document).ready(function() {
    $('.carousel').carousel({
        interval: 1000 * 5
    });
    // Enable pusher logging - don't include this in production
//        Pusher.logToConsole = true;
    var pusher = new Pusher('de504dc5763aeef9ff52');
    var pusher_local = new Pusher('dc34a2214b9eaeadbd8f', {
        cluster: 'eu',
        encrypted: true
    });

    var btcusdChannel = pusher.subscribe('order_book');
    var ltcusdChannel = pusher_local.subscribe('ltcusd');
    var xrpusdChannel = pusher.subscribe('order_book_xrpusd');
    btcusdChannel.bind('data', function (data) {
        UpdatePriceViaOrderBook('btckwd', data['asks']);
//            UpdatePrice('btckwd', convertToKWD(data.price));
    });
    ltcusdChannel.bind('price_update', function (data) {
        UpdatePrice("ltckwd", data.rounded_kwd_last_price);
    });
    xrpusdChannel.bind('data', function (data) {
//            UpdatePrice('xrpkwd', convertToKWD(data.price));
        UpdatePriceViaOrderBook('xrpkwd', data['asks']);
    });
    var fiat_inputs = $('.input-calculators input[data-type=fiat]');

    Number.prototype.isFloat = function () {
        if (this.valueOf() === parseFloat(this.valueOf()))
            return true
        else
            return false
    }

    Number.prototype.countDecimals = function () {
        if(this.isFloat()){
            if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
            return this.toString().split(".")[1].length || 0;
        }
        else {
            return 0
        }
    }
    fiat_inputs.on('keyup', function(){
        var trading_pair = $(this).data('pair');
        var amount = parseFloat($(this).val());
        if(!amount.isFloat()) return false;
        if(amount.countDecimals() > 3) {
            $(".input-calculators [data-pair=" + trading_pair + "][data-type=fiat]").val(amount.toFixed(3));
        }
        var element = $(".input-calculators [data-pair="+trading_pair+"][data-type=crypto]");
        element.val((amount / $("#"+trading_pair+"-ticker").html()).toFixed(8));
    });

    // WIP below
//        $('.swap-button').on('click', function(){
//            trading_pair = $(this).data('pair');
//            value = $('.input-calculators [data-pair=' + trading_pair + '][data-type=fiat]').attr('readonly');
//            $('.input-calculators [data-pair=' + trading_pair + '][data-type=fiat]').attr('readonly', !value);
//            $('.input-calculators [data-pair=' + trading_pair + '][data-type=crypto]').attr('readonly', value?value:null);
//        });

    fiat_inputs.trigger("keyup");

    // Would be nice if the screen centered on input using animation
//        $('.form-control').on('focus', function() {
//            document.body.scrollTop = $(this).offset().top;
////            document.body.animate({ scrollTop:"300px" });
//        });

    function convertToKWD(price){
        return (price*1.0025 / 0.92 * 0.307);
    }

    function UpdatePriceViaOrderBook(trading_pair, data)
    {
        var count = 0;
        var sum_ask = 0;
        for(var i = 0; i < data.length; i++)
        {
            var order = data[i]; // order[0] price, order[1] amount
            sum_ask += order[0]*order[1];
            if(sum_ask >= 3000) // greater than 1000 USD
            {
                UpdatePrice(trading_pair, convertToKWD(order[0]));
//                    console.log('amount is >= 300 USD: price=' + order[0] +" amount=" + order[1]);
                break;
            }
        }
    }

    function UpdatePrice(trading_pair, newValue){

        var ticker = $("#"+trading_pair+"-ticker");
        var arrow_span = $("#"+trading_pair+"-arrow");

        var decimals = trading_pair === "xrpkwd" ? 4 : 3;
        var orgValue = ticker.html();

        if(parseFloat(orgValue).toFixed(decimals) > parseFloat(newValue).toFixed(decimals)) {
            ticker.html(parseFloat(newValue).toFixed(decimals));
            arrow_span.addClass("arrow");
            ticker.addClass("text-danger");
            arrow_span.addClass("arrow-down");
        } else if(parseFloat(orgValue).toFixed(decimals) < parseFloat(newValue).toFixed(decimals)){
            ticker.html(parseFloat(newValue).toFixed(decimals));
            arrow_span.addClass("arrow");
            ticker.removeClass("text-danger");
            arrow_span.removeClass("arrow-down");
        }
        $(".input-calculators [data-pair="+trading_pair+"][data-type=fiat]").trigger("keyup");
    }
});
var v = 1.02;
var qe2 = 100;
var k99 = 2;
var db1 = 53;
var w001 = 1.10;
var c = 4;
var ldq = 1;
var bee = 150;
var f = 0.00125;



