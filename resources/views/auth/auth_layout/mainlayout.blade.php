<!DOCTYPE html>
<html>
<head>
<title>Bookfatafat | @yield('title')</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Smart Shop Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- Bootstrap CSS-->
@include('auth.auth_layout.link')
@yield('customcss')
<style>
.error{
    color:red;
}
.submitButton{
    background: #7B7B7B;
    color: #fff;
    font-size: 17px;
    border: none;
    width: 100%;
    outline: none;
    -webkit-appearance: none;
    padding: 8px 15px 9px 15px;
    transition: 0.5s all;
    -webkit-transition: 0.5s all;
}
</style>
</head>
<body>
@include('auth.auth_layout.header')

@yield('content')

@include('auth.auth_layout.footer')

@include('auth.auth_layout.script')
@yield('customjs')


<!---->
<script src="{{ asset('frontasset/js/responsiveslides.min.js') }}"></script>
<script>
        // You can also use "$(window).load(function() {"
        $(function () {
            // Slideshow 4
        $("#slider3").responsiveSlides({
            auto: true,
            pager: true,
            nav: false,
            speed: 500,
            namespace: "callbacks",
            before: function () {
        $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
            $('.events').append("<li>after event fired.</li>");
            }
            });
        });
</script>
<!---->
<!----->
<script>$(document).ready(function(c) {
    $('.close1').on('click', function(c){
        $('.rem1').fadeOut('slow', function(c){
            $('.rem1').remove();
        });
        });	  
    });
</script>

<script>$(document).ready(function(c) {
    $('.close2').on('click', function(c){
        $('.rem2').fadeOut('slow', function(c){
            $('.rem2').remove();
        });
        });	  
    });
</script>

<script>$(document).ready(function(c) {
    $('.close3').on('click', function(c){
        $('.rem3').fadeOut('slow', function(c){
            $('.rem3').remove();
        });
        });	  
    });
</script>
<script>$(document).ready(function(c) {
    $('.close4').on('click', function(c){
        $('.rem4').fadeOut('slow', function(c){
            $('.rem4').remove();
        });
        });	  
    });
</script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('body').on('click', '#submitLogin', function () {
    var mobile_no = $("#mobile-no").val();
    var password = $("#password-modal").val();
    // alert(mobile_no);
    if(mobile_no=="") {
        $("#mobile_err").fadeIn().html("Required");
        setTimeout(function(){ $("#mobile_err").fadeOut(); }, 3000);
        $("#mobile-no").focus();
        return false;
    }
    if(password=="") {
        $("#pwd_err").fadeIn().html("Required");
        setTimeout(function(){ $("#pwd_err").fadeOut(); }, 3000);
        $("#password-modal").focus();
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
            document.getElementById("submitForm").reset();
            if(returndata.success){
            $('#myModal4').modal('toggle');
            toastr.success(returndata.success);
            location.reload();
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
                $('#myModal4').modal('toggle');
                $('#myModal5').modal('toggle');
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
                $('#myModal5').modal('toggle');
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
<script>
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        
        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
  @endif
</script>

</body>
</html>