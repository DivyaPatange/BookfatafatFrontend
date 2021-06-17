@extends('user.user_layout.main')
@section('title', 'Payment Success')
@section('page_title', 'Payment Success')
@section('customcss')

@endsection
@section('content')
<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float:none; margin:auto">
        <div class="card">
            <div class="header">
                <h2 class="col-teal"><i class="material-icons">check_circle</i>&nbsp; <span class="icon_name">Transaction is Successfully Done.</span></h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-3">
                        <p><b>Transaction ID</b></p>
                    </div>
                    <div class="col-md-9">
                        <p>: {{ $paymentDetail->transaction_id }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Paid Amount :</b></p>
                    </div>
                    <?php
                        $order = DB::table('orders')->where('id', $paymentDetail->order_id)->first();
                    ?>
                    <div class="col-md-9">
                        <p>@if(!empty($order)){{ $order->grand_total }} @endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Payment Date :</b></p>
                    </div>
                    <div class="col-md-9">
                        <p>{{ date('d-m-Y', strtotime($paymentDetail->created_at)) }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Payment Mode :</b></p>
                    </div>
                    <div class="col-md-9">
                        <p>{{ $paymentDetail->payment_mode }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')

@endsection