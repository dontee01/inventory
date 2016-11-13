<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Customer;
use App\Driver;
use App\Item;
use App\Pending_order;
use App\Sales_log;

use DB;
use App\Libraries\Custom;

class SalesController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        $this->middleware('login');
    }

    public function index()
    {
        $orders = Pending_order::where('is_confirmed', 1)
                ->groupBy('transaction_ref')
                ->get();
        $result = [];
        foreach ($orders as $order)
        {
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->value('name');
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref
            ];
            array_push($result, $item_arr);
        }

    	
        return view('pending-sales', ['pending_orders' => $result]);
    }

    public function show_order($transaction_ref)
    {
        $orders = Pending_order::where('transaction_ref', $transaction_ref)
                ->get();
        $result = [];
        $total = 0;
        foreach ($orders as $order)
        {
            $returned_qty = $order->returned_qty;
            $returned_bottle = $order->returned_bottle;
            if (empty($returned_qty))
            {
                $returned_qty = 0;
            }
            if (empty($returned_bottle))
            {
                $returned_bottle = 0;
            }

            if ($order->is_rgb == 0)
            {
                $quantity = $order->qty - $returned_qty;
            }
            if ($order->is_rgb == 1)
            {
                $quantity = $order->qty - $returned_qty;
            }
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->value('name');
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 'qty' => $quantity, 'd_name' => $order->d_name,
                'price_total' => $order->price_total, 'is_rgb' => $order->is_rgb, 'transaction_ref' => $order->transaction_ref
            ];
            $total += $order->price_total;
            array_push($result, $item_arr);
        }

        
        return view('sales-process', ['orders' => $result, 'price_total' => $total]);
    }


    public function checkout(Request $request, $transaction_ref)
    {
        DB::transaction(function() use ($transaction_ref, $request)
        {
            $sales = new Sales_log;
            $sales->users_id = $request->session()->get('id');
            $sales->d_name = $request->d_name;
            $sales->transaction_ref = $transaction_ref;
            $sales->total = $request->total;
            $sales->amount_paid = $request->amount;
            $sales->save();


            $data = [
                    'is_confirmed' => 2
                ];
            // update pending order table
            $orders_upd = Pending_order::where('transaction_ref', $transaction_ref)
                ->where('is_confirmed', 1)
                ->update($data);

        });

        $request->session()->flash('flash_message_success', 'Sales Processed');
        return redirect('/sales');
    }

    // ///////////////////INDIVIDUAL SALES/////////////////////


    public function individual()
    {
        $customers = Customer::all();
        $items = Item::all();
        $result = [];
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
        return view('sales-direct', ['items' => $result, 'customers' => $customers, 'details' => []]);
    }


    public function populate($id)
    {
        $cust = $this->custom;
        $customers = Customer::all();
        // $drivers = Driver::all();
        $item_details = Item::find($id);
        $items = Item::all();
        $result = [];
        $result_cart = [];

        if (\Session::has('sales_cart_session'))
        {
            $cart_session = \Session::get('sales_cart_session');
            $orders = Cart::where('cart_session', $cart_session)
                ->where('is_confirmed', 0)
                ->where('deleted', 0)
                ->get();
            foreach ($orders as $order)
            {
                // get categoriesId and item name using itemId from cart table
                $cart_item = Item::find($order->item_id);
                    // print_r($cart_item);exit;
                $cat_name = Category::find($cart_item->categories_id)
                ->value('name');
                $item_name = $cat_name.' + '.$cart_item->i_name;
                $item_arr = [
                    'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                    'price_total' => $order->price_total, 'cart_session' => $order->cart_session
                ];
                array_push($result_cart, $item_arr);
            }
        }
        
        if (! session()->has('sales_cart_session'))
        {
            \Session::put('sales_cart_session', time());
        }

        if (! session()->has('transaction_ref'))
        {
            $token_session = $cust->generate_session('test@random.pos', $cust->time_now());
            \Session::put('transaction_ref', $token_session);
        }

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
        // dd($item_details);

        return view('sales-direct', ['items' => $result, 'details' => $item_details, 
            'customers' => $customers, 'cart_items' => $result_cart]);
    }

}
