@extends('layouts.app')

@section('header')
<style>
    .navbar-wrapper {
        position:static;
    }
    .form-group{
        margin-bottom: 15px;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/material.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dataTables.material.min.css') }}">
@endsection


@section('no-container-content')
    <div class="container" style="margin-top: 20px">
        <h1>Order History</h1>
        <div class="" style="display: flex;">
            <br>
            <div class="col-md-12">
                <table id="order_history" class="mdl-data-table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date and Time</th>
                        <th>Amount</th>
                        <th>Value</th>
                        <th>Rate</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="device-xs visible-xs"></div>
    <div class="device-sm visible-sm"></div>
    <div class="device-md visible-md"></div>
    <div class="device-lg visible-lg"></div>
@endsection

@section('additional-script')
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.material.min.js') }}"></script>
    <script>
        function isBreakpoint( alias ) {
            return $('.device-' + alias).is(':visible');
        }
        $(document).ready(function($) { //noconflict wrapper
            var heights = $(".same-height").map(function() {
            return $(this).height();
            }).get(),
            maxHeight = Math.max.apply(null, heights);
            if( !isBreakpoint('xs') ) {
                $(".same-height").height(maxHeight);
            }

            $('#order_history').DataTable( {
                columnDefs: [
                    {
                        targets: [ 0, 1, 2 ],
                        className: 'mdl-data-table__cell--non-numeric'
                    }
                ],
                "ajax": "{{ route('orders.index.data') }}",
            } );
        });
    </script>
@endsection