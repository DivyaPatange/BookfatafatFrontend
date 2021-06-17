<!-- header -->
<div class="header">
	<div class="container">
		<ul>
			<li><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Free and Fast Delivery</li>
			<li><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>Free shipping On all orders</li>
			<li><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span><a href="mailto:info@example.com">info@example.com</a></li>
		</ul>
	</div>
</div>
<!-- //header -->
<!-- header-bot -->
<div class="header-bot">
	<div class="container">
		<div class="col-md-3 header-left">
			<h1><a href="{{ url('/') }}"><img src="{{ asset('frontasset/images/122 (1).png') }}"></a></h1>
		</div>
		<div class="col-md-6 header-middle">
			<form method="POST">
				<div class="search">
					<input type="search" id="search">
				</div>
				<?php 
				$categories = DB::table('categories')->where('status', 'Active')->get();
				?>
				<div class="section_room">
					<select id="category" class="frm-field">
						<option value="">All categories</option>
						@foreach($categories as $c)
						<option value="{{ $c->id }}">{{ $c->cat_name }}</option>
						@endforeach
					</select>
				</div>
				<div class="sear-sub">
					<button type="button" id="searchButton"></button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>
		<div class="col-md-3 header-right footer-bottom">
			<ul>
				@if (Route::has('login'))
					@auth
    					@if(Auth::user()->avatar)
    					<li><a href="/home" style="background: url('{{ Auth::user()->avatar }}'); width: 32px; height: 32px; border-radius: 50%; background-size: cover;"></a></li>
    					@else
    					<li><a href="/home" class="use1"><span>Home</span></a></li>
    					@endif
    					
					@else
					<li><a href="#" class="use1" data-toggle="modal" data-target="#myModal4"><span>Login</span></a></li>
					@endauth
                @endif
				<li><a class="fb" href="#"></a></li>
				<li><a class="twi" href="#"></a></li>
				<li><a class="insta" href="#"></a></li>
				<li><a class="you" href="#"></a></li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //header-bot -->


<!-- banner -->
<div class="ban-top">
	<div class="container">
		<div class="top_nav_left">
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav menu__list">
					<li class="active menu__item menu__item--current"><a class="menu__link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a></li>
					<li class="dropdown menu__item">
						<a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">men's wear <span class="caret"></span></a>
							<ul class="dropdown-menu multi-column columns-3">
								<div class="row">
									<div class="col-sm-6 multi-gd-img1 multi-gd-text ">
										<a href="mens.php"><img src="{{ asset('frontasset/images/woo1.jpg') }}" alt=" "/></a>
									</div>
									<div class="col-sm-3 multi-gd-img">
										<ul class="multi-column-dropdown">
											<li><a href="{{ url('/clothing') }}">Clothing</a></li>
											<li><a href="mens.php">Wallets</a></li>
											<li><a href="mens">Footwear</a></li>
											<li><a href="mens">Watches</a></li>
											<li><a href="mens">Accessories</a></li>
											<li><a href="mens">Bags</a></li>
											<li><a href="mens">Caps & Hats</a></li>
										</ul>
									</div>
									<div class="col-sm-3 multi-gd-img">
										<ul class="multi-column-dropdown">
											<li><a href="mens">Jewellery</a></li>
											<li><a href="mens">Sunglasses</a></li>
											<li><a href="mens">Perfumes</a></li>
											<li><a href="mens">Beauty</a></li>
											<li><a href="mens">Shirts</a></li>
											<li><a href="mens">Sunglasses</a></li>
											<li><a href="mens">Swimwear</a></li>
										</ul>
									</div>
									<div class="clearfix"></div>
								</div>
							</ul>
					</li>
					<li class="dropdown menu__item">
						<a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">women's wear <span class="caret"></span></a>
							<ul class="dropdown-menu multi-column columns-3">
								<div class="row">
									<div class="col-sm-3 multi-gd-img">
										<ul class="multi-column-dropdown">
											<li><a href="{{ url('womens') }}">Clothing</a></li>
											<li><a href="womens">Wallets</a></li>
											<li><a href="womens">Footwear</a></li>
											<li><a href="womens">Watches</a></li>
											<li><a href="womens">Accessories</a></li>
											<li><a href="womens">Bags</a></li>
											<li><a href="womens">Caps & Hats</a></li>
										</ul>
									</div>
									<div class="col-sm-3 multi-gd-img">
										<ul class="multi-column-dropdown">
											<li><a href="womens">Jewellery</a></li>
											<li><a href="womens">Sunglasses</a></li>
											<li><a href="womens">Perfumes</a></li>
											<li><a href="womens">Beauty</a></li>
											<li><a href="womens">Shirts</a></li>
											<li><a href="womens">Sunglasses</a></li>
											<li><a href="womens">Swimwear</a></li>
										</ul>
									</div>
									<div class="col-sm-6 multi-gd-img multi-gd-text ">
										<a href="{{ url('womens')}}"><img src="{{ asset('frontasset/images/woo.jpg') }}" alt=" "/></a>
									</div>
									<div class="clearfix"></div>
								</div>
							</ul>
					</li>
					<li class=" menu__item"><a class="menu__link" href="{{ url('electronics') }}">Electronics</a></li>
					<li class=" menu__item"><a class="menu__link" href="{{ url('products') }}">Products</a></li>
					<li class=" menu__item"><a class="menu__link" href="{{ url('contact') }}">contact</a></li>
				  </ul>
				</div>
			  </div>
			</nav>	
		</div>
		<div class="top_nav_right">
			<div class="cart box_1">
				<a href="{{ url('checkout') }}">
					<h3> <div class="total">
						<i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i>
						<span class="">&#8377; {{ \Cart::getTotal() }}</span> (<span id="" class="">{{ \Cart::getTotalQuantity() }}</span> items)</div>
						
					</h3>
				</a>
				<form action="{{ route('cart.clear') }}" method="POST" style="text-align:center">
				{{ csrf_field() }}
					<button class="simpleCart_empty">Empty Cart</button>
				</form>
			</div>	
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //banner-top -->


