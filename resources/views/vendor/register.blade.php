<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>RuangVendor - Register</title>
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/ruang-admin.min.css') }}" rel="stylesheet">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-md-12">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>	
                  <strong>{{ $message }}</strong>
                </div>
                @endif
                @if ($message = Session::get('danger'))
                <div class="alert alert-danger alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>	
                  <strong>{{ $message }}</strong>
                </div>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Vendor Registration</h1>
                    </div>
                    <form class="user" id="submitForm" action="{{ route('vendor.register.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="owner_name">Business Owner Name</label> <span  style="color:red" id="owner_err"> </span>
                                    <input type="text" name="owner_name" class="form-control" id="owner_name"
                                    placeholder="Enter Business Owner Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="busi_name">Business Name</label> <span  style="color:red" id="name_err"> </span>
                                    <input type="text" name="busi_name" class="form-control" id="busi_name" placeholder="Enter Business Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="busi_type">Business Type</label> <span  style="color:red" id="type_err"> </span>
                                    <input type="text" name="busi_type" class="form-control" id="busi_type" placeholder="Enter Business Type">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="busi_start_date">Business Start Date</label> <span  style="color:red" id="date_err"> </span>
                                    <input type="month" name="busi_start_date" class="form-control" id="busi_start_date" placeholder="Enter Business Start Date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="busi_location">Business Location</label> <span  style="color:red" id="location_err"> </span>
                                    <input type="text" name="busi_location" class="form-control" id="busi_location" placeholder="Enter Business Location">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="busi_address">Business Address</label> <span  style="color:red" id="address_err"> </span>
                                    <input type="text" name="busi_address" class="form-control" id="busi_address" placeholder="Enter Business Address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gst_no">GST No.</label> <span  style="color:red" id="gst_err"> </span>
                                    <input type="text" name="gst_no" class="form-control" id="gst_no" placeholder="Enter GST No.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gst_no">Service </label> <span  style="color:red" id="service_err"> </span>
                                    <select class="form-control" name="service[]" id="service" multiple>
                                        @foreach($services as $s)
                                        <option value="{{ $s->id }}">{{ $s->service_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Aadhar Image</label>
                                    <div class="custom-file">
                                    <input type="file" name="aadhar_img" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Pan Image</label>
                                    <div class="custom-file">
                                    <input type="file" name="pan_img" class="custom-file-input" id="customFile1">
                                    <label class="custom-file-label" for="customFile1">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Business Shop Image</label>
                                    <div class="custom-file">
                                    <input type="file" name="shop_img" class="custom-file-input" id="customFile2">
                                    <label class="custom-file-label" for="customFile2">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label> <span  style="color:red" id="pwd_err"> </span>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="con_pwd">Confirm Password</label> <span  style="color:red" id="con_pwd_err"> </span>
                                    <input type="password" name="password_confirmation" class="form-control" id="con_pwd" placeholder="Enter Confirm Password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" id="submitButton" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </form>
                    <hr>
                  
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/ruang-admin.min.js') }}"></script>
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
    var password = $("#password").val();
    var confirmPassword = $("#con_pwd").val();
    var service = $('#service').val();
    // alert(service);
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
    if (password=="") {
        $("#pwd_err").fadeIn().html("Required");
        setTimeout(function(){ $("#pwd_err").fadeOut(); }, 3000);
        $("#password").focus();
        return false;
    }
    if (confirmPassword=="") {
        $("#con_pwd_err").fadeIn().html("Required");
        setTimeout(function(){ $("#con_pwd_err").fadeOut(); }, 3000);
        $("#con_pwd").focus();
        return false;
    }
    else
    { 
        $("#submitForm").submit();
    }
})
function checkPasswordMatch() {
    var password = $("#password").val();
    var confirmPassword = $("#con_pwd").val();
    if (password != confirmPassword)
    {
        $("#con_pwd_err").html("Passwords does not match!");
    }
    else{
        $("#con_pwd_err").html("Passwords match.");
    }

}
$(document).ready(function () {
    $("#con_pwd").keyup(checkPasswordMatch);
});
</script>
</body>

</html>