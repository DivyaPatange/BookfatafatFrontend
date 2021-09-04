<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bookfatafat - Forgot Password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 4 CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <!-- Fontawesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('modalAsset/css/ionicons.min.css') }}">
		<link rel="stylesheet" href="{{ asset('modalAsset/css/style.css') }}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>
    @import url("https://fonts.googleapis.com/css?family=Maven+Pro:400,500,600,700,800,900&display=swap");

    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Maven Pro", sans-serif;
    }
    .wrapper {
    height: 100vh;
    }
    .myColor {
    background-image: linear-gradient(to right, #f83600 50%, #f9d423 150%);
    }
    .myShadow {
    box-shadow: 0 10px 10px rgba(0, 0, 0, 0.5);
    }
    .myBtn {
    border-radius: 50px;
    font-weight: bold;
    font-size: 20px;
    background-image: linear-gradient(to right, #0acffe 0%, #495aff 100%);
    border: none;
    }
    .myBtn:hover {
    background-image: linear-gradient(to right, #495aff 0%, #0acffe 100%);
    }
    .myHr {
    height: 2px;
    border-radius: 100px;
    }
    .myLinkBtn {
    border-radius: 100px;
    width: 50%;
    border: 2px solid #fff;
    }
    @media (max-width: 720px) {
    .wrapper {
        margin: 2px;
    }
    }
</style>
<script>
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>

<!-- jQuery CDN -->
<!-- <script src="{{ asset('modalAsset/js/jquery.min.js') }}"></script> -->
<script src="{{ asset('modalAsset/js/popper.js') }}"></script>
<script src="{{ asset('modalAsset/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('modalAsset/js/main.js') }}"></script>
</head>
  <body class="bg-info">
    <div class="container">
      <!-- Forgot Password Form Start -->
      <div class="row justify-content-center wrapper" id="forgot-box" style="">
        <div class="col-lg-10 my-auto myShadow">
          <div class="row">
            <div class="col-lg-7 bg-white p-4">
              <h1 class="text-center font-weight-bold text-primary">Forgot Your Password?</h1>
              <hr class="my-3" />
              <p class="lead text-center text-secondary">To reset your password, enter the registered mobile no.!</p>
              <form method="post" class="px-3" id="forgot-form">
                <div id="forgotAlert"></div>
                <div class="input-group input-group-lg form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text rounded-0"><i class="far fa-envelope fa-lg"></i></span>
                  </div>
                  <input type="number" id="mobile" name="mobile_no" class="form-control rounded-0" placeholder="Mobile No." />
                </div>
                <span class="text-danger" id="mobile_err"></span>
                <div class="form-group">
                  <input type="button" id="forgot-btn" value="Reset Password" class="btn btn-primary btn-lg btn-block myBtn" />
                </div>
              </form>
            </div>
            <div class="col-lg-5 d-flex flex-column justify-content-center myColor p-4">
              <h1 class="text-center font-weight-bold text-white">Reset Password!</h1>
              <hr class="my-4 bg-light myHr" />
              <button class="btn btn-outline-light btn-lg font-weight-bolder myLinkBtn align-self-center" id="back-link">Back</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Forgot Password Form End -->
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true" class="ion-ios-close"></span>
		        </button>
		      </div>
		      <div class="modal-body p-4 p-md-5">
		      	<div class="icon d-flex align-items-center justify-content-center">
		      		<span class="ion-ios-person"></span>
		      	</div>
		      	<h3 class="text-center mb-4">New Password</h3>
		      	<form method="POST" class="login-form">
		      		<div class="form-group">
		      			<input type="password" class="form-control rounded-left" id="new_pwd" placeholder="New Password">
		      		</div>
              <span class="text-danger" id="new_err"></span>
	            <div class="form-group d-flex">
	              <input type="password" class="form-control rounded-left" id="conf_pwd" placeholder="Confirm Password">
	            </div>
              <span class="text-danger" id="conf_err"></span>
              <input type="hidden" id="mobile_no" name="mobile_no">
	            <div class="form-group">
	            	<button type="button" id="save-pwd" class="form-control btn btn-primary rounded submit px-3">Save</button>
	            </div>
	          </form>
		      </div>
		    </div>
		  </div>
		</div>
    <script>
      $('body').on('click', '#forgot-btn', function () {
        var mobile = $("#mobile").val();
        if (mobile=="") {
          $("#mobile_err").fadeIn().html("Required");
          setTimeout(function(){ $("#mobile_err").fadeOut(); }, 3000);
          $("#mobile").focus();
          return false;
        }
        else
        { 
          var datastring="mobile="+mobile;
          $.ajax({
            type:"POST",
            url:"{{ route('search-mobile-no') }}",
            data:datastring,
            cache:false,        
            success:function(returndata)
            {
              if(returndata.success) {
                $('#exampleModalCenter').modal('show');
                document.getElementById("forgot-form").reset();
                $("#mobile_no").val(returndata.mobile_no)
                toastr.success(returndata.success);
              } else {
                toastr.error(returndata.error);
              }
            }
          });
        }
      })
      $('body').on('click', '#save-pwd', function () {
        var new_pwd = $("#new_pwd").val();
        var conf_pwd = $("#conf_pwd").val();
        var mobile_no = $("#mobile_no").val();
        if (new_pwd=="") {
          $("#new_err").fadeIn().html("Required");
          setTimeout(function(){ $("#new_err").fadeOut(); }, 3000);
          $("#new_pwd").focus();
          return false;
        }
        if (conf_pwd=="") {
          $("#conf_err").fadeIn().html("Required");
          setTimeout(function(){ $("#conf_err").fadeOut(); }, 3000);
          $("#conf_pwd").focus();
          return false;
        }
        if (new_pwd!=conf_pwd) {
          $("#new_err").fadeIn().html("Confirm Password not match.");
          setTimeout(function(){ $("#new_err").fadeOut(); }, 3000);
          $("#new_pwd").focus();
          return false;
        }
        else
        { 
          var datastring="new_pwd="+new_pwd+"&mobile_no="+mobile_no;
          $.ajax({
            type:"POST",
            url:"{{ route('save-pwd') }}",
            data:datastring,
            cache:false,        
            success:function(returndata)
            {
              if(returndata.success) {
                $('#exampleModalCenter').modal('hide');
                // document.getElementById("login-form").reset();
                toastr.success(returndata.success);
              } else {
                toastr.error(returndata.error);
              }
            }
          });
        }
      })
    </script>
  </body>
</html>