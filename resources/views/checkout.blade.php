@extends('auth.auth_layout.mainlayout')
@section('title', 'Index')
@section('customcss')
	<!-- cart -->
	<script src="{{ asset('frontasset/js/simpleCart.min.js') }}"></script>
<!-- cart -->
<style>
input,
textarea {
  border: 1px solid #eeeeee;
  box-sizing: border-box;
  margin: 0;
  outline: none;
  padding: 10px;
}

input[type="button"] {
  -webkit-appearance: button;
  cursor: pointer;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

.input-group {
  clear: both;
  margin: 15px auto;
  position: relative;
}

.input-group input[type='button'] {
  background-color: #eeeeee;
  min-width: 38px;
  width: auto;
  transition: all 300ms ease;
}

.input-group .button-minus,
.input-group .button-plus {
  font-weight: bold;
  height: 38px;
  padding: 0;
  width: 38px;
  position: relative;
}

.input-group .quantity-field {
  position: relative;
  height: 38px;
  left: -6px;
  text-align: center;
  width: 62px;
  display: inline-block;
  font-size: 13px;
  margin: 0 0 5px;
  resize: vertical;
}

.button-plus {
  left: -13px;
}

input[type="number"] {
  -moz-appearance: textfield;
  -webkit-appearance: none;
}
.checkout-right-basket .proceed{
	background:#ff0000;
}
</style>
@endsection
@section('content')
    <!-- banner -->
<div class="page-head">
	<div class="container">
		<h3>Check Out</h3>
	</div>
</div>
<!-- //banner -->
<!-- check out -->
<div class="checkout">
	<div class="container">
		<h3>My Shopping Bag</h3>
		@if(\Cart::getTotalQuantity()>0)
			<h4>{{ \Cart::getTotalQuantity()}} Product(s) In Your Cart</h4><br>
		@else
			<h4>No Product(s) In Your Cart</h4><br>
			<a href="{{ url('/') }}" style="margin-bottom:20px">Continue Shopping</a>
			
		@endif
		<div class="table-responsive checkout-right animated wow slideInUp" data-wow-delay=".5s">
			<table class="timetable_sub">
				<thead>
					<tr>
						<th>Remove</th>
						<th>Product</th>
						<th>Quantity</th>
						<th>Product Name</th>
						<th>Price</th>
						<th>Sub-Total</th>
					</tr>
				</thead>
					@foreach($cartCollection as $item)
					<tr >
						<td class="invert-closeb">
							<form action="{{ route('cart.remove') }}" method="POST">
								{{ csrf_field() }}
								<input type="hidden" value="{{ $item->id }}" id="id" name="id">
								<div class="rem">
									<button class="close1" style="border:none"></button>
								</div>
							</form>
							<!-- script trasfer to main layout -->
							
						</td>
						<td class="invert-image" width="36%"><a href="{{ url ('detail_view') }}"><img src="https://admin.bookfatafat.com/ProductImg/{{ $item->attributes->image }}" alt=" " class="img-responsive" /></a></td>
						<td class="invert">
							 <div class="quantity"> 
								<div class="quantity-select">  
								<form action="{{ route('cart.update') }}" method="POST">
                                    {{ csrf_field() }}       
									<input type="hidden" value="{{ $item->id}}" id="id" name="id">                  
									<div class="input-group">
										<input type="button" value="-" class="button-minus button" data-field="quantity">
										<input type="number" step="1" value="{{ $item->quantity }}" id="quantity" name="quantity" class="quantity-field">
										<input type="button" value="+" class="button-plus button" data-field="quantity">
										<button class="btn btn-secondary" style="margin-right: 25px;"><i class="glyphicon glyphicon-edit"></i></button>
									</div>
								</form>
								</div>
							</div>
						</td>
						<td class="invert">{{ $item->name }}</td>
						<td class="invert">&#8377;{{ $item->price }}</td>
						<td class="invert">&#8377;{{ \Cart::get($item->id)->getPriceSum() }}</td>
					</tr>
					@endforeach
					
			</table>
		</div>
		<div class="checkout-left">	
				
				<div class="checkout-right-basket animated wow slideInRight" data-wow-delay=".5s">
					<a href="{{ url('/')}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back To Shopping</a>
					<a href="@auth {{ url('/home') }} @else # @endauth" @auth @else data-toggle="modal" data-target="#myModal4" @endauth class="proceed">Proceed To Checkout</a>
				</div>
				<div class="checkout-left-basket animated wow slideInLeft" data-wow-delay=".5s">
					<h4>Shopping basket</h4>
					<ul>
						@if(count($cartCollection) > 0)
						@foreach($cartCollection as $item)
						<li>{{ $item->name }} <i>-</i> <span>&#8377;{{ \Cart::get($item->id)->getPriceSum() }}</span></li>
						@endforeach
						<li>Total <i>-</i> <span>&#8377;{{ \Cart::getTotal() }}</span></li>
						@else
						<li>No Product(s) in Cart.</li>
						@endif
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
	</div>
</div>	
<!-- //check out -->

<!-- //product-nav -->
<div class="coupons">
	<div class="container">
		<div class="coupons-grids text-center">
			<div class="col-md-3 coupons-gd">
				<h3>Buy your product in a simple way</h3>
			</div>
			<div class="col-md-3 coupons-gd">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<h4>LOGIN TO YOUR ACCOUNT</h4>
				<p>Neque porro quisquam est, qui dolorem ipsum quia dolor
			sit amet, consectetur.</p>
			</div>
			<div class="col-md-3 coupons-gd">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<h4>SELECT YOUR ITEM</h4>
				<p>Neque porro quisquam est, qui dolorem ipsum quia dolor
			sit amet, consectetur.</p>
			</div>
			<div class="col-md-3 coupons-gd">
				<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
				<h4>MAKE PAYMENT</h4>
				<p>Neque porro quisquam est, qui dolorem ipsum quia dolor
			sit amet, consectetur.</p>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
@endsection
@section('customjs')
<script>
function incrementValue(e) {
  e.preventDefault();
  var fieldName = $(e.target).data('field');
  var parent = $(e.target).closest('div');
  var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

  if (!isNaN(currentVal)) {
    parent.find('input[name=' + fieldName + ']').val(currentVal + 1);

  } else {
    parent.find('input[name=' + fieldName + ']').val(0);
  }
}

function decrementValue(e) {
  e.preventDefault();
  var fieldName = $(e.target).data('field');
  var parent = $(e.target).closest('div');
  var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

  if (!isNaN(currentVal) && currentVal > 0) {
    parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
  } else {
    parent.find('input[name=' + fieldName + ']').val(0);
  }
}

$('.input-group').on('click', '.button-plus', function(e) {
  incrementValue(e);
//   console.log(incrementValue(e));
});

$('.input-group').on('click', '.button-minus', function(e) {
  decrementValue(e);
});

</script>
@endsection