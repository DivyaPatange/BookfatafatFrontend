@extends('user.user_layout.main')
@section('title', 'Order Details')
@section('page_title', 'Order Details')
@section('customcss')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
.error{
    color:red;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Order Details
                </h2>
            </div>
            <?php
                $payment = DB::table('payments')->where('order_id', $order->order_number)->first();
                // dd(!empty($payment));
            ?>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#home" data-toggle="tab">Order Details</a></li>
                    <li role="presentation"><a href="#profile" data-toggle="tab">Product Details</a></li>
                    <li role="presentation"><a href="#messages" data-toggle="tab">Address</a></li>
                    @if(empty($payment))
                    <li role="presentation"><a href="#settings" data-toggle="tab">Payment</a></li>
                    @endif
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                        <blockquote class="m-b-25">
                            <p>Order Number :- {{ $order->order_number }}</p>
                            <p>Product Count :- {{ $order->item_count }}</p>
                            <p>Price :- {{ $order->grand_total }}</p>
                        </blockquote>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="profile">
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $key => $o)
                                <?php
                                    $product = DB::table('products')->where('id', $o->product_id)->first();
                                ?>
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>@if(isset($product) && !empty($product)) {{ $product->product_name }} @endif</td>
                                    <td>{{ $o->quantity }}</td>
                                    <td><i class="fa fa-rupee">&nbsp;</i>@if(isset($product) && !empty($product)) {{ $product->selling_price }} @endif</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="messages">
                        <form method="POST" id="submitForm">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="error" id="country_err"></span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Country" name="country" id="country" value="@if(!empty($userInfo)) {{ $userInfo->country }} @endif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="error" id="name_err"></span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Fullname" name="fullname" id="fullname" value="@if(!empty($userInfo)) {{ $userInfo->fullname }} @endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="error" id="mobile_err"></span>
                                        <div class="form-line">
                                            <input type="number" class="form-control" placeholder="Mobile No." name="mobile_no" id="mobile_no" value="@if(!empty($userInfo)){{ $userInfo->mobile_no }}@endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <span class="error" id="address_err"></span>
                                        <div class="form-line">
                                            <textarea class="form-control" placeholder="Address" name="address" id="address">@if(!empty($userInfo)) {{ $userInfo->address }} @endif</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="error" id="city_err"></span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="City" name="city" id="city" value="@if(!empty($userInfo)) {{ $userInfo->city }} @endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="error" id="pin_err"></span>
                                        <div class="form-line">
                                            <input type="number" class="form-control" placeholder="Pin Code" name="pin_code" id="pin_code" value="@if(!empty($userInfo)){{ $userInfo->pin_code }}@endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button class="btn btn-primary waves-effect" type="button" id="submitButton">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="settings">
                        <p><span class="error" id="payment_err"></span></p>
                        <form method="post" action="{{ route('payment', $order->id) }}" id="paymentForm">
                            @csrf
                            <button type="button" id="paymentButton" class="btn btn-success waves-effect">Proceed To Pay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<script>
$('body').on('click', '#submitButton', function () {
    var country = $("#country").val();
    var fullname = $("#fullname").val();
    var mobile_no = $("#mobile_no").val();
    var address = $("#address").val();
    var city = $("#city").val();
    var pin_code = $("#pin_code").val();
    if (country=="") {
        $("#country_err").fadeIn().html("Required");
        setTimeout(function(){ $("#country_err").fadeOut(); }, 3000);
        $("#country").focus();
        return false;
    }
    if (fullname=="") {
        $("#name_err").fadeIn().html("Required");
        setTimeout(function(){ $("#name_err").fadeOut(); }, 3000);
        $("#fullname").focus();
        return false;
    }
    if (mobile_no=="") {
        $("#mobile_err").fadeIn().html("Required");
        setTimeout(function(){ $("#mobile_err").fadeOut(); }, 3000);
        $("#mobile_no").focus();
        return false;
    }
    if (address=="") {
        $("#address_err").fadeIn().html("Required");
        setTimeout(function(){ $("#address_err").fadeOut(); }, 3000);
        $("#address").focus();
        return false;
    }
    if (city=="") {
        $("#city_err").fadeIn().html("Required");
        setTimeout(function(){ $("#city_err").fadeOut(); }, 3000);
        $("#city").focus();
        return false;
    }
    if (pin_code=="") {
        $("#pin_err").fadeIn().html("Required");
        setTimeout(function(){ $("#pin_err").fadeOut(); }, 3000);
        $("#pin_code").focus();
        return false;
    }
    else
    { 
        $.ajax({
            type:"POST",
            url:"{{ route('save.user-info') }}",
            data:{country:country,fullname:fullname,mobile_no:mobile_no,address:address,city:city,pin_code:pin_code},
            cache:false,        
            success:function(returndata)
            {
                toastr.success(returndata.success);
            
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
})
$('body').on('click', '#paymentButton', function () {
    var country = $("#country").val();
    var fullname = $("#fullname").val();
    var mobile_no = $("#mobile_no").val();
    var address = $("#address").val();
    var city = $("#city").val();
    var pin_code = $("#pin_code").val();
    if (country=="") {
        $("#payment_err").fadeIn().html("Please Complete Address Details");
        setTimeout(function(){ $("#payment_err").fadeOut(); }, 3000);
        return false;
    }
    if (fullname=="") {
        $("#payment_err").fadeIn().html("Please Complete Address Details");
        setTimeout(function(){ $("#payment_err").fadeOut(); }, 3000);
        return false;
    }
    if (mobile_no=="") {
        $("#payment_err").fadeIn().html("Please Complete Address Details");
        setTimeout(function(){ $("#payment_err").fadeOut(); }, 3000);
        return false;
    }
    if (address=="") {
        $("#payment_err").fadeIn().html("Please Complete Address Details");
        setTimeout(function(){ $("#payment_err").fadeOut(); }, 3000);
        return false;
    }
    if (city=="") {
        $("#payment_err").fadeIn().html("Please Complete Address Details");
        setTimeout(function(){ $("#payment_err").fadeOut(); }, 3000);
        return false;
    }
    if (pin_code=="") {
        $("#payment_err").fadeIn().html("Please Complete Address Details");
        setTimeout(function(){ $("#payment_err").fadeOut(); }, 3000);
        return false;
    }
    else
    { 
        $("#paymentForm").submit();   
    }
})
</script>
@endsection