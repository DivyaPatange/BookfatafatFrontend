<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Admin\Product;

class DesignController extends Controller
{
    public function filterIndexProduct(Request $request)
    {
        if($request->ajax())
        {
            $product1 = DB::table('products')->where('status', 'In-Stock'); 
            if(isset($request->keyword))
            {
                $product1 = $product1->where('product_name', 'LIKE', $request->keyword.'%'); 
            }
            if(isset($request->category))
            {
                $product1 = $product1->where('category_id', $request->category); 
            }
            if($request->id > 0)
            {
                
                $product1 = $product1->where('id', '<', $request->id); 
            }
            $product = $product1->orderBy('id', 'DESC')->limit(12)->get();
            // dd($product);
            $output = '';
            $last_id = '';
            if(!$product->isEmpty())
            {
                foreach($product as $row)
                {
                    $output .= '<div class="col-md-2 product-men">
                        <div class="men-pro-item simpleCart_shelfItem">
                            <div class="men-thumb-item">';
                            $imageUrl = 'https://admin.bookfatafat.com/ProductImg/' . $row->product_img;
                            $output .= '<img src="'.$imageUrl.'" alt="" class="pro-image-front"style="height: 140px;">
                                <img src="'.$imageUrl.'" alt="" class="pro-image-back">
                                <div class="men-cart-pro">
                                    <div class="inner-men-cart-pro">';
                                    $productUrl = route('single.product', $row->id);
                                    $formUrl = route('cart.store');
                                    $token = csrf_field();
                                    $output .= '<a href="'.$productUrl.'" class="link-product-add-cart">Quick View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item-info-product ">
                                <h4><a href="'.$productUrl.'">'.$row->product_name.'</a></h4>
                                <div class="info-product-price">
                                    <span class="item_price">&#8377;'.$row->selling_price.'</span>
                                    <del>&#8377;'.$row->cost_price.'</del>
                                </div>
                                <form action="'.$formUrl.'" method="POST">'.$token.
                                '<input type="hidden" value="'.$row->id.'" id="id" name="id">
                                <input type="hidden" value="'.$row->product_name.'" id="name" name="name">
                                <input type="hidden" value="'.$row->selling_price.'" id="price" name="price">
                                <input type="hidden" value="'.$row->product_img.'" id="img" name="img">
                                <input type="hidden" value="1" id="quantity" name="quantity">
                                <button class="item_add single-item hvr-outline-out button2">Add to cart</button>		
                                </form>							
                            </div>
                        </div>
                    </div>';
                    $last_id = $row->id;
                }
                $output .= '<div id="load_more" style="text-align:center">
                    <div class="col-sm-12">
                        <button type="button" name="load_more_button" class="btn" data-id="'.$last_id.'" id="load_more_button" style="margin-bottom:20px; margin-top:20px;border: 1px solid #f24f55;
                        color: #f24f55;
                        background: white;">Load More</button>
                        </div>
                    </div>';
            }
            else
            {
             $output .= '
             <div id="load_more" style="text-align:center">
             <div class="col-sm-12">
              <button type="button" name="load_more_button" class="btn" style="margin-bottom:20px;border: 1px solid #f24f55;
              color: #f24f55;
              background: white;">No Data Found</button>
              </div>
             </div>
             ';
            }
            if($request->id){
              $data = array('output' =>$output,'id' =>$request->id);
            }
            else{
              $data = array('output' =>$output);
            }
              // dd($data);
            echo json_encode($data);
              
        }
        
    }
    
    public function singleProduct($id)
    {
        $product = Product::findorfail($id);
        return view('detail_view', compact('product'));
    }

    public function allProducts()
    {
        return view('products');
    }

