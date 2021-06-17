<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\SubCategory;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        if(request()->ajax()) {
            return datatables()->of($products)
            ->addColumn('product_img', function($row){    
                if(!empty($row->product_img)){
                    $imageUrl = asset('ProductImg/' . $row->product_img);
                    return '<img src="'.$imageUrl.'" width="50px">';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('category_id', function($row){    
                $category = Category::where('id', $row->category_id)->first();
                if(!empty($category))
                {
                    return $category->cat_name;
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('sub_category', function($row){    
                $subCategory = SubCategory::where('id', $row->sub_category_id)->first();
                if(!empty($subCategory))
                {
                    return $subCategory->sub_category;
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('status', function($row){
                if($row->status == "In-Stock")
                {
                    return '<span class="badge badge-success">'.$row->status.'</span>';
                }  
                else{
                    return '<span class="badge badge-danger">'.$row->status.'</span>';
                }                                                                                                                                                                                                                                                                                    
            })
            ->addColumn('action', 'vendor.product.action')
            ->rawColumns(['action', 'product_img', 'status', 'service'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 'Active')->get(); 
        return view('vendor.product.create', compact('categories'));
    }

    public function getSubCategoryList(Request $request)
    {
        $category = SubCategory::where("category_id", $request->category_id)->where('status', 1)
        ->pluck("sub_category","id");
        return response()->json($category);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->vendor_id = Auth::guard('vendor')->user()->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->product_name = $request->product_name;
        $image = $request->file('product_img');
        // dd($request->file('photo'));
        if($image != '')
        {
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('ProductImg'), $image_name);
            $product->product_img =$image_name;
        }
        $product->selling_price = $request->selling_price;
        $product->cost_price = $request->cost_price;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->save();
        return redirect('/vendors/product')->with('success', 'Product Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('status', 'Active')->get();
        $product = Product::findorfail($id); 
        $subCategory = SubCategory::where('category_id', $product->category_id)->where('status', 'Active')->get();
        return view('vendor.product.edit', compact('product', 'categories', 'subCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findorfail($id);
        $image_name = $request->hidden_image;
        $image = $request->file('product_img');
        if($image != '')
        {
            unlink(public_path('ProductImg/'.$product->product_img));
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('ProductImg'), $image_name);
        }

        $input_data = array (
            'sub_category_id' => $request->sub_category,
            'category_id' => $request->category,
            'product_name' => $request->product_name,
            'product_img' => $image_name,
            'selling_price' => $request->selling_price,
            'cost_price' => $request->cost_price,
            'description' => $request->description,
            'status' => $request->status
        );
        Product::whereId($id)->update($input_data);
        return redirect('/vendors/product')->with('success', 'Product Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findorfail($id);
        unlink(public_path('ProductImg/'.$product->product_img));
        $product->delete();
        return response()->json(['success' => 'Product Deleted Successfully!']);
    }
}
