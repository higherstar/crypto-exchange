@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/icheck/skins/square/blue.css') }}" rel="stylesheet">
    <style>
        @media (min-width: 768px){
            .form-horizontal .control-label {
                padding-top:1px;
            }
        }
    </style>
@endsection

@section('no-container-content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verification</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('verifications.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="">
                                <div class="col-md-10 col-md-offset-1 text-justify">
                                    <p>To purchase cryptocurrency, your account has to be verified first. We kindly ask you to submit your <b><u>identity documentation</u></b>. The verification process takes <u><b>less than 24 hours</b></u> and you only have to do it one time. For more information, please do not hesitate to contact support.</p>
                                </div>

                            </div>
                            <div class="" style="margin-top: 0">
                                <h4 class="col-md-10 col-md-offset-1">
                                    @if($currentStage === \App\Verification::STAGE_NOT_STARTED)
                                        <span class="text-danger label label-info">Status: Not Started</span>
                                    @elseif($currentStage === \App\Verification::STAGE_REVIEW || $currentStage === \App\Verification::STAGE_EXTENDED_REVIEW)
                                        <span class="text-danger label label-warning">Status: Under Review</span>
                                    @elseif($currentStage === \App\Verification::STAGE_APPROVED)
                                        <span class="text-danger label label-success">Status: Approved</span>
                                    @elseif($currentStage === \App\Verification::STAGE_REJECTED)
                                        <span class="text-danger label label-danger">Status: Rejected</span>
                                    @else
                                        <span class="text-danger label label-info">Status: Unknown</span>
                                    @endif
                                </h4>
                            </div>

                            <div class="form-group text-center">
                                <label for="passport_civil_option" class="col-md-4 control-label">Type of Document?</label>

                                <div class="col-md-6 text-center">
                                    <label style="margin-right: 20px; cursor: pointer">
                                        <input type="radio" name="document_type" value="CIVIL_ID" {{ old('document_type') == \App\Verification::CIVIL_ID ? "checked" : ""}}>
                                        Civil ID
                                    </label>
                                    <label style="cursor: pointer">
                                        <input type="radio" name="document_type" value="PASSPORT" {{ old('document_type') == \App\Verification::PASSPORT ? "checked" : ""}}>
                                        Passport
                                    </label>
                                    <div class="col-md-12">
                                        @if ($errors->has('document_type'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('document_type') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="civil_id_group" hidden>
                                <div class="form-group">
                                    <label for="civil_id_front_file" class="col-md-4 control-label">Civil ID (front)</label>
                                    <div class="col-md-6">
                                        <input type="file" name="civil_id_front_file" class='filestyle' accept="image/*;capture=camera" data-buttonText="Camera Upload" data-iconName="glyphicon glyphicon-camera">
                                        @if ($errors->has('civil_id_front_file'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('civil_id_front_file') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="civil_id_back_file" class="col-md-4 control-label">Civil ID (back)</label>
                                    <div class="col-md-6">
                                        <input type="file" name="civil_id_back_file" class='filestyle' accept="image/*;capture=camera" data-buttonText="Camera Upload" data-iconName="glyphicon glyphicon-camera">
                                        @if ($errors->has('civil_id_back_file'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('civil_id_back_file') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="passport_group" hidden>
                                <div class="form-group">
                                    <label for="passport_file" class="col-md-4 control-label">Passport</label>
                                    <div class="col-md-6">
                                        <input type="file" name="passport_file" class='filestyle' accept="image/*;capture=camera" data-buttonText="Camera Upload" data-iconName="glyphicon glyphicon-camera">
                                        @if ($errors->has('passport_file'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('passport_file') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                                <div id="flip" class="col-md-12" style="display: none">
                                    <label for="mobile_number" class="col-md-4 control-label" >Mobile #</label>

                                    <div class="col-md-4">
                                        <input id="mobile_number" type="number" minlength="8" maxlength="8" class="form-control" name="mobile_number" value="{{ Auth::user()->mobile_number }}" autocomplete="off">
                                    </div>

                                    <div class="col-md-2">
                                        <div class="btn btn-primary" style="min-width: 100%;" id="verify_mobile" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" {{ $mobile_status ? 'disabled':'' }}>
                                            Send Code
                                        </div>

                                    </div>


                                    <div class="col-md-2">
                                        <label id="mobile_status" class="text-{{ $mobile_status ? 'success':'danger' }}">{{ $mobile_status ? 'VERIFIED':'UNVERIFIED' }}</label>
                                    </div>



                                </div>



                                <div id="panel" class="col-md-12" style="margin-top:10px; display: none">
                                    <label class="col-md-4 control-label">Code</label>

                                    <div class="col-md-4">
                                        <input type="number" minlength="4" maxlength="4" class="form-control" id="code" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="btn btn-primary" style="min-width: 100%;" id="verify_code" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>">
                                            Verify
                                        </div>
                                    </div>
                                    <label class="col-md-2 countdown">{{ $time_left }}</label>
                                </div>

                                <div id="mobile_error" style="margin-top: 10px; display: none" class="col-md-12">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6">
                                        <span class="text-danger">
                                        <strong id="mobile_error_text">{{ $errors->first('mobile_number') }}</strong>
                                        </span>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="min-width: 100%;" disabled>
                                        Get Verified!
                                    </button>
                                </div>
                            </div>
                            {{--<div class="col-md-12 text-center">--}}
                                {{--<small><p>All files are encrypted before storage, ensuring the maximum security for our users.</p></small>--}}
                            {{--</div>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-script')
    <script src="{{ asset('js/bootstrap-filestyle.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        function updateForm(value)
        {
            if(value === '{{ \App\Verification::CIVIL_ID }}') {
                $('#civil_id_group').show();
                $('#passport_group').hide();

            }
            else if (value === '{{ \App\Verification::PASSPORT }}') {
                $('#civil_id_group').hide();
                $('#passport_group').show();
            }
            $("#flip").slideDown("fast");
            @if($mobile_verification === true)
                $("#panel").slideDown("fast");
                var timer2 = "{{ $time_left }}";
                var interval = setInterval(function() {
                    if(timer2 != '0:00')
                    {
                        var timer = timer2.split(':');
                        var minutes = parseInt(timer[0], 10);
                        var seconds = parseInt(timer[1], 10);
                        --seconds;
                        minutes = (seconds < 0) ? --minutes : minutes;
                        if (minutes < 0) clearInterval(interval);
                        seconds = (seconds < 0) ? 59 : seconds;
                        seconds = (seconds < 10) ? '0' + seconds : seconds;
                        $('.countdown').html(minutes + ':' + seconds);
                        timer2 = minutes + ':' + seconds;
                    }
                }, 1000);
            @endif
            $(":submit").attr('disabled', $('#mobile_status').hasClass('text-danger'));
        }

        $(document).ready(function() {
            $(":file").filestyle({badge: false});

            let document_type_input = $("[name='document_type']");
            document_type_input.iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            document_type_input.on('ifChecked', function(event) {
                updateForm(this.value);
            });

            @if(old('document_type') != null ? old('document_type') : null )
                updateForm('{{ old('document_type') }}');
            @endif

            $('#mobile_number').on("keydown", function() {
                $('#verify_mobile').attr("disabled", false);
            });

            $('#verify_mobile').unbind().bind("click", function() {
                $('#verify_mobile').button('loading');
                $('#verify_mobile').attr("disabled", true);

                $.ajax({
                    url: "{{ route('verifications.mobile.send') }}",
                    data: { mobile_number: $('#mobile_number').val() },
                    dataType: 'json',
                    type: 'POST',
                    accepts: {
                        text: "application/json"
                    },
                    success: function(response) {
                        $('#mobile_error').hide();
                        $('#verify_mobile').button('reset');
                        setTimeout(function () {
                            $('#verify_mobile').attr("disabled", true);
                        }, 0);

                        $("#panel").slideDown("fast");

                        var timer2 = "{{ $time_left }}";
                        var interval = setInterval(function() {
                            if(timer2 != '0:00')
                            {
                                var timer = timer2.split(':');
                                var minutes = parseInt(timer[0], 10);
                                var seconds = parseInt(timer[1], 10);
                                --seconds;
                                minutes = (seconds < 0) ? --minutes : minutes;
                                if (minutes < 0) clearInterval(interval);
                                seconds = (seconds < 0) ? 59 : seconds;
                                seconds = (seconds < 10) ? '0' + seconds : seconds;
                                $('.countdown').html(minutes + ':' + seconds);
                                timer2 = minutes + ':' + seconds;
                            }
                        }, 1000);
                    },
                    error: function(response){
                        $('#verify_mobile').button('reset');
                        $("#mobile_error_text").html(response.responseJSON.error);
                        $("#mobile_error").slideDown("fast");
                    }
                });
            });

            $('#verify_code').unbind().bind("click", function() {
                $('#verify_code').button('loading');
                $('#verify_code').attr("disabled", true);

                $.ajax({
                    url: "{{ route('verifications.mobile.verify') }}",
                    data: { mobile_number: $('#mobile_number').val(), code: $('#code').val()},
                    dataType: 'json',
                    type: 'PUT',
                    success: function(response) {
                        $('#verify_code').button('reset');
                        setTimeout(function () {
                            $('#verify_code').attr("disabled", true);
                        }, 0);
                        $("#panel").slideUp("fast");
                        $("#mobile_error").slideUp("fast");
                        $('#mobile_status').html('VERIFIED');
                        $('#mobile_status').attr('class', 'text-success');
                        $('#verify_mobile').unbind();
                        $(":submit").attr('disabled', $('#mobile_status').hasClass('text-danger'));
                    },
                    error: function(response) {
                        $('#verify_code').button('reset');
                        $("#mobile_error_text").html(response.responseJSON.error);
                        $("#mobile_error").slideDown("fast");
                    },
                });
            })
        });
    </script>
@endsection