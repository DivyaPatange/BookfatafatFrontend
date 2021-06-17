@extends('auth.auth_layout.mainlayout')
@section('title', 'Products')
@section('customcss')
<link rel="stylesheet" type="text/css" href="{{ asset('frontasset/css/jquery-ui.css') }}"><img src="" alt="">
@endsection
@section('content')
    <!-- banner -->
<div class="page-head">
	<div class="container">
		<h3>Men's Wear</h3>
	</div>
</div>
<!-- //banner -->
<!-- mens -->
<div class="men-wear">
	<div class="container">
		<div class="col-md-4 products-left">
			<div class="filter-price">
				<h3>Filter By Price</h3>
					<ul class="dropdown-menu6">
						<li>                
							<div id="slider-range"></div>	
                            <input type="hidden" id="hidden_minimum_price" value="0" />
							<input type="hidden" id="hidden_maximum_price" value="7000" />						
							<input type="text" id="amount" style="border: 0; color: #ffffff; font-weight: normal;" />
						</li>			
					</ul>
			</div>
			<div class="css-treeview">
				<h4>Categories</h4>
                <?php
                    $allCategory = DB::table('categories')->where('status', 'Active')->get();
                ?>
				<ul class="tree-list-pad">
                    @foreach($allCategory as $key=> $c)
					<li><input type="checkbox" checked="checked" id="item-{{ $key }}" /><label for="item-{{ $key }}"><span></span>{{ $c->cat_name }}</label>
                        <?php
                            $subCategory = DB::table('sub_categories')->where('category_id', $c->id)->get();
                        ?>
                        @if(count($subCategory) > 0)
						<ul>
                            @foreach($subCategory as $key1 => $s)
							<li><input type="checkbox" id="item-{{ $key }}-{{ $key1 }}" /><label for="item-{{ $key }}-{{ $key1 }}">{{ $s->sub_category }}</label></li>
                            @endforeach
						</ul>
                        @endif
					</li>
                    @endforeach
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="col-md-8 products-right">
			<h5>Product Compare(0)</h5>
			<div class="sort-grid">
				<div class="sorting">
					<h6>Showing</h6>
					<select id="limit" class="frm-field required sect">
						<option value="8">8</option>
						<option value="12">12</option> 
						<option value="16">16</option>					
						<option value="20">20</option>								
					</select>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="men-wear-top">
				 <!-- this script are added on mainlayout -->
				<div  id="top" class="callbacks_container">
					<ul class="rslides" id="slider3">
						<li>
							<img class="img-responsive" src="{{ asset('frontasset/images/men1.jpg') }}" alt=" "/>
						</li>
						<li>
							<img class="img-responsive" src="{{ asset('frontasset/images/men2.jpg') }}" alt=" "/>
						</li>
						<li>
							<img class="img-responsive" src="{{ asset('frontasset/images/men1.jpg') }}" alt=" "/>
						</li>
						<li>
							<img class="img-responsive" src="{{ asset('frontasset/images/men2.jpg') }}" alt=" "/>
						</li>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="men-wear-bottom">
				<div class="col-sm-4 men-wear-left">
					<img class="img-responsive" src="{{ asset('frontasset/images/men3.jpg') }}" alt=" " />
				</div>
				<div class="col-sm-8 men-wear-right">
					<h4>Exclusive Men's Collections</h4>
					<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem 
					accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae 
					ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
					explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut
					odit aut fugit. </p>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		<div class="single-pro">
            <div id="post_data"></div>
			<div class="clearfix"></div>
		</div>
		<div class="pagination-grid text-right">
			<ul class="pagination paging">
				<li><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
				<li class="active"><a href="#">1<span class="sr-only">(current)</span></a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
			</ul>
		</div>
	</div>
</div>	
<!-- //mens -->
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
<script type="text/javascript" src="{{ asset('frontasset/js/jquery-ui.js') }}"></script>
<!---->
<script type='text/javascript'>//<![CDATA[ 

$(document).ready(function(){
    filter_data('');

    function filter_data(id="")
    {	if(id == ""){
            $('#post_data').html('<div id="loading" style="" ></div>');
        }
        // alert(id);
        var minimum_price = $('#hidden_minimum_price').val();
	    var maximum_price = $('#hidden_maximum_price').val();
        var category = get_filter('category');
        var keyword = $('#search').val();
        var limit = get_filter_limit('limit');
        // alert(minimum_price);
        $.ajax({
            url:"{{ route('filter.product') }}",
            method:"POST",
            data:{minimum_price:minimum_price, maximum_price:maximum_price, category:category,id:id, keyword:keyword, limit:limit},
            success:function(data){
                var json = JSON.parse(data);
                // alert(data);
                
                if(json.id)
                {
                    $('#load_more_button').remove();
                    // alert(json.id);
                    $('#post_data').append(json.output);
                }
                else{
                    $('#post_data').html(json.output);
                }
                // if(json.id )
            }
        });
    }

    function get_filter(class_name)
    {
        var category = $("#category").val();
        return category;
    }
    function get_filter_limit(class_name)
    {
        var limit = $("#limit").val();
        return limit;
    }

    $('#category').change(function(){
        filter_data();
    });
    $('#limit').change(function(){
        filter_data();
    });
    $('#search').keyup(function(){
        filter_data();
    });
    $(window).load(function(){
        $( "#slider-range" ).slider({
                range: true,
                min: 100,
                max: 7000,
                values: [ 100, 7000 ],
                step:100,
                slide: function( event, ui ) {  
                    $( "#amount" ).val( "₹" + ui.values[ 0 ] + " - ₹" + ui.values[ 1 ] );
                    $('#hidden_minimum_price').val(ui.values[0]);
		            $('#hidden_maximum_price').val(ui.values[1]);
                    filter_data();
                }
        });
        $( "#amount" ).val( "₹" + $( "#slider-range" ).slider( "values", 0 ) + " - ₹" + $( "#slider-range" ).slider( "values", 1 ) );
    });
    $(document).on('click', '#load_more_button', function(){
        var id = $(this).data('id');
        $('#load_more_button').html('<b>Loading...</b>');
        filter_data(id);
    });

});
//]]>  

</script>
@endsection