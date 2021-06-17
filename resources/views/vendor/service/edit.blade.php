@extends('vendor.vendor_layout.main')
@section('title', 'Service')
@section('page_title', 'Edit Service')
@section('customcss')
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script> -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container .select2-selection--single{
    height:42px;
}
</style>
@endsection
@section('content')
<div class="row mb-3">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit Service</h6>
            </div>
            <div class="card-body">
                <form method="POST" id="submitForm" action="{{ route('vendor.service.update', $service->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label> <span  style="color:red" id="cat_err"> </span>
                            <select class="form-control js-example" name="category" id="category">
                                <option value="">Select Category</option>
                                @foreach($categories as $c)
                                <option value="{{ $c->id }}" @if($c->id == $service->category_id) Selected @endif>{{ $c->cat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sub_category">Sub-Category </label> <span  style="color:red" id="sub_err"> </span>
                            <select class="form-control js-example" name="sub_category" id="sub_category">
                                @foreach($subCategory as $s)
                                <option value="{{ $s->id }}" @if($s->id == $service->sub_category_id) Selected @endif>{{ $s->sub_category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="service_name">Service Name</label> <span  style="color:red" id="name_err"> </span>
                            <input type="text" name="service_name" class="form-control" id="service_name" placeholder="Enter Service Name" value="{{ $service->service_name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Service Image</label> <span  style="color:red" id="img_err"> </span>
                            <div class="custom-file">
                            <input type="file" name="service_img" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <input type="hidden" name="hidden_image" value="{{$service->service_img}}">
                        <a href="{{  URL::asset('ServiceImg/' . $service->service_img) }}" target="_blank" class="mt-3"> Click to view</a>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selling_price">Service Price</label> <span  style="color:red" id="sell_err"> </span>
                            <input type="number" name="service_price" class="form-control" id="service_price" placeholder="Enter Service Price" value="{{ $service->service_cost }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity">Quantity</label> <span  style="color:red" id="quantity_err"> </span>
                            <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Enter Quantity" value="{{ $service->quantity }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busi_location">Service Description</label> <span  style="color:red" id="description_err"> </span>
                            <textarea name="description" class="form-control" id="description" placeholder="Description">{{ $service->description }}</textarea>
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
    $('.js-example').select2();

});

$('body').on('click', '#submitButton', function () {
    var category = $("#category").val();
    var sub_category = $("#sub_category").val();
    var service_name = $("#service_name").val();
    var service_img = $("#customFile").val();
    var service_price = $("#service_price").val();
    // alert(service);
    if (service_name=="") {
        $("#name_err").fadeIn().html("Required");
        setTimeout(function(){ $("#name_err").fadeOut(); }, 3000);
        $("#service_name").focus();
        return false;
    }
    if (service_price=="") {
        $("#sell_err").fadeIn().html("Required");
        setTimeout(function(){ $("#sell_err").fadeOut(); }, 3000);
        $("#service_price").focus();
        return false;
    }
    else
    { 
        $("#submitForm").submit();
    }
})
</script>
<script type=text/javascript>

  $('#category').change(function(){
  var categoryID = $(this).val();  
    //   alert(categoryID);
  if(categoryID){
    $.ajax({
      type:"GET",
      url:"{{url('/vendors/get-sub-category-list')}}?category_id="+categoryID,
      success:function(res){     
        if(res){
        $("#sub_category").empty();
        $("#sub_category").append('<option value="">Select Sub-Category</option>');
        $.each(res,function(key,value){
          $("#sub_category").append('<option value="'+key+'">'+value+'</option>');
        });
      
      }else{
        $("#category").empty();
      }
      }
    });
  } 
  else{
    $("#sub_category").empty();
  }  
  });
</script>
@endsection