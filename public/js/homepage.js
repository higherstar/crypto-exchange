$(document).ready(function(){function a(a){return 1.0025*a/.92*.307}function t(t,r){for(var o=0,i=0;i<r.length;i++){var s=r[i];if((o+=s[0]*s[1])>=3e3){e(t,a(s[0]));break}}}function e(a,t){var e=$("#"+a+"-ticker"),r=$("#"+a+"-arrow"),o="xrpkwd"===a?4:3,i=e.html();parseFloat(i).toFixed(o)>parseFloat(t).toFixed(o)?(e.html(parseFloat(t).toFixed(o)),r.addClass("arrow"),e.addClass("text-danger"),r.addClass("arrow-down")):parseFloat(i).toFixed(o)<parseFloat(t).toFixed(o)&&(e.html(parseFloat(t).toFixed(o)),r.addClass("arrow"),e.removeClass("text-danger"),r.removeClass("arrow-down")),$(".input-calculators [data-pair="+a+"][data-type=fiat]").trigger("keyup")}$(".carousel").carousel({interval:5e3});var r=new Pusher("de504dc5763aeef9ff52"),o=new Pusher("dc34a2214b9eaeadbd8f",{cluster:"eu",encrypted:!0}),i=r.subscribe("order_book"),s=o.subscribe("ltcusd"),d=r.subscribe("order_book_xrpusd");i.bind("data",function(a){t("btckwd",a.asks)}),s.bind("price_update",function(a){e("ltckwd",a.rounded_kwd_last_price)}),d.bind("data",function(a){t("xrpkwd",a.asks)});var l=$(".input-calculators input[data-type=fiat]");Number.prototype.isFloat=function(){return this.valueOf()===parseFloat(this.valueOf())},Number.prototype.countDecimals=function(){return this.isFloat()?Math.floor(this.valueOf())===this.valueOf()?0:this.toString().split(".")[1].length||0:0},l.on("keyup",function(){var a=$(this).data("pair"),t=parseFloat($(this).val());if(!t.isFloat())return!1;t.countDecimals()>3&&$(".input-calculators [data-pair="+a+"][data-type=fiat]").val(t.toFixed(3)),$(".input-calculators [data-pair="+a+"][data-type=crypto]").val((t/$("#"+a+"-ticker").html()).toFixed(8))}),l.trigger("keyup")});var v=1.02,qe2=100,k99=2,db1=53,w001=1.1,c=4,ldq=1,bee=150,f=.00125;