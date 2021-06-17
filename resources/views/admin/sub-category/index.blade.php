@extends('admin.admin_layout.main')
@section('title', 'Sub-Category')
@section('page_title', 'Sub-Category')
@section('customcss')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<style>
.hidden{
    display:none;
}
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
                <h6 class="m-0 font-weight-bold text-primary">Add Sub-Category</h6>
            </div>
            <div class="card-body">
                <form method="POST" id="submitForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category">Category</label> <span  style="color:red" id="cat_err"> </span>
                                <select class="form-control js-example" name="category" id="category">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sub_category">Sub-Category</label> <span  style="color:red" id="sub_cat_err"> </span>
                                <input type="text" name="sub_category" id="sub_category" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label> <span  style="color:red" id="status_err"> </span>
                                <select name="status" class="form-control" id="status">
                                    <option value="">-Select Status-</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Row-->
<div class="row mb-3">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
            </div>
            <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Category</th>
                            <th>Sub-Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Category</th>
                            <th>Sub-Category</th>
                            <th>Status</th>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sub-Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" >
                <div class="modal-body">
                    <div class="form-group">
                        <label for="e_category">Category</label> <span  style="color:red" id="e_cat_err"> </span>
                        <select class="form-control js-example" name="category" id="e_category">
                            <option value="">Select Category</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->cat_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="e_sub_category">Sub-Category</label> <span  style="color:red" id="e_sub_cat_err"> </span>
                        <input type="text" name="sub_category" id="e_sub_category" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label> <span  style="color:red" id="e_status_err"> </span>
                        <select name="status" class="form-control" id="edit_status">
                            <option value="">-Select Status-</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id" value="">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editService" onclick="return checkSubmit()">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    $('.js-example').select2();

});
var SITEURL = '{{ route('admin.sub-category.index')}}';
$('#dataTableHover').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    },
    columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'category_id', name: 'category_id' },
            { data: 'sub_category', name: 'sub_category' },
            { data: 'status', name: 'status' },
            {data: 'action', name: 'action', orderable: false},
        ],
    order: [[0, 'desc']]
});

$('body').on('click', '#submitButton', function () {
    var category = $("#category").val();
    var sub_category = $("#sub_category").val();
    var status = $("#status").val();
    // alert(is_parent);
    if (category=="") {
        $("#cat_err").fadeIn().html("Required");
        setTimeout(function(){ $("#cat_err").fadeOut(); }, 3000);
        $("#category").focus();
        return false;
    }
    if (sub_category=="") {
        $("#sub_cat_err").fadeIn().html("Required");
        setTimeout(function(){ $("#sub_cat_err").fadeOut(); }, 3000);
        $("#sub_category").focus();
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
        var datastring="status="+status+"&category="+category+"&sub_category="+sub_category;
        // alert(datastring);
        $.ajax({
            type:"POST",
            url:"{{ route('admin.sub-category.store') }}",
            data:datastring,
            cache:false,        
            success:function(returndata)
            {
                document.getElementById("submitForm").reset();
                var oTable = $('#dataTableHover').dataTable(); 
                oTable.fnDraw(false);
                toastr.success(returndata.success);
            
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
})
function EditModel(obj,bid)
{
    var datastring="bid="+bid;
    // alert(datastring);
    $.ajax({
        type:"POST",
        url:"{{ route('admin.get.sub-category') }}",
        data:datastring,
        cache:false,        
        success:function(returndata)
        {
            // alert(returndata);
        if (returndata!="0") {
            $("#exampleModal").modal('show');
            var json = JSON.parse(returndata);
            $("#id").val(json.id);
            $("#e_category").val(json.category_id);
            $("#e_sub_category").val(json.sub_category);
            $("#edit_status").val(json.status);
        }
        }
    });
}

function checkSubmit()
{
    var id = $("#id").val();
    var category = $("#e_category").val();
    var sub_category = $("#e_sub_category").val();
    var status = $("#edit_status").val();
    if (category=="") {
        $("#e_cat_err").fadeIn().html("Required");
        setTimeout(function(){ $("#e_cat_err").fadeOut(); }, 3000);
        $("#e_category").focus();
        return false;
    }
    if (sub_category=="") {
        $("#e_sub_cat_err").fadeIn().html("Required");
        setTimeout(function(){ $("#e_sub_cat_err").fadeOut(); }, 3000);
        $("#e_sub_category").focus();
        return false;
    }
    if (status=="") {
        $("#e_status_err").fadeIn().html("Required");
        setTimeout(function(){ $("#e_status_err").fadeOut(); }, 3000);
        $("#edit_status").focus();
        return false;
    }
    else
    { 
        $('#editService').attr('disabled',true);
        var datastring="status="+status+"&id="+id+"&category="+category+"&sub_category="+sub_category;
        // alert(datastring);
        $.ajax({
            type:"POST",
            url:"{{ url('/admin/sub-category/update') }}",
            data:datastring,
            cache:false,        
            success:function(returndata)
            {
            $('#editService').attr('disabled',false);
            $("#exampleModal").modal('hide');
            var oTable = $('#dataTableHover').dataTable(); 
            oTable.fnDraw(false);
            toastr.success(returndata.success);
            
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
}

$('body').on('click', '#delete', function () {
    var id = $(this).data("id");

    if(confirm("Are You sure want to delete !")){
        $.ajax({
            type: "delete",
            url: "{{ url('admin/sub-category') }}"+'/'+id,
            success: function (data) {
            var oTable = $('#dataTableHover').dataTable(); 
            oTable.fnDraw(false);
            toastr.success(data.success);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
});

$(function() {
  
  $(document).on('click', '#customControlAutosizing', function() {
  
    if ($(this).val() == 1) {
        $("#showDiv").show();
        $(this).val(0);
    } 
    else {
        $("#showDiv").hide();
        $(this).val(1);
    }
  });
  
});
$(function() {
  
  $(document).on('click', '#is_parent', function() {
  
    if ($(this).val() == 1) {
        $("#showDiv1").show();
        $(this).val(0);
    } 
    else {
        $("#showDiv1").hide();
        $(this).val(1);
        $("#edit_parent_id").removeAttr("selected");
    }
  });
  
});
</script>
@endsection