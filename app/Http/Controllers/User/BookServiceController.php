<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Service;
use DB;
use DateTime;
use App\Models\User\BookService;
use App\Models\User\ServiceOrder;
use App\Models\User\UserInfo;
use App\Models\Vendor\AvailableDate;
use Auth;
use App\Models\User\ServicePayment;
use App\Models\User;

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
        $availableDate = AvailableDate::where('id', $request->available_date_id)->first();
        $timeSlot = DB::table('service_time_slots')->where('id', $request->time_slot)->first();
        $bookService = new BookService();
        $bookService->user_id = Auth::user()->id;
        $bookService->date = $request->available_date;
        $bookService->available_date_id = $request->available_date_id;
        $bookService->start_time = $timeSlot->from_time;
        $bookService->end_time = $timeSlot->to_time;
        $bookService->time_slot_id = $request->time_slot;
        $bookService->vendor_id = $availableDate->vendor_id;
        $bookService->service_id = $availableDate->service_id; 
        $bookService->save();

        $service = Service::where('id', $availableDate->service_id)->first();
        $order = ServiceOrder::forceCreate([
            'order_number'      =>  'ORD-'.strtoupper(uniqid()),
            'user_id'           =>  auth()->user()->id,
            'vendor_id'         =>  $availableDate->vendor_id,
            'service_id'        => $availableDate->service_id,
            'status'            =>  'pending',
            'grand_total'       =>  $service->service_cost,
            'payment_status'    =>  "Pending",
            'name'        =>  auth()->user()->name,
            'mobile_no'      =>  auth()->user()->mobile_no,
        ]);
        return redirect()->route('service.details', $order->id)->with('success', "Service Booked Successfully!");
    }

    public function payment(Request $request, $id)
    {
        $order = ServiceOrder::findorfail($id);
        $user = User::where('id', $order->user_id)->first();
        $userInfo = UserInfo::where('user_id', $order->user_id)->first();
        $salt = 'fa015f0c77b1897dc7daa9afc62171e530f35595'; //Pass your SALT here

        $data = array(
            'api_key' => '6e6d70d0-a3ec-4a8f-96ed-4e87b41da7c3',
            'order_id' => $order->order_number,
            'mode' => 'TEST',
            'amount' => $order->grand_total,
            'currency' => 'INR',
            'description' => 'Service Payment',
            'name' => $order->name,
            'email' => $user->email,
            'phone' => $userInfo->mobile_no,
            'city' => $userInfo->city,
            'country' => $userInfo->country, 
            'zip_code' => $userInfo->pin_code,
            'return_url' => url('/service-payment-success') 
        );
        $data['hash'] = $this->generateHash($data,$salt);
        $payment_url = 'https://biz.aggrepaypayments.com/v2/paymentrequest';
        ?>
            <html>
            <body OnLoad="OnLoadEvent();">
            <form name="form1" action="<?php echo $payment_url; ?>" method="post">
                <?php foreach ($data as $key => $value) {
                    echo '<input type="hidden" value="' . $value . '" name="' . $key . '"/>';
                } ?>
            </form>
            <script language="JavaScript">
                function OnLoadEvent() {
                    document.form1.submit();
                }
            </script>
            </body>
            </html>
        <?php
    }

    public function generateHash($input,$salt)
    {

        /* Columns used for generating the hash value */
        $hash_columns = [
            'address_line_1',
            'address_line_2',
            'amount',
            'api_key',
            'city',
            'country',
            'currency',
            'description',
            'email',
            'mode',
            'name',
            'order_id',
            'phone',
            'return_url',
            'state',
            'udf1',
            'udf2',
            'udf3',
            'udf4',
            'udf5',
            'zip_code',
        ];

        /*Sort the array before hashing*/
        ksort($hash_columns);

        /*Create a | (pipe) separated string of all the $input values which are available in $hash_columns*/
        $hash_data = $salt;
        foreach ($hash_columns as $column) {
            if (isset($input[$column])) {
                if (strlen($input[$column]) > 0) {
                    $hash_data .= '|' . $input[$column];
                }
            }
        }

        /* Convert the $hash_data to Upper Case and then use SHA512 to generate hash key */
        $hash = null;
        if (strlen($hash_data) > 0) {
            $hash = strtoupper(hash("sha512", $hash_data));
        }

        return $hash;

    }

    public function servicePaymentSuccess(Request $request)
    {
        $order = ServiceOrder::where('order_number', $request->order_id)->first();
       
        $payment = new ServicePayment();
        $payment->order_id = $order->id;
        $payment->name = $request->name;
        $payment->email = $request->email;
        $payment->transaction_id = $request->transaction_id;
        $payment->payment_mode = $request->payment_mode;
        $payment->payment_channel = $request->payment_channel;
        $payment->payment_datetime = $request->payment_datetime;
        $payment->response_message = $request->response_message;
        $payment->save();

        if($request->response_message == "Transaction successful")
        {
            $message = "Completed";
        }
        else{
            $message = "Pending";
        }

        $order = ServiceOrder::where('order_number', $request->order_id)->update(['payment_status' => $message]);
        return redirect()->route('service-payment-success', $payment->id);
    }

    public function paymentDetail($id)
    {
        $paymentDetail = ServicePayment::findorfail($id);
        return view('user.service-success', compact('paymentDetail'));
    }

    public function serviceDetails($id)
    {
        $order = ServiceOrder::findorfail($id);
        $userInfo = UserInfo::where('user_id', $order->user_id)->first();
        return view('user.book-service.serviceDetails', compact('order', 'userInfo'));
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
                '<td><div class="demo-checkbox"><input type="checkbox" name="time_slot" class="filled-in" value="'.$t->id.'"></div></td>'.
            '</tr>';
        }
        $data = array('time_slot' => $output, 'available_date_id' => $availableDate->id, 'available_date' => $availableDate->available_date);
        echo json_encode($data);
    }

    public function getBookedService()
    {
        $order = ServiceOrder::where('user_id', Auth::user()->id)->get();
        if(request()->ajax())
        {
            return datatables()->of($order)
            ->addColumn('payment_status', function($row){
                $payment = ServicePayment::where('order_id', $row->id)->first();
                if(!empty($payment))
                {
                    return '<span class="badge bg-teal">Paid</span>';
                }
                else{
                    return '<span class="badge bg-pink">Not Paid</span>';
                }
            })
            ->addColumn('service_name', function($row){
                $service = Service::where('id', $row->service_id)->first();
                if(!empty($service)){
                    return $service->service_name;
                }
            })
            ->rawColumns(['payment_status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('user.book-service');
    }
}
