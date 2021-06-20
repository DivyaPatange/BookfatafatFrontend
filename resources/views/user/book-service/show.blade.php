@extends('user.user_layout.main')
@section('title', 'Bookings')
@section('page_title', 'Bookings')
@section('customcss')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- JQuery DataTable Css -->
<link href="{{ asset('userAsset/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<style>
.error{
    color:red;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                Search for Availability
                </h2>
            </div>
            <div class="body">
                <form method="POST" id="submitForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="daterange" class="form-control" placeholder="Select Date"/>
                                    <input type="hidden" name="start_date" id="start_date" value="">
                                    <input type="hidden" name="end_date" id="end_date" value="">
                                    <input type="hidden" name="start_time" id="start_time" value="">
                                    <input type="hidden" name="end_time" id="end_time" value="">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="button" id="submitButton" class="btn btn-success waves-effect">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Available Dates</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>Available Date</th>
                                <th>Available Time</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Available Date</th>
                                <th>Available Time</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- Jquery DataTable Plugin Js -->
<script src="{{ asset('userAsset/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('userAsset/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('userAsset/js/pages/tables/jquery-datatable.js') }}"></script>
<script>
var SITEURL = "{{ route('search.available-date') }}";
$(function() {
  $('input[name="daterange"]').daterangepicker({
    minDate: new Date(),
    opens: 'left',
    timePicker: true,
    locale: {
      format: 'YYYY-MM-DD hh:mm A'
    }
  }, function(start, end, label) {
      $("#start_date").val(start.format('YYYY-MM-DD'));
      $("#end_date").val(end.format('YYYY-MM-DD'));
      $("#start_time").val(start.format('hh:mm A'));
      $("#end_time").val(end.format('hh:mm A'));
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD hh:mm A') + ' to ' + end.format('YYYY-MM-DD hh:mm A'));
  });
});

$(document).ready(function() {
    fetch_data(start_date = '', end_date = '', start_time = '', end_time = '');
    function fetch_data(start_date = '', end_date = '', start_time = '', end_time = ''){
        // alert(student);
    var table = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    data: {start_date:start_date, end_date:end_date, start_time:start_time, end_time:end_time}
    },
    columns: [
        { data: 'available_date', name: 'available_date' },
        { data: 'available_time', name: 'available_time' },
        { data: 'duration', name: 'duration' },
        { data: 'action', name: 'action' },
    ],
    order: [[0, 'desc']]
    });
    }
    $('#submitButton').click(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val(); 
        var start_time = $("#start_time").val();
        var end_time = $("#end_time").val();
        $("#simpletable").DataTable().destroy();
        fetch_data(start_date, end_date, start_time, end_time);
    });
});
</script>
@endsection