<!-- login -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-info">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
			</div>
			<div class="modal-body modal-spa">
				<div class="login-grids">
					<div class="login">
						<div class="login-bottom">
							<h3>Sign up for free</h3>
							<form id="registerForm" method="post">
								<div class="sign-up">
									<h4>Name : <span class="error" id="name_err"></span></h4>
									<input type="text" id="name">	
								</div>
								<div class="sign-up">
									<h4>Email : <span class="error" id="email_err"></span></h4>
									<input type="email" id="email" style="margin: 6px 0 17px 0px;width: 100%; padding: 10px; font-weight: normal; background: none; border: 1px solid #E6E4E4; color: #D2D1D1; outline: none; font-size: 14px;">	
								</div>
								<div class="sign-up">
									<h4>Mobile No. : <span class="error" id="mo_err"></span></h4>
									<input type="number" id="mobile" style="margin: 6px 0 17px 0px;width: 100%; padding: 10px; font-weight: normal; background: none; border: 1px solid #E6E4E4; color: #D2D1D1; outline: none; font-size: 14px;">
									
								</div>
								<div class="sign-up">
									<h4>Password : <span class="error" id="p_err"></span></h4>
									<input type="password" id="pwd">
									
								</div>
								<div class="sign-up">
									<button type="button" id="registerButton" class="submitButton">REGISTER NOW</button>
								</div>
								
							</form>
						</div>
						<div class="login-right">
							<h3>Sign in with your account</h3>
							<form method="POST" id="submitForm">
								<div class="sign-in">
									<h4>Mobile No. : <span class="error" id="mobile_err"></span></h4>
									<input type="number" id="mobile-no" style="margin: 6px 0 17px 0px;width: 100%; padding: 10px; font-weight: normal; background: none; border: 1px solid #E6E4E4; color: #D2D1D1; outline: none; font-size: 14px;">	
								</div>
								<div class="sign-in">
									<h4>Password : <span class="error" id="pwd_err"></span></h4>
									<input type="password" id="password-modal">
									<a href="#">Forgot password?</a>
								</div>
								<div class="single-bottom">
									<input type="checkbox"  id="brand" value="">
									<label for="brand"><span></span>Remember Me.</label>
								</div>
								<div class="sign-in">
									<button type="button" id="submitLogin" class="submitButton">SIGNIN</button>
								</div>
								<div class="single-bottom">
									<a href="{{ url('auth/google') }}"><img src="{{ asset('glogin.png') }}" width="100%" height="55px"></a>
								</div>
							</form>
						</div>
						<div class="clearfix"></div>
					</div>
					<p>By logging in you agree to our <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a></p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document" style="width:400px">
		<div class="modal-content modal-info">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
			</div>
			<div class="modal-body modal-spa">
				<div class="login-grids">
					<div class="login">
						<div class="">
							<h3>Please Verify Mobile No.!</h3>
							<form id="submitOTP" method="post">
								<input id="mobile-otp" type="hidden" value="">
								<div class="sign-up">
									<h4>OTP : <span class="error" id="otp_err"></span></h4>
									<input type="number" id="otp" style="margin: 6px 0 17px 0px;width: 100%; padding: 10px; font-weight: normal; background: none; border: 1px solid #E6E4E4; color: #D2D1D1; outline: none; font-size: 14px;">
									
								</div>
								<div class="sign-up">
									<button type="button" id="submitOtp" class="submitButton">VERIFY</button>
								</div>
								
							</form>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- //login -->