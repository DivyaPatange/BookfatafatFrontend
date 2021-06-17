@extends('auth.auth_Layout.main')
@section('title', 'Register')
@section('customcss')
@endsection
@section('content')
<div id="all">
    <div id="content">  
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- breadcrumb-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li aria-current="page" class="breadcrumb-item active">New account / Sign in</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6">
                    <div class="box">
                        <h1>New account</h1>
                        <p class="lead">Not our registered customer yet?</p>
                        <p>With registration with us new world of fashion, fantastic discounts and much more opens to you! The whole process will not take you more than a minute!</p>
                        <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>
                        <hr>
                        <form id="registerForm" method="post">
                            <div class="form-group">
                                <label for="name">Name</label><span class="text-danger" id="name_err"></span>
                                <input id="name" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label><span class="text-danger" id="email_err"></span>
                                <input id="email" type="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile No.</label><span class="text-danger" id="mo_err"></span>
                                <input id="mobile" type="number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password</label><span class="text-danger" id="p_err"></span>
                                <input id="pwd" type="password" class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" id="registerButton"><i class="fa fa-user-md"></i> Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="box">
                        <h1>Login</h1>
                        <p class="lead">Already our customer?</p>
                        <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                        <hr>
                        <form id="submitForm1" method="post">
                            <div class="form-group">
                                <label for="mobile_no">Mobile No.</label><span class="text-danger" id="mobile1_err"></span>
                                <input id="mobile_no" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label><span class="text-danger" id="pwd1_err"></span>
                                <input id="password" type="password" class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="button" id="submitLogin1" class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="login-modal1" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please Verify Mobile No.!</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="submitOTP">
                    <div class="form-group">
                    <input id="mobile-otp" type="hidden" class="form-control" value="">
                    </div>
                    <div class="form-group">
                    <input id="otp" type="number" placeholder="OTP" class="form-control">
                    <span class="text-danger" id="otp_err"></span>
                    </div>
                    <p class="text-center">
                    <button class="btn btn-primary" type="button" id="submitOtp"><i class="fa fa-sign-in"></i>Submit</button>
                    </p>
                </form>
                <div class="form-group">
                    <a href="{{ url('/register') }}"><strong>Resend Now</strong></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<script>
$('body').on('click', '#submitLogin1', function () {
    var mobile_no = $("#mobile_no").val();
    var password = $("#password").val();
    // alert(mobile_no);
    if(mobile_no=="") {
        $("#mobile1_err").fadeIn().html("Required");
        setTimeout(function(){ $("#mobile1_err").fadeOut(); }, 3000);
        $("#mobile_no").focus();
        return false;
    }
    if(password=="") {
        $("#pwd1_err").fadeIn().html("Required");
        setTimeout(function(){ $("#pwd1_err").fadeOut(); }, 3000);
        $("#password").focus();
        return false;
    }
    else
    { 
        $.ajax({
        type:"POST",
        url:"{{ route('submit-login-form') }}",
        data:{mobile_no:mobile_no,password:password},
        cache:false,        
        success:function(returndata)
        {
            document.getElementById("submitForm1").reset();
            if(returndata.success){
            toastr.success(returndata.success);
            }
            else{
            toastr.error(returndata.error);
            }
        }
        });
    }
})

$('body').on('click', '#registerButton', function () {
    var name = $("#name").val();
    var email = $("#email").val();
    var mobile_no = $("#mobile").val();
    var password = $("#pwd").val();
    // alert(mobile_no);
    if(name=="") {
        $("#name_err").fadeIn().html("Required");
        setTimeout(function(){ $("#name_err").fadeOut(); }, 3000);
        $("#name").focus();
        return false;
    }
    if(email=="") {
        $("#email_err").fadeIn().html("Required");
        setTimeout(function(){ $("#email_err").fadeOut(); }, 3000);
        $("#email").focus();
        return false;
    }
    if(mobile_no=="") {
        $("#mo_err").fadeIn().html("Required");
        setTimeout(function(){ $("#mo_err").fadeOut(); }, 3000);
        $("#mobile").focus();
        return false;
    }
    if(password=="") {
        $("#p_err").fadeIn().html("Required");
        setTimeout(function(){ $("#p_err").fadeOut(); }, 3000);
        $("#pwd").focus();
        return false;
    }
    else
    { 
        $.ajax({
        type:"POST",
        url:"{{ route('submit-register-form') }}",
        data:{name:name,email:email, mobile_no:mobile_no, password:password},
        cache:false,        
        success:function(returndata)
        {
            // alert(returndata);
            document.getElementById("registerForm").reset();
            if(returndata.success){
                $('#login-modal1').modal('toggle');
                $("#mobile-otp").val(returndata.mobile_no);
                toastr.success(returndata.success);
            }
            else{
            toastr.error(returndata.error);
            }
        }
        });
    }
})

$('body').on('click', '#submitOtp', function () {
    var otp = $("#otp").val();
    var mobile_no = $("#mobile-otp").val();
    // alert(mobile_no);
    if(otp=="") {
        $("#otp_err").fadeIn().html("Required");
        setTimeout(function(){ $("#otp_err").fadeOut(); }, 3000);
        $("#otp").focus();
        return false;
    }
    else
    { 
        $.ajax({
        type:"POST",
        url:"{{ route('submit-otp-form') }}",
        data:{otp:otp, mobile_no:mobile_no},
        cache:false,        
        success:function(returndata)
        {
            // alert(returndata);
            document.getElementById("submitOTP").reset();
            if(returndata.success){
                $('#login-modal1').modal('toggle');
                toastr.success(returndata.success);
                window.location.href = "/";
            }
            else{
            toastr.error(returndata.error);
            }
        }
        });
    }
})
</script>
@endsection