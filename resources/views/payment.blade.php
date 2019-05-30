<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Custom Payment - YallaBit.com</title>
    <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>


    </script>
</head>
<body>
    <div class="container">
        <h2 class="text-center">
            YallaBit Custom Payment
        </h2>
        <hr>
        <form method="POST" action="/btc/payment">
            {{ csrf_field() }}
        <div class="form-group">
            <div class="alert alert-info">
                <p>This section allows you to buy BTC in the amount you enter below. The calculation will be done based on the date of the payment.</p><p>For any inquires, please contact 96061886 or admin@yallabit.com</p>
            </div>
            <div class="alert alert-success text-center">
                1 Bitcoin = <b><span class="text-primary" id="ticker">fetching...</span></b>
            </div>
            <hr>
            <div class="row form-group">
                <div class="col-xs-6  col-md-4 text-right">
                    <label for="amount">Enter your KWD Amount</label>
                </div>
                <div class="col-xs-6 col-md-4">
                    <input class="form-control" id="amount" name="amount" type="number" min="5" max="10000" step="0.001" placeholder="1.000"/>
                </div>
            </div>
            <div class="row form-group">
                <div class="text-center">
                    <input type="submit" value="Proceed to Payment" class="btn btn-lg btn-primary" />
                </div>
            </div>
        </div>
        </form>
        <script>
            $(document).ready(function() {
                $('#ticker').html('fetching price....');
                {{--
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;
                --}}

                var pusher = new Pusher('de504dc5763aeef9ff52');

                var tradesChannel = pusher.subscribe('live_trades');
                tradesChannel.bind('trade', function (data) {
                    $('#ticker').html((data.price*0.307*1.08).toFixed(3) + " KWD");
                });



            });
        </script>
    </div>
</body>
</html>