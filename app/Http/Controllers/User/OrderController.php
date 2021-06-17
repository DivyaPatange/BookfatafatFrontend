<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Admin\Product;
use App\Models\User;
use App\Models\Payment;
use App\Models\User\UserInfo;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function placedOrder(Request $request)
    {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();
        // dd($user);
        $total = \Cart::getSubTotal() + 49;
        // dd($total);
        $order = Order::create([
            'order_number'      =>  'ORD-'.strtoupper(uniqid()),
            'user_id'           => auth()->user()->id,
            'status'            =>  'pending',
            'grand_total'       =>  $total,
            'item_count'        =>  \Cart::getTotalQuantity(),
            'payment_status'    =>  0,
            'name'        =>  auth()->user()->name,
            'mobile_no'      =>  $user->mobile_no,
        ]);
    
        if ($order) {
    
            $items = \Cart::getContent();
    
            foreach ($items as $item)
            {
                // A better way will be to bring the product id with the cart items
                // you can explore the package documentation to send product id with the cart
                $product = Product::where('product_name', $item->name)->first();
    
                $orderItem = new OrderItem([
                    'product_id'    =>  $product->id,
                    'quantity'      =>  $item->quantity,
                    'price'         =>  $item->getPriceSum()
                ]);
    
                $order->items()->save($orderItem);
                \Cart::clear();
            }
        }
        // $data["email"] = "divyapatange0@gmail.com";
        // $data["title"] = "Order Placed";
        // $order1 = DB::table('orders')->where('id', $order->id)->first();
        // $orderArray = (array)$order1;
        // // dd($orderArray);
        // Mail::send('email.orderPlace', $orderArray, function($message)use($data) {
        //     $message->to($data["email"], $data["email"])
        //             ->subject($data["title"]);
            
        // });
        return redirect()->route('order.details', $order->id)->with('success', "Order Placed Successfully!");
    }

    public function orderDetails($id){
        $order = Order::findorfail($id);
        $orderItems = OrderItem::where('order_id', $id)->get();
        $userInfo = UserInfo::where('user_id', $order->user_id)->first();
        return view('user.order.index', compact('order', 'orderItems', 'userInfo'));
    }

    public function storeUserInfo(Request $request)
    {
        $userInfo = UserInfo::where('user_id', Auth::user()->id)->first();
        if(empty($userInfo))
        {
            $userInfo = new UserInfo();
            $userInfo->country = $request->country;
            $userInfo->fullname = $request->fullname;
            $userInfo->mobile_no = $request->mobile_no;
            $userInfo->address = $request->address;
            $userInfo->city = $request->city;
            $userInfo->pin_code = $request->pin_code;
            $userInfo->user_id = Auth::user()->id;
            $userInfo->save();
            return response()->json(['success' => 'Address Details are Saved!']);
        }
        else{
            $input_data = array (
                'country' => $request->country,
                'fullname' => $request->fullname,
                'mobile_no' => $request->mobile_no,
                'address' => $request->address,
                'city' => $request->city,
                'pin_code' => $request->pin_code,
            );
    
            UserInfo::whereId($userInfo->id)->update($input_data);
            return response()->json(['success' => 'Address Details Updated Successfully!']);
        }
    }

    public function payment(Request $request, $id)
    {
        $order = Order::findorfail($id);
        $user = User::where('id', $order->user_id)->first();
        $userInfo = UserInfo::where('user_id', $order->user_id)->first();
        $salt = 'fa015f0c77b1897dc7daa9afc62171e530f35595'; //Pass your SALT here

        $data = array(
            'api_key' => '6e6d70d0-a3ec-4a8f-96ed-4e87b41da7c3',
            'order_id' => $order->order_number,
            'mode' => 'TEST',
            'amount' => $order->grand_total,
            'currency' => 'INR',
            'description' => 'Product Payment',
            'name' => $order->name,
            'email' => $user->email,
            'phone' => $userInfo->mobile_no,
            'city' => $userInfo->city,
            'country' => $userInfo->country, 
            'zip_code' => $userInfo->pin_code,
            'return_url' => url('/success') 
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

    public function paymentSuccess(Request $request)
    {
        $order = Order::where('order_number', $request->order_id)->first();
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->name = $request->name;
        $payment->email = $request->email;
        $payment->transaction_id = $request->transaction_id;
        $payment->payment_mode = $request->payment_mode;
        $payment->payment_channel = $request->payment_channel;
        $payment->payment_datetime = $request->payment_datetime;
        $payment->response_message = $request->response_message;
        $payment->save();

        return redirect()->route('payment-success', $payment->id);
    }

    public function paymentDetail($id)
    {
        $paymentDetail = Payment::findorfail($id);
        return view('user.success', compact('paymentDetail'));
    }

    public function placedOrderDetails()
    {
        $order = Order::where('user_id', Auth::user()->id)->get();
        if(request()->ajax())
        {
            return datatables()->of($order)
            ->addColumn('payment_status', function($row){
                $payment = Payment::where('order_id', $row->id)->first();
                if(!empty($payment))
                {
                    return '<span class="badge bg-teal">Paid</span>';
                }
                else{
                    return '<span class="badge bg-pink">Not Paid</span>';
                }
            })
            ->rawColumns(['payment_status'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('user.placed-order');
    }

    public function userPaymentDetails()
    {
        $payment = DB::table('payments')->join('orders','orders.id', '=', 'payments.order_id')
                    ->join('users','users.id', '=', 'orders.user_id')
                    ->where('users.id', Auth::user()->id)
                    ->select('payments.*')
                    ->get();
        if(request()->ajax())
        {
            return datatables()->of($payment)
            ->addColumn('payment_date', function($row){
                return date('d-m-Y', strtotime($row->payment_datetime));
            })
            ->rawColumns(['payment_date'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('user.payment-detail');
    }
}
