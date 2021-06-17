@extends('admin.admin_layout.main')
@section('title', 'Vendor')
@section('page_title', 'Edit Vendor')
@section('customcss')
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="row mb-3">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit Vendor</h6>
            </div>
            <div class="card-body">
                <form method="POST" id="submitForm" action="{{ route('admin.vendors.update', $vendor->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="owner_name">Business Owner Name</label> <span  style="color:red" id="owner_err"> </span>
                            <input type="text" name="owner_name" class="form-control" id="owner_name"
                            placeholder="Enter Business Owner Name" value="{{ $vendor->business_owner_name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busi_name">Business Name</label> <span  style="color:red" id="name_err"> </span>
                            <input type="text" name="busi_name" class="form-control" id="busi_name" placeholder="Enter Business Name" value="{{ $vendor->business_name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busi_type">Business Type</label> <span  style="color:red" id="type_err"> </span>
                            <input type="text" name="busi_type" class="form-control" id="busi_type" placeholder="Enter Business Type" value="{{ $vendor->business_type }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busi_start_date">Business Start Date</label> <span  style="color:red" id="date_err"> </span>
                            <input type="month" name="busi_start_date" class="form-control" id="busi_start_date" placeholder="Enter Business Start Date" value="{{ $vendor->business_start_date }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busi_location">Business Location</label> <span  style="color:red" id="location_err"> </span>
                            <input type="text" name="busi_location" class="form-control" id="busi_location" placeholder="Enter Business Location" value="{{ $vendor->location }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busi_address">Business Address</label> <span  style="color:red" id="address_err"> </span>
                            <input type="text" name="busi_address" class="form-control" id="busi_address" placeholder="Enter Business Address" value="{{ $vendor->address }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gst_no">GST No.</label> <span  style="color:red" id="gst_err"> </span>
                            <input type="text" name="gst_no" class="form-control" id="gst_no" placeholder="Enter GST No." value="{{ $vendor->gst_no }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Aadhar Image</label>
                            <div class="custom-file">
                            <input type="file" name="aadhar_img" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <input type="hidden" name="hidden_image" value="{{ $vendor->aadhar_img }}">
                            @if($vendor->aadhar_img)
                            <a href="{{  URL::asset('AadharImg/' . $vendor->aadhar_img) }}">Click to View</a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Pan Image</label>
                            <div class="custom-file">
                            <input type="file" name="pan_img" class="custom-file-input" id="customFile1">
                            <label class="custom-file-label" for="customFile1">Choose file</label>
                            </div>
                            <input type="hidden" name="hidden_image1" value="{{ $vendor->pan_img }}">
                            @if($vendor->pan_img)
                            <a href="{{  URL::asset('PanImg/' . $vendor->pan_img) }}">Click to View</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Business Shop Image</label>
                            <div class="custom-file">
                            <input type="file" name="shop_img" class="custom-file-input" id="customFile2">
                            <label class="custom-file-label" for="customFile2">Choose file</label>
                            </div>
                            <input type="hidden" name="hidden_image2" value="{{ $vendor->shop_img }}">
                            @if($vendor->shop_img)
                            <a href="{{  URL::asset('ShopImg/' . $vendor->shop_img) }}">Click to View</a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <button type="button" id="submitButton" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Row-->

@endsection
@section('customjs')
<script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    // alert(‘1’);
    $('#service').select2();

});
$('body').on('click', '#submitButton', function () {
    var owner_name = $("#owner_name").val();
    var busi_name = $("#busi_name").val();
    var busi_type = $("#busi_type").val();
    var busi_start_date = $("#busi_start_date").val();
    var busi_location = $("#busi_location").val();
    var busi_address = $("#busi_address").val();
    var service = $('#service').val();
    if (owner_name=="") {
        $("#owner_err").fadeIn().html("Required");
        setTimeout(function(){ $("#owner_err").fadeOut(); }, 3000);
        $("#owner_name").focus();
        return false;
    }
    if (busi_name=="") {
        $("#name_err").fadeIn().html("Required");
        setTimeout(function(){ $("#name_err").fadeOut(); }, 3000);
        $("#busi_name").focus();
        return false;
    }
    if (busi_type=="") {
        $("#type_err").fadeIn().html("Required");
        setTimeout(function(){ $("#type_err").fadeOut(); }, 3000);
        $("#busi_type").focus();
        return false;
    }
    if (busi_start_date=="") {
        $("#date_err").fadeIn().html("Required");
        setTimeout(function(){ $("#date_err").fadeOut(); }, 3000);
        $("#busi_start_date").focus();
        return false;
    }
    if (busi_location=="") {
        $("#location_err").fadeIn().html("Required");
        setTimeout(function(){ $("#location_err").fadeOut(); }, 3000);
        $("#busi_location").focus();
        return false;
    }
    if (busi_address=="") {
        $("#address_err").fadeIn().html("Required");
        setTimeout(function(){ $("#address_err").fadeOut(); }, 3000);
        $("#busi_address").focus();
        return false;
    }
    if (service=="") {
        $("#service_err").fadeIn().html("Required");
        setTimeout(function(){ $("#service_err").fadeOut(); }, 3000);
        $("#service").focus();
        return false;
    }
    else
    { 
        $("#submitForm").submit();
    }
})
</script>
@endsection