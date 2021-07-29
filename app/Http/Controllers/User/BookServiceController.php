<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Service;
use DB;
use DateTime;
use App\Models\User\BookService;

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
        $timeSlot = $request->time_slot;
        $explodeSlot = explode(",", $timeSlot);
        for($i=0; $i < count($explodeSlot); $i++)
        {
            $bookService = new BookService();
            // $bookService->user_id = 
        }
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
            $availableDate1 = DB::table('available_dates')->where('service_id', $request->service_id)->where('status', 'Available');
            if(!empty($request->start_date)){
                $availableDate1 = $availableDate1->where('available_date', '>=', $request->start_date);
            }
            if(!empty($request->end_date))
            {
                $availableDate1 = $availableDate1->where('available_date', '<=', $request->end_date);
            }
            $availableDate = $availableDate1->orderBy('id', 'DESC')->get();
            return datatables()->of($availableDate)
            ->addColumn('available_time', function($row){  
                $availableTime = DB::table('service_time_slots')->where('available_date_id', $row->id)->where('time_status', 'Available')->get();  
                $output = '';
                $output .= '<ul>';
                foreach($availableTime as $a)
                {
                    $output .= '<li>Start Time:- '.date('h:i A', strtotime($a->from_time)).' End Time:- '.date('h:i A', strtotime($a->to_time)).'</li>';
                }
                $output .= '</ul>';
                return $output;
            })
            ->addColumn('duration', function($row){    
                $availableTime = DB::table('service_time_slots')->where('available_date_id', $row->id)->where('time_status', 'Available')->get();  
                $output = '';
                $output .= '<ul>';
                foreach($availableTime as $a)
                {
                    $date1 = date("Y-m-d h:i:s A", strtotime($row->available_date.' '.$a->from_time));
                    $date2 = date("Y-m-d h:i:s A", strtotime($row->available_date.' '.$a->to_time));
                    $datetime1 = new DateTime($date1);
                    // return $datetime1;
                    $datetime2 = new DateTime($date2);
                    $interval = $datetime1->diff($datetime2);
                    $interval->format('%h')." Hours ".$interval->format('%i')." Minutes";
                    $output .= '<li>'.$interval->format('%h')." Hours ".$interval->format('%i')." Minutes".'</li>';
                }
                $output .= '</ul>';
                return $output;                                                                                                                                                                                                                                                                                      
            }) 
            ->addColumn('action', function($row){
                return '<button type="button" class="btn bg-red waves-effect" onclick="ServiceModel(this, '.$row->id.')">Book Now</button>';
            })
            ->rawColumns(['available_date', 'action', 'available_time', 'duration'])
            ->addIndexColumn()
            ->make(true);
        }
    }

    public function getBookService(Request $request)
    {
        $availableDate = DB::table('available_dates')->where('id', $request->bid)->first();
        $timeSlot = DB::table('service_time_slots')->where('available_date_id', $availableDate->id)->get();
        $output = '';
        foreach($timeSlot as $t)
        {
            $output .= '<tr>'.
                '<td>'.date('h:i A', strtotime($t->from_time)).'</td>'.
                '<td>'.date('h:i A', strtotime($t->to_time)).'</td>'. 
                '<td><div class="demo-checkbox"><input type="checkbox" name="time_slot[]" class="filled-in" value="'.$t->id.'"></div></td>'.
            '</tr>';
        }
        $data = array('time_slot' => $output, 'available_date_id' => $availableDate->id, 'available_date' => $availableDate->available_date);
        echo json_encode($data);
    }
}
