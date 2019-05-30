@extends('layouts.app')

@section('no-container-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-4 control-label"> </div>
                            <h4 class="text-center col-md-6">
                            Already have an account? <a href="{{ route('login')}}">Login</a>
                            </h4>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus autocomplete="off">

                                @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="off">

                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="off">

                                @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                            <label for="mobile_number" class="col-md-4 control-label" >Mobile #</label>

                            <div class="col-md-6">
                                <input placeholder="8 Digits Only (example: 91234567)" id="mobile_number" type="tel" minlength="8" maxlength="8" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}" required autocomplete="off">

                                @if ($errors->has('mobile_number'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('mobile_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label for="password-confirm" class="col-md-4 control-label">Civil ID / Passport Image</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input type="file" class='filestyle' accept="image/*;capture=camera" capture  data-buttonText="Camera Upload" data-iconName="glyphicon glyphicon-camera">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary " style="min-width: 100%; margin-top: 10px; margin-bottom: 10px">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-script')
    <script src="{{ asset('js/bootstrap-filestyle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(":file").filestyle({badge: false});
        });


    </script>
@endsection
