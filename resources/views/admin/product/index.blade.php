@extends('admin.admin_layout.main')
@section('title', 'Product')
@section('page_title', 'Product List')
@section('customcss')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://use.fontawesome.com/d5c7b56460.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<style>
td.details-control:before {
    font-family: 'FontAwesome';
    content: '\f105';
    display: block;
    text-align: center;
    font-size: 20px;
}
tr.shown td.details-control:before{
   font-family: 'FontAwesome';
    content: '\f107';
    display: block;
    text-align: center;
    font-size: 20px;
}

.select2-container .select2-selection--single{
    height:42px;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
		<div class="alert alert-success alert-block mt-3">
			<button type="button" class="close" data-dismiss="alert">×</button>	
				<strong>{{ $message }}</strong>
		</div>
		@endif
		@if ($message = Session::get('danger'))
		<div class="alert alert-danger alert-block mt-3">
			<button type="button" class="close" data-dismiss="alert">×</button>	
				<strong>{{ $message }}</strong>
		</div>
		@endif
    </div>
</div>
<div class="row mb-3">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 ">
                <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control js-example" name="vendor" id="vendor">
                                <option value="">Pick a Vendor</option>
                                @foreach($vendors as $v)
                                <option value="{{ $v->id }}">{{ $v->business_owner_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control js-example" name="category" id="category">
                                <option value="">Pick a Category</option>
                                @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->cat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control js-example" name="status" id="status">
                                <option value="">All</option>
                                <option value="In-Stock">In-Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="getList" class="btn btn-primary">Get List</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Vendor Name</th>
                            <th>Selling Price</th>
                            <th>Cost Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Vendor Name</th>
                            <th>Selling Price</th>
                            <th>Cost Price</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Row-->

@endsection
@section('customjs')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.js-example').select2();

});
var SITEURL = '{{ route('admin.products.index')}}';
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width:100%">'+
        '<tr>'+
            '<td style="text-align:center">Category</td>'+
            '<td style="text-align:center">'+d.category_id+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td style="text-align:center">Sub-Category</td>'+
            '<td style="text-align:center">'+d.sub_category_id+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td style="text-align:center">Description</td>'+
            '<td style="text-align:center">'+d.description+'</td>'+
        '</tr>'+
    '</table>';
}
$(document).ready(function() {
    fetch_data(vendor = '', status = '', category = '');
    function fetch_data(vendor = '', service = '', category = ''){
        var table =$('#dataTableHover').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url: SITEURL,
            type: 'GET',
            data: {vendor:vendor, status:status, category:category}
            },
        columns: [
                { 
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { data: 'product_img', name: 'product_img' },
                { data: 'product_name', name: 'product_name' },
                { data: 'vendor_id', name: 'vendor_id' },
                { data: 'selling_price', name: 'selling_price' },
                { data: 'cost_price', name: 'cost_price' },
                { data: 'status', name: 'status' },
            ],
        order: [[0, 'desc']]
        })
        $('#dataTableHover tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        });
    }
    $('#getList').click(function () {
        var vendor = $("#vendor").val();
        var status = $("#status").val(); 
        var category = $("#category").val();  
        $("#dataTableHover").DataTable().destroy();
        fetch_data(vendor, status, category);
    });
});

$('#service').change(function(){
  var serviceID = $(this).val();  
    //   alert(serviceID);
  if(serviceID){
    $.ajax({
      type:"GET",
      url:"{{url('/admin/get-category-list')}}?service_id="+serviceID,
      success:function(res){        
      if(res){
        $("#category").empty();
        $("#category").append('<option value="">Select Category</option>');
        $.each(res,function(key,value){
          $("#category").append('<option value="'+key+'">'+value+'</option>');
        });
      
      }else{
        $("#category").empty();
      }
      }
    });
  }else{
    $("#category").empty();
  }   
});
</script>
@endsection