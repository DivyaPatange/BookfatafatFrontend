@extends('user.user_layout.main')
@section('title', 'Bookings')
@section('page_title', 'Bookings')
@section('customcss')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 <!-- Bootstrap Core Css -->
 <link href="{{ asset('userAsset/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

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
                                <input type="hidden" name="service_id" id="service_id" value="{{ $service->id }}">
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
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Book Now</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form method="POST" action="{{ route('book-service.store') }}">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <div class="form-line">
                    <label for="">Available Date</label>
                    <input type="date" readonly id="available_date" class="form-control" name="available_date" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                        <thead>
                            <tr>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="serviceDiv"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="available_date_id" id="available_date_id" value="">
            <button type="submit" class="btn bg-red waves-effect" id="book">Book Now</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </form>
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
<!-- Autosize Plugin Js -->
<script src="{{ asset('userAsset/plugins/autosize/autosize.js') }}"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{ asset('userAsset/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<!-- Bootstrap Datepicker Plugin Js -->
<script src="{{ asset('userAsset/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('userAsset/js/pages/forms/basic-form-elements.js') }}"></script>
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
    fetch_data(start_date = '', end_date = '', start_time = '', end_time = '', service_id = '');
    function fetch_data(start_date = '', end_date = '', start_time = '', end_time = '', service_id = ''){
        // alert(start_date);
    var table = $('.js-basic-example').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    data: {start_date:start_date, end_date:end_date, start_time:start_time, end_time:end_time, service_id:service_id}
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
        var service_id = $("#service_id").val();
        // var oTable = $('.dataTable').dataTable(); 
        // oTable.fnDraw(false);
        $(".js-basic-example").DataTable().destroy();
        fetch_data(start_date, end_date, start_time, end_time, service_id);
    });
});

function ServiceModel(obj,bid)
{
  var datastring="bid="+bid;
  $.ajax({
    type:"POST",
    url:"{{ route('get-book-service') }}",
    data:datastring,
    cache:false,        
    success:function(returndata)
    {
        $("#serviceModal").modal('show');
        var json = JSON.parse(returndata);
        $("#available_date").val(json.available_date);
        $("#available_date_id").val(json.available_date_id);
        $("#serviceDiv").html(json.time_slot);
    }
  });
}

$('body').on('click', '#book', function () {
    var available_date = $("#available_date").val();
    var time_slot = $("#serviceDiv input:checkbox:checked").map(function(){
      return $(this).val();
    }).get();
    var available_date_id = $("#available_date_id").val();
    $.ajax({
    type:"POST",
    url:"{{ route('book-service.store') }}",
    data:{available_date:available_date, time_slot:time_slot, available_date_id:available_date_id},
    cache:false,        
    success:function(returndata)
    {
        $("#serviceModal").modal('hide');
        var oTable = $('.js-basic-example').dataTable(); 
        oTable.fnDraw(false);
        toastr.success(returndata.success);
    }
  });
})

$(document).on('click', 'input[type="checkbox"]', function() {      
    $('input[type="checkbox"]').not(this).prop('checked', false);      
});
</script>
@endsection