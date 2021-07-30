<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookfatafat - Invoice</title>
    <style>
        @page { margin: 0px; }
        body{
            background-color: #F6F6F6; 
            margin: 0;
            padding: 0;
        }
        h1,h2,h3,h4,h5,h6{
            margin: 0;
            padding: 0;
        }
        p{
            margin: 0;
            padding: 0;
        }
        .container{
            width: 80%;
            margin-right: auto;
            margin-left: auto;
        }
        .brand-section{
           background-color: #0d1033;
           padding: 10px 40px;
        }
        .logo{
            width: 50%;
        }

        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .col-6{
            width: 50%;
            flex: 0 0 auto;
        }
        .text-white{
            color: #fff;
        }
        .text-left{
            text-align:left;
        }
        .company-details{
            /* float: right; */
            text-align: right;
        }
        .body-section{
            padding: 16px;
            border: 1px solid gray;
        }
        .heading{
            font-size: 20px;
            margin-bottom: 08px;
            text-align:left;
        }
        .sub-heading{
            color: #262626;
            margin-bottom: 05px;
            text-align:left;
        }
        table{
            background-color: #fff;
            width: 100%;
            border-collapse: collapse;
        }
        table thead tr{
            border: 1px solid #111;
            background-color: #f2f2f2;
        }
        table td {
            vertical-align: middle !important;
            text-align: center;
        }
        table th, table td {
            padding-top: 08px;
            padding-bottom: 08px;
        }
        .table-bordered{
            box-shadow: 0px 0px 5px 0.5px gray;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .text-right{
            text-align: end;
        }
        .w-20{
            width: 20%;
        }
        .float-right{
            float: right;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="brand-section">
            <table width="100%" style="background-color:transparent;">
                <tr>
                    <td>
                        <h1 class="text-white text-left">Bookfatafat</h1>
                    </td>
                    <td>
                        <div class="company-details">
                            <p class="text-white">bookfatafat.com</p>
                            <p class="text-white">12K Street, 45 Building Road</p>
                            <p class="text-white">+91 888555XXXX</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="body-section">
            <?php 
                $order = DB::table('orders')->where('id', $order_id)->first();
                if(!empty($order)){
                    $userInfo = DB::table('user_infos')->where('user_id', $order->user_id)->first();
                }
            ?>
            <table width="table" style="background-color:transparent;">
                <tr>
                    <td>
                        <h2 class="heading">Invoice No.: {{ $invoice_no }}</h2>
                        <p class="sub-heading">Transaction No. {{ $transaction_id }} </p>
                        <p class="sub-heading">Order Date: @if(!empty($order)){{ date('d-m-Y', strtotime($order->created_at)) }} @endif</p>
                        <p class="sub-heading">Email Address: {{ $email }} </p>
                    </td>
                    <td>
                        <p class="sub-heading">Full Name: {{ $name }} </p>
                        <p class="sub-heading">Address: @if(!empty($order)) @if(!empty($userInfo)) {{ $userInfo->address }} @endif @endif</p>
                        <p class="sub-heading">City: @if(!empty($order)) @if(!empty($userInfo)) {{ $userInfo->city }} @endif @endif </p>
                        <p class="sub-heading">Pincode: @if(!empty($order)) @if(!empty($userInfo)) {{ $userInfo->pin_code }} @endif @endif</p>
                        <p class="sub-heading">Phone Number: @if(!empty($order)) {{ $order->mobile_no }} @endif </p>
                    </td>
                </tr>
            </table>
            <!-- <div class="row">
                <div class="col-6">
                    
                </div>
                <div class="col-6">
                    
                </div>
            </div> -->
        </div>

        <div class="body-section">
            <h3 class="heading">Ordered Items</h3>
            <br>
            <?php 
                $orderItems = DB::table('order_items')->where('order_id', $order_id)->get();
            ?>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="w-20">Price</th>
                        <th class="w-20">Quantity</th>
                        <th class="w-20">Grandtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $orderItem)
                    <?php
                        $product = DB::table('products')->where('id', $orderItem->product_id)->first();
                        $total = $orderItem->quantity * $orderItem->price;
                    ?>
                    <tr>
                        <td>@if(!empty($product)) {{ $product->product_name }} @endif</td>
                        <td>INR {{ $orderItem->price }}</td>
                        <td>{{ $orderItem->quantity }}</td>
                        <td>INR {{ $total }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right">Sub Total</td>
                        <td>INR @if(!empty($order)) {{ $order->grand_total }} @endif</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Grand Total</td>
                        <td>INR @if(!empty($order)) {{ $order->grand_total }} @endif</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h3 class="heading">Payment Status: Paid</h3>
            <h3 class="heading">Payment Mode: {{ $payment_mode }}</h3>
        </div>

        <div class="body-section">
            <p>&copy; Copyright {{ date('Y') }} - Bookfatafat. All rights reserved. 
                <a href="https://bookfatafat.com/" class="float-right">www.bookfatafat.com</a>
            </p>
        </div>      
    </div>      

</body>
</html>