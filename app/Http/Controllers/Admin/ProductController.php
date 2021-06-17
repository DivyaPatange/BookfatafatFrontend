<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Vendor;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Category;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vendors = Vendor::orderBy('id', 'DESC')->get();
        $categories = Category::where('status', 'Active')->get();
        if(request()->ajax()) {
            $product1 = DB::table('products');
            if(!empty($request->vendor)){
                $product1 = $product1->where('vendor_id', $request->vendor);
            }
            if(!empty($request->status))
            {
                $product1 = $product1->where('status', $request->status);
            }
            if(!empty($request->category))
            {
                $product1 = $product1->where('category_id', $request->category);
            }
            $products = $product1->orderBy('id', 'DESC')->get();
            return datatables()->of($products)
            ->addColumn('product_img', function($row){    
                if(!empty($row->product_img)){
                    $imageUrl = asset('ProductImg/' . $row->product_img);
                    return '<img src="'.$imageUrl.'" width="50px">';
                }                                                                                                                                                                                                                                                                                                 
            })
            ->addColumn('vendor_id', function($row){    
                $vendor = Vendor::where('id', $row->vendor_id)->first();
                if(!empty($vendor))
                {
                    return $vendor->business_owner_name;
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
            ->addColumn('category_id', function($row){    
                $category = Category::where('id', $row->category_id)->first();
                if(!empty($category))
                {
                   return $category->cat_name;
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('sub_category_id', function($row){    
                $subCategory = SubCategory::where('id', $row->sub_category_id)->first();
                if(!empty($subCategory))
                {
                   return $subCategory->sub_category;
                }                                                                                                                                                                                                                                                                                       
            })
            ->rawColumns(['product_img', 'vendor_id', 'status', 'category_id'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.product.index', compact('vendors', 'categories'));
    }

    public function getCategoryList(Request $request)
    {
        $category = Category::where("service_id", $request->service_id)->where('status', 1)
        ->pluck("cat_name","id");
        return response()->json($category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