    public function filterProduct(Request $request)
    {
        if($request->ajax())
        {
            $product1 = DB::table('products')->where('status', 'In-Stock'); 
            if(isset($request->maximum_price, $request->minimum_price) && !empty($request->minimum_price) && !empty($request->maximum_price))
            {
                $product1 = $product1->whereBetween('selling_price', [$request->minimum_price, $request->maximum_price]); 
                // dd($request->minimum_price.' '.$request->maximum_price);
                // return $product;
            }
            if(isset($request->keyword))
            {
                $product1 = $product1->where('product_name', 'LIKE', $request->keyword.'%'); 
            }
            if(isset($request->category))
            {
                $product1 = $product1->where('category_id', $request->category); 
            }
            if($request->id > 0)
            {
                
                $product1 = $product1->where('id', '<', $request->id); 
            }
            $product = $product1->orderBy('id', 'DESC')->limit($request->limit)->get();
            // dd($product);
            $output = '';
            $last_id = '';
            if(!$product->isEmpty())
            {
                foreach($product as $row)
                {
                    $output .= '<div class="col-md-3 product-men">
                        <div class="men-pro-item simpleCart_shelfItem">
                            <div class="men-thumb-item">';
                            $imageUrl = 'https://admin.bookfatafat.com/ProductImg/' . $row->product_img;
                            $output .= '<img src="'.$imageUrl.'" alt="" class="pro-image-front"style="height: 140px;>
                                <img src="'.$imageUrl.'" alt="" class="pro-image-back">
                                <div class="men-cart-pro">
                                    <div class="inner-men-cart-pro">';
                                    $productUrl = route('single.product', $row->id);
                                    $formUrl = route('cart.store');
                                    $token = csrf_field();
                                    $output .= '<a href="'.$productUrl.'" class="link-product-add-cart">Quick View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item-info-product ">
                                <h4><a href="'.$productUrl.'">'.$row->product_name.'</a></h4>
                                <div class="info-product-price">
                                    <span class="item_price">&#8377;'.$row->selling_price.'</span>
                                    <del>&#8377;'.$row->cost_price.'</del>
                                </div>
                                <form action="'.$formUrl.'" method="POST">'.$token.
                                '<input type="hidden" value="'.$row->id.'" id="id" name="id">
                                <input type="hidden" value="'.$row->product_name.'" id="name" name="name">
                                <input type="hidden" value="'.$row->selling_price.'" id="price" name="price">
                                <input type="hidden" value="'.$row->product_img.'" id="img" name="img">
                                <input type="hidden" value="1" id="quantity" name="quantity">
                                <button class="item_add single-item hvr-outline-out button2">Add to cart</button>		
                                </form>							
                            </div>
                        </div>
                    </div>';
                    $last_id = $row->id;
                }
                $output .= '<div id="load_more" style="text-align:center">
                    <div class="col-sm-12">
                        <button type="button" name="load_more_button" class="btn" data-id="'.$last_id.'" id="load_more_button" style="margin-bottom:20px; margin-top:20px;border: 1px solid #f24f55;
                        color: #f24f55;
                        background: white;">Load More</button>
                        </div>
                    </div>';
            }
            else
            {
             $output .= '
             <div id="load_more" style="text-align:center">
             <div class="col-sm-12">
              <button type="button" name="load_more_button" class="btn" style="margin-bottom:20px;margin-top:20px;border: 1px solid #f24f55;
              color: #f24f55;
              background: white;">No Data Found</button>
              </div>
             </div>
             ';
            }
            if($request->id){
              $data = array('output' =>$output,'id' =>$request->id);
            }
            else{
              $data = array('output' =>$output);
            }
              // dd($data);
            echo json_encode($data);
              
        }
    }
    
     public function allServices()
    {
        return view('services');
    }

    public function filterService(Request $request)
    {
        if($request->ajax())
        {
            $service1 = DB::table('services');
            if(isset($request->keyword))
            {
                $service1 = $service1->where('service_name', 'LIKE', $request->keyword.'%'); 
            }
            if(isset($request->category))
            {
                $service1 = $service1->where('category_id', $request->category); 
            }
            if($request->id > 0)
            {
                
                $service1 = $service1->where('id', '<', $request->id); 
            }
            $service = $service1->orderBy('id', 'DESC')->limit(8)->get();
            // dd($product);
            $output = '';
            $last_id = '';
            if(!$service->isEmpty())
            {
                foreach($service as $row)
                {
                    $output .= '<div class="col-md-3 product-men">
                        <div class="men-pro-item simpleCart_shelfItem">
                            <div class="men-thumb-item">';
                            $imageUrl = 'https://admin.bookfatafat.com/ServiceImg/' . $row->service_img;
                            $output .= '<img src="'.$imageUrl.'" alt="" class="pro-image-front">
                                <img src="'.$imageUrl.'" alt="" class="pro-image-back">
                                <div class="men-cart-pro">
                                    <div class="inner-men-cart-pro">';
                                    $productUrl = route('single.product', $row->id);
                                    $output .= '<a href="'.$productUrl.'" class="link-product-add-cart">Quick View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item-info-product ">
                                <h4><a href="'.$productUrl.'">'.$row->service_name.'</a></h4>
                                <div class="info-product-price">
                                    <span class="item_price">&#8377;'.$row->service_cost.'</span>
                                </div>';
                                
                                    if(Route::has('submit-login-form')){
                                        $output .= '<a href="#" data-toggle="modal" data-target="#myModal4"><button class="item_add single-item hvr-outline-out button2">Book</button></a>';
                                    }
                                    else{
                                        $route = url('/home');
                                        $output .= '<a href="'.$route.'"><button class="item_add single-item hvr-outline-out button2">Book</button></a>';
                                    }
                            $output .= '</div>
                        </div>
                    </div>';
                    $last_id = $row->id;
                }
                $output .= '<div id="load_more" style="text-align:center">
                    <div class="col-sm-12">
                        <button type="button" name="load_more_button" class="btn" data-id="'.$last_id.'" id="load_more_button" style="margin-bottom:20px; margin-top:20px;border: 1px solid #f24f55;
                        color: #f24f55;
                        background: white;">Load More</button>
                        </div>
                    </div>';
            }
            else
            {
             $output .= '
             <div id="load_more" style="text-align:center">
             <div class="col-sm-12">
              <button type="button" name="load_more_button" class="btn" style="margin-bottom:20px;margin-top:20px;border: 1px solid #f24f55;
              color: #f24f55;
              background: white;">No Data Found</button>
              </div>
             </div>
             ';
            }
            if($request->id){
              $data = array('output' =>$output,'id' =>$request->id);
            }
            else{
              $data = array('output' =>$output);
            }
              // dd($data);
            echo json_encode($data);
              
        }
    }
}
