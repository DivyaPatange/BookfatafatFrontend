@extends('user.user_layout.main')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('customcss')

@endsection
@section('content')
@if(count($cartCollection)>0)
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Order Details</h2>
                @if(\Cart::getTotalQuantity()>0)
                <h3>{{ \Cart::getTotalQuantity()}} Product(s) In Your Cart</h3>
                @else
                <h3>No Product(s) In Your Cart &nbsp; <a href="{{ url('/') }}">Continue Shopping</a></h3>
                @endif
            </div>
            <div class="body">
                <div class="row clearfix">
                    @foreach($cartCollection as $item)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <img src="https://admin.bookfatafat.com/ProductImg/{{ $item->attributes->image }}" alt="" width="100%">
                            </div>
                            <div class="body">
                                <p><b>Name: </b> {{ $item->name }}</p>
                                <p><b>Quantity: </b> {{ $item->quantity }}</p>
                                <p><b>Price :</b> &#8377;{{ $item->price }}</p>
                                <p><b>Sub Total: </b> &#8377;{{ \Cart::get($item->id)->getPriceSum() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row clearfix">
                    <div class="col-md-12" style="display:flex">
                        <form action="{{ route('placed.order') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn bg-green waves-effect">Placed Order</button>
                        </form>
                        <a href="{{ url('/') }}"><button type="button" class="btn bg-black waves-effect" style="margin-left:20px;">Continue Shopping</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">playlist_add_check</i>
            </div>
            <div class="content">
                <div class="text">NEW TASKS</div>
                <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">help</i>
            </div>
            <div class="content">
                <div class="text">NEW TICKETS</div>
                <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">forum</i>
            </div>
            <div class="content">
                <div class="text">NEW COMMENTS</div>
                <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">person_add</i>
            </div>
            <div class="content">
                <div class="text">NEW VISITORS</div>
                <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('customjs')

@endsection