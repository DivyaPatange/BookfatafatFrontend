<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('status', 'Active')->orderBy('id', 'DESC')->get();
        $subCategory = SubCategory::orderBy('id', 'DESC')->get();
        if(request()->ajax()) {
            return datatables()->of($subCategory)
            ->addColumn('category_id', function($row){ 
                $category = Category::where('id', $row->category_id)->first();
                if(!empty($category))
                {
                    return $category->cat_name;
                }
            })
            ->addColumn('status', function($row){    
                if($row->status == "Active")
                {
                    return '<span class="badge badge-success">'.$row->status.'</span>';
                }  
                else{
                    return '<span class="badge badge-danger">'.$row->status.'</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('action', 'admin.sub-category.action')
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.sub-category.index', compact('categories'));
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
        $subCategory = new SubCategory();
        $subCategory->category_id = $request->category;
        $subCategory->sub_category = $request->sub_category;
        $subCategory->status = $request->status;
        $subCategory->save();
        return response()->json(['success' => 'Sub-Category Added Successfully!']);
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
        $subCategory = SubCategory::findorfail($id);
        $subCategory->delete();
        return response()->json(['success' => 'Sub-Category Deleted Successfully!']);
    }

    public function getSubCategory(Request $request)
    {
        $subCategory = SubCategory::where('id', $request->bid)->first();
        if (!empty($subCategory)) 
        {
            $data = array('id' =>$subCategory->id, 'category_id' =>$subCategory->category_id,'status' =>$subCategory->status, 'sub_category' => $subCategory->sub_category
            );
        }else{
            $data =0;
        }
        echo json_encode($data);
    }

    public function updateSubCategory(Request $request)
    {
        $subCategory = SubCategory::where('id', $request->id)->first();
        $input_data = array (
            'category_id' => $request->category,
            'sub_category' => $request->sub_category,
            'status' => $request->status,
        );

        SubCategory::whereId($subCategory->id)->update($input_data);
        return response()->json(['success' => 'Sub-Category Updated Successfully']);
    }
}
