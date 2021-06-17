@extends('vendor.vendor_layout.main')
@section('title', 'Product')
@section('page_title', 'Edit Product')
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
                <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
            </div>
            <div class="card-body">
                <form method="POST" id="submitForm" action="{{ route('vendor.product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label> <span  style="color:red" id="cat_err"> </span>
                            <select class="form-control js-example" name="category" id="category">
                                <option value="">Select Category</option>
                                @foreach($categories as $c)
                                <option value="{{ $c->id }}" @if($c->id == $product->category_id) Selected @endif>{{ $c->cat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sub_category">Sub-Category </label> <span  style="color:red" id="sub_err"> </span>
                            <select class="form-control js-example" name="sub_category" id="sub_category">
                               @foreach($subCategory as $s)
                                <option value="{{ $s->id }}" @if($s->id == $product->sub_category_id) Selected @endif>{{ $s->sub_category }}</option>
                               @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_name">Product Name</label> <span  style="color:red" id="name_err"> </span>
                            <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Enter Product Name" value="{{ $product->product_name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Product Image</label> <span  style="color:red" id="img_err"> </span>
                            <div class="custom-file">
                            <input type="file" name="product_img" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <input type="hidden" name="hidden_image" value="{{$product->product_img}}">
                        <a href="{{  URL::asset('ProductImg/' . $product->product_img) }}" target="_blank" class="mt-3"> Click to view</a>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selling_price">Selling Price</label> <span  style="color:red" id="sell_err"> </span>
                            <input type="number" name="selling_price" class="form-control" id="selling_price" placeholder="Enter Selling Price" value="{{ $product->selling_price }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost_price">Cost Price</label> <span  style="color:red" id="cost_err"> </span>
                            <input type="number" name="cost_price" class="form-control" id="cost_price" placeholder="Enter Cost Price" value="{{ $product->cost_price }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busi_location">Product Description</label> <span  style="color:red" id="description_err"> </span>
                            <textarea name="description" class="form-control" id="description" placeholder="Description">{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busi_address">Status</label> <span  style="color:red" id="status_err"> </span>
                            <select class="form-control js-example" name="status" id="status">
                                <option value="">Select Status</option>
                                <option value="In-Stock" @if($product->status == "In-Stock") Selected @endif>In-Stock</option>
                                <option value="Out of Stock" @if($product->status == "Out of Stock") Selected @endif>Out of Stock</option>
                            </select>
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
    var sub_category = $("#sub_category").val();
    var category = $("#category").val();
    var product_img = $("#customFile").val();
    var selling_price = $("#selling_price").val();
    var cost_price = $("#cost_price").val();
    var description = $("#description").val();
    var status = $("#status").val();
    // alert(service);
    if (category=="") {
        $("#cat_err").fadeIn().html("Required");
        setTimeout(function(){ $("#cat_err").fadeOut(); }, 3000);
        $("#category").focus();
        return false;
    }
    if (sub_category=="") {
        $("#sub_err").fadeIn().html("Required");
        setTimeout(function(){ $("#sub_err").fadeOut(); }, 3000);
        $("#sub_category").focus();
        return false;
    }
    if (product_name=="") {
        $("#name_err").fadeIn().html("Required");
        setTimeout(function(){ $("#name_err").fadeOut(); }, 3000);
        $("#product_name").focus();
        return false;
    }
    if (selling_price=="") {
        $("#sell_err").fadeIn().html("Required");
        setTimeout(function(){ $("#sell_err").fadeOut(); }, 3000);
        $("#selling_price").focus();
        return false;
    }
    if (cost_price=="") {
        $("#cost_err").fadeIn().html("Required");
        setTimeout(function(){ $("#cost_err").fadeOut(); }, 3000);
        $("#cost_price").focus();
        return false;
    }
    if (description=="") {
        $("#description_err").fadeIn().html("Required");
        setTimeout(function(){ $("#description_err").fadeOut(); }, 3000);
        $("#description").focus();
        return false;
    }
    if (status=="") {
        $("#status_err").fadeIn().html("Required");
        setTimeout(function(){ $("#status_err").fadeOut(); }, 3000);
        $("#status").focus();
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