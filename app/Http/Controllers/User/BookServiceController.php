<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Service;
use DB;

class BookServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('user.book-service.index', compact('services'));
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
        $service = Service::findorfail($id);
        return view('user.book-service.show', compact('service'));
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

    public function searchAvailableDate(Request $request)
    {
        if(request()->ajax()) {
            $availableDate1 = DB::table('available_dates')->where('status', 'Available');
            if(!empty($request->start_date)){
                $availableDate1 = $availableDate1->where('available_date', '>=', $request->start_date);
            }
            if(!empty($request->end_date))
            {
                $availableDate1 = $availableDate1->where('available_date', '<=', $request->end_date);
            }
            if(!empty($request->start_time))
            {
                $payment1 = $payment1->where('student_id', $request->student);
            }
            if(!empty($request->date_from) && !empty($request->date_to)){
                $payment1 = $payment1->whereBetween('payment_date', [date("Y-m-d", strtotime($request->date_from)), date("Y-m-d", strtotime($request->date_to))]);
            }
            $payment = $payment1->orderBy('id', 'DESC')->get();
            return datatables()->of($payment)
            ->addColumn('student_name', function($row){    
                $student = Student::where('id', $row->student_id)->first();
                if(!empty($student))
                {
                    return $student->student_name;
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('class', function($row){    
                $student = Student::where('id', $row->student_id)->first();
                if(!empty($student))
                {
                    $class = Classes::where('id', $student->class_id)->first();
                    if(!empty($class))
                    {
                        return $class->class_name;
                    }
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('section', function($row){    
                $student = Student::where('id', $row->student_id)->first();
                if(!empty($student))
                {
                    $section = Section::where('id', $student->section_id)->first();
                    if(!empty($section))
                    {
                        return $section->section_name;
                    }
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('roll_no', function($row){    
                $student = Student::where('id', $row->student_id)->first();
                if(!empty($student))
                {
                   return $student->roll_no;
                }                                                                                                                                                                                                                                                                                              
            })
            ->addColumn('payment_method_no', function($row){    
                if($row->payment_method_no != null)
                {
                    return $row->payment_method_no;
                }                                                                                                                                                                                                                                                                                             
            })
            ->addColumn('action', 'admin.payment.action')
            ->rawColumns(['student_name', 'action', 'payment_method_no'])
            ->addIndexColumn()
            ->make(true);
        }
    }
}
