@extends('admin.admin_layout.main')
@section('title', 'Vendor')
@section('page_title', 'Vendor Profile')
@section('customcss')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
		<div class="alert alert-success alert-block mt-3">
			<button type="button" class="close" data-dismiss="alert">×</button>	
				<strong><i class="fa fa-check text-white">&nbsp;</i>{{ $message }}</strong>
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
    <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <!-- <h6 class="m-0 font-weight-bold text-primary">Simple Tables</h6> -->
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <tr>
                        <th class="thead-light" width="40%">Business Owner Name</th>
                        <td>{{ $vendor->business_owner_name }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Name</th>
                        <td>{{ $vendor->business_name }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Type</th>
                        <td>{{ $vendor->business_type }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Start Date</th>
                        <td>{{ $vendor->business_start_date }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Location</th>
                        <td>{{ $vendor->location }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Address</th>
                        <td>{{ $vendor->address }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">GST No.</th>
                        <td>{{ $vendor->gst_no }}</td>
                    </tr>
                    @if($vendor->aadhar_img)
                    <tr>
                        <th class="thead-light" width="40%">Aadhar Image</th>
                        <td>
                            <img src="{{  URL::asset('AadharImg/' . $vendor->aadhar_img) }}" width="25%">
                        </td>
                    </tr>
                    @endif
                    @if($vendor->pan_img)
                    <tr>
                        <th class="thead-light" width="40%">Pan Image</th>
                        <td>
                            <img src="{{  URL::asset('PanImg/' . $vendor->pan_img) }}" width="25%">
                        </td>
                    </tr>
                    @endif
                    @if($vendor->shop_img)
                    <tr>
                        <th class="thead-light" width="40%">Business Shop Image</th>
                        <td>
                            <img src="{{  URL::asset('ShopImg/' . $vendor->shop_img) }}" width="25%">
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
<!--Row-->

@endsection
@section('customjs')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
var SITEURL = '{{ route('admin.vendors.index')}}';
$('#dataTableHover').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    },
    columns: [
            { data: 'business_owner_name', name: 'business_owner_name' },
            { data: 'business_name', name: 'business_name' },
            { data: 'business_type', name: 'business_type' },
            { data: 'username', name: 'username' },
            { data: 'show_pwd', name: 'show_pwd' },
            {data: 'action', name: 'action', orderable: false},
        ],
    order: [[0, 'desc']]
});

$('body').on('click', '#delete', function () {
    var id = $(this).data("id");

    if(confirm("Are You sure want to delete !")){
        $.ajax({
            type: "delete",
            url: "{{ url('admin/vendors') }}"+'/'+id,
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

</script>
@endsection