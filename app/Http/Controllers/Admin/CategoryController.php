<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategory = Category::orderBy('id', 'DESC')->get();
        if(request()->ajax()) {
            return datatables()->of($allCategory)
            ->addColumn('status', function($row){    
                if($row->status == "Active")
                {
                    return '<span class="badge badge-success">'.$row->status.'</span>';
                }  
                else{
                    return '<span class="badge badge-danger">'.$row->status.'</span>';
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('action', 'admin.category.action')
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.category.index');
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
        $category = new Category();
        $category->cat_name = $request->category;
        $category->status = $request->status;
        $category->save();
        return response()->json(['success' => 'Category Added Successfully!']);
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
        $category = Category::findorfail($id);
        $category->delete();
        return response()->json(['success' => 'Category Deleted Successfully!']);
    }

    public function getCategory(Request $request)
    {
        $category = Category::where('id', $request->bid)->first();
        if (!empty($category)) 
        {
            $data = array('id' =>$category->id, 'cat_name' =>$category->cat_name,'status' =>$category->status
            );
        }else{
            $data =0;
        }
        echo json_encode($data);
    }

    public function updateCategory(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        $input_data = array (
            'cat_name' => $request->category,
            'status' => $request->status,
        );

        Category::whereId($category->id)->update($input_data);
        return response()->json(['success' => 'Category Updated Successfully']);
    }
}
