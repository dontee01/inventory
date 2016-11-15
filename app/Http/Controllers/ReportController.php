<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;
use App\Customer;
use App\Supplier;
use App\Driver;
use App\Item;
use App\Cart;
use App\Pending_order;
use App\Sales_log;
use App\Purchase_log;
use App\Bottle_sale;
use App\Bottle_debtor;

use DB;
use App\Libraries\Custom;

class ReportController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        $this->middleware('login');
    }

    public function index()
    {
        return view('report');
    }


    public function report(Request $request)
    {
        $cust = $this->custom;
        
        $from = $request->from;
        $to = $request->to;
        $report_type = $request->report_type;

        $from = $cust->format_date($from);
        $to = $cust->format_date($to);
        // var_dump($from);exit;

        if ($report_type == 'sales')
        {
            // DB::transaction(function() use ($request, $from, $to)
            // {
                $data = [$from, $to];
                $orders = Pending_order::whereBetween('updated_at', $data)
                // ->where('is_confirmed', 2)
                ->get();
                $result = [];
                $total = 0;
                foreach ($orders as $order)
                {
                    $total += $order->price_total;
                    $quantity = $order->qty;
                    $returned_qty = $order->returned_qty;
                    if (empty($returned_qty))
                    {
                        $returned_qty = 0;
                    }
                    $quantity = $quantity - $returned_qty;

                    if ($order->is_rgb == 1)
                    {
                        $quantity = $order->qty - $returned_qty;
                    }

                    // if ($order->is_rgb == 1 && $order->d_name == 'Individual')
                    // {
                    //     $quantity = $order->qty_content;
                    // }
                    // get categoriesId and item name using itemId from cart table
                    $cart_item = Item::find($order->item_id);
                        // var_dump(session()->get('sales_cart_session'));exit;
                    $cat_name = Category::find($cart_item->categories_id)
                    ->value('name');
                    $item_name = $cat_name.'  '.$cart_item->i_name;
                    $item_arr = [
                        'id' => $order->id, 'i_name' => $item_name, 'd_name' => $order->d_name, 'qty' => $quantity, 
                        'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref, 
                        'created' => $order->updated_at, 'price_unit' => $order->price_unit
                    ];
                    array_push($result, $item_arr);
                }

                $bottle_orders = Bottle_sale::whereBetween('updated_at', $data)
                // ->where('is_confirmed', 2)
                ->get();
                $result_bottle = [];
                $total_bottle = 0;
                foreach ($bottle_orders as $order)
                {
                    $total_bottle += $order->price_total;
                    $quantity = $order->qty_bottle_content;
                    $quantity = $quantity - $returned_qty;


                    // if ($order->is_rgb == 1 && $order->d_name == 'Individual')
                    // {
                    //     $quantity = $order->qty_content;
                    // }
                    // get categoriesId and item name using itemId from cart table
                    $cart_item = Item::find($order->item_id);
                        // var_dump(session()->get('sales_cart_session'));exit;
                    $cat_name = Category::find($cart_item->categories_id)
                    ->value('name');
                    $item_name = $cat_name.'  '.$cart_item->i_name;
                    $item_arr = [
                        'id' => $order->id, 'i_name' => $item_name, 'd_name' => $order->d_name, 'qty' => $quantity, 
                        'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref, 
                        'created' => $order->updated_at, 'price_unit' => $order->price_unit, 'comment' => $order->comment
                    ];
                    array_push($result_bottle, $item_arr);
                }
            // });
        return view('report-sales', ['items' => $result, 'bottle_orders' => $result_bottle, 'price_total' => number_format($total, 2), 'price_total_bottle' => number_format($total_bottle, 2) ]);
        }

        else if ($report_type == 'purchases')
        {
                $data = [$from, $to];
                $orders = Purchase_log::whereBetween('updated_at', $data)
                ->get();
                $result = [];
                $total = 0;
                foreach ($orders as $order)
                {
                    $total += $order->price_total;
                    if ($order->no_exchange == 1)
                    {
                        $exchange_type = 'Bottle Exchange';
                    }
                    if ($order->no_exchange == 0)
                    {
                        $exchange_type = 'No Exchange';
                    }

                    // if ($order->is_rgb == 1 && $order->d_name == 'Individual')
                    // {
                    //     $quantity = $order->qty_content;
                    // }
                    // get categoriesId and item name using itemId from cart table
                    $cart_item = Item::find($order->item_id);
                        // var_dump(session()->get('sales_cart_session'));exit;
                    $cat_name = Category::find($cart_item->categories_id)
                    ->value('name');
                    $item_name = $cat_name.'  '.$cart_item->i_name;
                    $item_arr = [
                        'id' => $order->id, 'i_name' => $item_name, 's_name' => $order->s_name, 'qty' => $order->qty, 
                        'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref, 
                        'exchange_type' => $exchange_type, 'created' => $order->updated_at, 
                        'price_unit' => $order->price_unit
                    ];
                    array_push($result, $item_arr);
                }
        return view('report-purchase', ['items' => $result, 'price_total' => number_format($total, 2)]);
        }


        else if ($report_type == 'bottle-log')
        {
                $data = [$from, $to];
                $orders = Bottle_debtor::whereBetween('updated_at', $data)
                ->get();
                $result = [];
                $total = 0;
                foreach ($orders as $order)
                {
                    $total += $order->amount_paid;
                    if ($order->no_exchange == 1)
                    {
                        $exchange_type = 'Bottle Exchange';
                    }
                    if ($order->no_exchange == 0)
                    {
                        $exchange_type = 'No Exchange';
                    }

                    // if ($order->is_rgb == 1 && $order->d_name == 'Individual')
                    // {
                    //     $quantity = $order->qty_content;
                    // }
                    // get categoriesId and item name using itemId from cart table
                    $cart_item = Item::find($order->item_id);
                        // var_dump(session()->get('sales_cart_session'));exit;
                    $cat_name = Category::find($cart_item->categories_id)
                    ->value('name');
                    $item_name = $cat_name.'  '.$cart_item->i_name;
                    $item_arr = [
                        'id' => $order->id, 'i_name' => $item_name, 'error_type' => $order->error_type, 
                        'qty' => $order->qty_bottle, 'amount_paid' => $order->amount_paid, 'd_name' => $order->d_name, 
                        'transaction_ref' => $order->transaction_ref, 'created' => $order->updated_at, 'comment' => $order->comment
                    ];
                    array_push($result, $item_arr);
                }
        return view('report-bottle', ['items' => $result, 'amount_total' => $total]);
        }

        else if ($report_type == 'stock')
        {
                $data = [$from, $to];
                $orders = Item::all();
                $result = [];
                $total = 0;
                foreach ($orders as $order)
                {

                    if ($order->is_rgb == 1)
                    {
                        $amount = $order->qty_content * $order->price_unit;
                    }

                    if ($order->is_rgb == 0)
                    {
                        $amount = $order->qty * $order->price_unit;
                    }
                    $total += $amount;
                    // get categoriesId and item name using itemId from cart table
                    // $cart_item = Item::find($order->item_id);
                        // var_dump(session()->get('sales_cart_session'));exit;
                    $cat_name = Category::find($order->categories_id)
                    ->value('name');
                    $item_name = $cat_name.'  '.$order->i_name;
                    $item_arr = [
                        'id' => $order->id, 'i_name' => $item_name, 'qty_content' => $order->qty_content, 
                        'qty_bottle' => $order->qty_bottle, 'qty' => $order->qty, 'amount' => number_format($amount, 2), 
                        'is_rgb' => $order->is_rgb, 'created' => $order->updated_at
                    ];
                    array_push($result, $item_arr);
                }
                $categories = Category::all();
                $result_all = [];
                // $res_arr = [];
                // $total_item = 0;
                $total_item_rgb = 0;
                foreach ($categories as $category)
                {
                    $rgb = 0;
                    $items = Item::where('categories_id', $category->id)
                    ->get();

                    foreach ($items as $item)
                    {
                        if ($item->is_rgb == 1)
                        {
                            $rgb = 1;
                            $total_item_rgb += $item->qty_content + $item->qty_bottle;
                        }
                    }
// print_r($rgb);exit;
                    if ($rgb == 1)
                    {
                        $total_item_rgb = $cust->get_empty_bottle_info($total_item_rgb);
                        $amount_total = round(($total_item_rgb * 1200), 2);
                        $item_arr = [
                            'cat_id' => $category->id, 'cat_name' => $category->name, 'total_rgb' => $total_item_rgb, 
                            'amount_total' => number_format($amount_total, 2)
                        ];
                        array_push($result_all, $item_arr);
                    }
                }
        return view('report-stock', ['items' => $result, 'amount_total' => number_format($total, 2), 'categories' => $result_all]);
        }

    }
    
    public function bottle_show()
    {
        $cust = $this->custom;
        
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $drivers = Driver::all();
        $items = Item::all();
        $result = [];
        $result_cart = [];

        foreach ($items as $item)
        {
            $cat_name = Category::find($item->categories_id)
            ->value('name');
            $item_name = $cat_name.' + '.$item->i_name;
            $item_arr = [
                'id' => $item->id, 'i_name' => $item_name
            ];
            array_push($result, $item_arr);
        }

        $token_session = $cust->generate_session('test@random.pos', $cust->time_now());
        \Session::put('transaction_ref', $token_session);
        return view('bottle-log', ['items' => $result, 'suppliers' => $suppliers, 'customers' => $customers, 'drivers' => $drivers, 'details' => [] ]);
    }


    public function bottle_log(Request $request)
    {
        $cust = $this->custom;

        $cart = new Bottle_debtor;
        $cart->users_id = \Session::get('id');
        // $cart->i_name = strtoupper($request->item);
        $cart->item_id = $request->item_id;
        $cart->error_type = $request->type;
        $cart->d_name = $request->driver;
        $cart->comment = $request->comment;
        $cart->is_rgb_content = $request->is_rgb_content;
        // $cart->price_unit = $request->price;
        $cart->amount_paid = round($request->amount_paid, 2);
        $cart->transaction_ref = $request->transaction_ref;
      
        // $cart->cart_session = \Session::get('purchase_cart_session');
        
        DB::transaction(function() use ($request, $cart, $cust){
        	$quantity = $cust->get_empty_bottle_val($request->quantity);
                // no-exchange<==>0
                // $qty_content = $item->qty_content + $request->quantity_content;
        	if (!empty($request->is_rgb_content) )
        	{
	            $item = Item::where('id', $request->item_id)
	            ->decrement('qty_content', $quantity);
        	}
        	else if (empty($request->is_rgb_content))
        	{
	            $item = Item::where('id', $request->item_id)
	            ->decrement('qty_bottle', $quantity);
        	}

            $cart->qty_bottle = $request->quantity;
            $cart->save();

        });

        \Session::forget('transaction_ref');

        $request->session()->flash('flash_message_success', 'Transaction successful');
        return redirect()->back();
    }

}
