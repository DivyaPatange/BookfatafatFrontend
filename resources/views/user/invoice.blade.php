<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bookfatafat - Invoice</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ public_path('invoiceAsset/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Jquery Core Js -->
 <script src="{{ public_path('invoiceAsset/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ public_path('invoiceAsset/bootstrap.min.js') }}"></script>
<style>
.body-main {
    background: #ffffff;
    border-bottom: 15px solid #1E1F23;
    border-top: 15px solid #1E1F23;
    margin-top: 30px;
    margin-bottom: 30px;
    padding: 40px 30px !important;
    position: relative;
    box-shadow: 0 1px 21px #808080;
    font-size: 10px
}

.main thead {
    background: #1E1F23;
    color: #fff
}
.img {
    height: 100px
}
h1 {
    text-align: center
}
</style>
</head>
<body>
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 body-main">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4"> <img class="img" alt="Invoce Template" src="{{ public_path('frontasset/images/122 (1).png') }}" /> </div>
                        <div class="col-md-8 text-right">
                            <h4 style="color: #F81D2D;"><strong>Bookfatafat</strong></h4>
                            <p>221 ,Baker Street</p>
                            <p>1800-234-124</p>
                            <p>example@gmail.com</p>
                        </div>
                    </div> <br />
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>INVOICE</h2>
                            <h5>{{ $invoice_no }}</h5>
                        </div>
                    </div> <br />
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <h5>Product Name</h5>
                                    </th>
                                    <th>
                                        <h5>Quantity</h5>
                                    </th>
                                    <th>
                                        <h5>Amount</h5>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-md-6">Samsung Galaxy 8 64 GB</td>
                                    <td class="col-md-3">1</td>
                                    <td class="col-md-3"><i class="" area-hidden="true"></i> 50,000 </td>
                                </tr>
                                <tr>
                                    <td class="col-md-6">JBL Bluetooth Speaker</td>
                                    <td class="col-md-3">1</td>
                                    <td class="col-md-3"><i class="" area-hidden="true"></i> 5,200 </td>
                                </tr>
                                <tr>
                                    <td class="col-md-6">Apple Iphone 6s 16GB</td>
                                    <td class="col-md-3">1</td>
                                    <td class="col-md-3"><i class="" area-hidden="true"></i> 25,000 </td>
                                </tr>
                                <tr>
                                    <td class="col-md-6">MI Smartwatch 2</td>
                                    <td class="col-md-3">1</td>
                                    <td class="col-md-3"><i class="" area-hidden="true"></i> 2,200 </td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="2">
                                        <p> <strong>Total Amount: </strong> </p>
                                        <p> <strong>Payable Amount: </strong> </p>
                                    </td>
                                    <td class="col-md-3">
                                        <p> <strong><i class="" area-hidden="true"></i> 82,900</strong> </p>
                                        <p> <strong><i class="" area-hidden="true"></i> 79,900</strong> </p>
                                    </td>
                                </tr>
                                <tr style="color: #F81D2D;">
                                    <td class="text-right" colspan="2">
                                        <h4><strong>Total:</strong></h4>
                                    </td>
                                    <td class="text-left col-md-3">
                                        <h4><strong><i class="" area-hidden="true"></i> 79,900 </strong></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="col-md-12">
                            <p><b>Date :</b> 6 June 2019</p> <br />
                            <p><b>Signature</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
