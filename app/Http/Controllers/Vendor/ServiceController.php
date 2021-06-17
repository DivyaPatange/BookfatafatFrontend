<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Vendor\Service;
use Auth;
use App\Models\Admin\SubCategory;
use App\Models\Vendor\AvailableDate;

class ServiceController extends Controller
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
        $services = Service::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        if(request()->ajax()) {
            return datatables()->of($services)
            ->addColumn('service_img', function($row){    
                if(!empty($row->service_img)){
                    $imageUrl = asset('ServiceImg/' . $row->service_img);
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
            ->addColumn('sub_category_id', function($row){    
                $subCategory = SubCategory::where('id', $row->sub_category_id)->first();
                if(!empty($subCategory))
                {
                    return $subCategory->sub_category;
                }                                                                                                                                                                                                                                                                                      
            })
            ->addColumn('description', function($row){   
                if($row->description != Null)
                {
                    return $row->description;
                }
                else{
                    return "";
                }
            })
            ->addColumn('action', 'vendor.service.action')
            ->rawColumns(['action', 'service_img', 'category_id', 'sub_category_id'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 'Active')->get();
        return view('vendor.service.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service();
        $service->vendor_id = Auth::guard('vendor')->user()->id;
        $service->category_id = $request->category;
        $service->sub_category_id = $request->sub_category;
        $service->service_name = $request->service_name;
        $image = $request->file('service_img');
        // dd($request->file('photo'));
        if($image != '')
        {
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('ServiceImg'), $image_name);
            $service->service_img =$image_name;
        }
        $service->service_cost = $request->service_price;
        $service->quantity = $request->quantity;
        $service->description = $request->description;
        $service->save();
        return redirect('/vendors/service')->with('success', 'Service Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findorfail($id);
        $availableDate = AvailableDate::where('vendor_id', Auth::guard('vendor')->user()->id)->where('service_id', $id)->get();
        if(request()->ajax()) {
            return datatables()->of($availableDate)
            ->addColumn('total_quantity', function($row){    
                if($row->total_quantity != Null)
                {
                    return $row->total_quantity;
                }                               
                else{
                    return "";
                }                                                                                                                                                                                                                         
            })
            ->addColumn('remain_quantity', function($row){    
                if($row->remain_quantity != Null)
                {
                    return $row->remain_quantity;
                }                               
                else{
                    return "";
                }                                                                                                                                                                                                                                                                                       
            })
            ->addColumn('status', function($row){    
                if($row->status == "Available")
                {
                    return '<span class="badge badge-success">'.$row->status.'</span>';
                } 
                elseif($row->status == "Booked"){
                    return '<span class="badge badge-danger">'.$row->status.'</span>';
                } 
                else{
                    return '<span class="badge badge-warning">'.$row->status.'</span>';
                }                                                                                                                                                                                                                                                                                       
            })
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="delete" data-id="'.$row->id.'">
                            <i class="fas fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['action', 'total_quantity', 'remain_quantity', 'status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('vendor.service.show', compact('service', 'availableDate'));
    }

    public function getDate($id)
    {
        $availableDate = AvailableDate::where('vendor_id', Auth::guard('vendor')->user()->id)->where('service_id', $id)->pluck("available_date");
        return response()->json($availableDate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findorfail($id);
        $categories = Category::where('status', 'Active')->get();
        $subCategory = SubCategory::where('category_id', $service->category_id)->where('status', 'Active')->get();
        return view('vendor.service.edit', compact('categories', 'service', 'subCategory'));
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
        $service = Service::findorfail($id);
        $image_name = $request->hidden_image;
        $image = $request->file('service_img');
        if($image != '')
        {
            unlink(public_path('ServiceImg/'.$service->service_img));
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('ServiceImg'), $image_name);
        }

        $input_data = array (
            'sub_category_id' => $request->sub_category,
            'category_id' => $request->category,
            'service_name' => $request->service_name,
            'service_img' => $image_name,
            'service_cost' => $request->service_price,
            'quantity' => $request->quantity,
            'description' => $request->description,
        );
        Service::whereId($id)->update($input_data);
        return redirect('/vendors/service')->with('success', 'Service Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findorfail($id);
        unlink(public_path('ServiceImg/'.$service->service_img));
        $service->delete();
        return response()->json(['success' => 'Service Deleted Successfully!']);
    }

    public function storeAvailableDate(Request $request)
    {
        $availableDate = $request->date;
        $explodeDate = explode(",", $availableDate);
        for($i=0; $i < count($explodeDate); $i++)
        {
            $markDate = AvailableDate::create([
                'vendor_id' => Auth::guard('vendor')->user()->id,
                'service_id' => $request->service,
                'available_date' => date("Y-m-d", strtotime($explodeDate[$i])),
                'total_quantity' => $request->quantity,
                'remain_quanity' => $request->quantity,
                'status' => "Available",
            ]);
        }
        return response()->json(['success' => 'Dates Marked Successfully!']);
        // return count($explodeDate);
    }

    public function deleteAvailableDate($id)
    {
        $availableDate = AvailableDate::findorfail($id);
        $availableDate->delete();
        return response()->json(['success' => 'Date Deleted Successfully!']);
    }
}
