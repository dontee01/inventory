<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Supplier;
use App\Driver;
use App\Item;
use App\Cart_purchase;
use App\Pending_order;
use App\Purchase_log;

use DB;
use App\Libraries\Custom;

class PurchaseController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        $this->middleware('login');
    }

    public function index()
    {
        $suppliers = Supplier::all();
        $items = Item::all();
        $result = [];
        $result_cart = [];

        if (\Session::has('purchases_cart_session'))
        {
            $cart_session = \Session::get('purchases_cart_session');
            $orders = Cart_purchase::where('cart_session', $cart_session)
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
        return view('purchase', ['items' => $result, 'suppliers' => $suppliers, 'details' => [], 'cart_items' => $result_cart]);
    }



    public function populate($id)
    {
        $cust = $this->custom;
        $suppliers = Supplier::all();
        // $drivers = Driver::all();
        $item_details = Item::find($id);
        $items = Item::all();
        $result = [];
        $result_cart = [];
        // var_dump(session()->get('sales_cart_session'));exit;

        // populate cart array if sales cart exists
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

        return view('purchase', ['items' => $result, 'details' => $item_details, 
            'suppliers' => $suppliers, 'cart_items' => $result_cart]);
    }


    public function show_order($transaction_ref)
    {
        $cust = $this->custom;
        $orders = Pending_order::where('transaction_ref', $transaction_ref)
                ->where('is_confirmed', 1)
                ->get();
        $result = [];
        $total = 0;
        $d_name = '';
        foreach ($orders as $order)
        {
            $d_name = $order->d_name;
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

        if (count($result) != 0)
        {
            $print_session = $cust->generate_session('test@random.pos', $cust->time_now());
            \Session::put('print_session', $print_session);
        }

        
        return view('sales-process', ['orders' => $result, 'price_total' => $total, 'transaction_ref' => $transaction_ref, 'd_name' => $d_name]);
    }


    public function checkout(Request $request, $transaction_ref)
    {
        if (! session()->has('print_session'))
        {
            // redirect if print session does not exist
            $request->session()->flash('flash_message', 'No order to process');
            return redirect('/sales');
        }

        $orders = Pending_order::where('transaction_ref', $transaction_ref)
                ->where('is_confirmed', 1)
                ->get();
        $result = [];
        $total = 0;
        $d_name = '';
        foreach ($orders as $order)
        {
            $d_name = $order->d_name;
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

        // remove print session to avoid duplicate sales table update on page reload
        session()->forget('print_session');

        $request->session()->flash('flash_message_success', 'Sales Processed. Ensure to print this receipt before navigating away');
        return view('print-sales', ['cart_items' => $result, 'price_total' => $total, 'transaction_ref' => $transaction_ref, 'd_name' => $d_name]);
        // return redirect('/sales');
    }

    // ///////////////////INDIVIDUAL SALES/////////////////////


    public function individual()
    {
        $suppliers = Supplier::all();
        $items = Item::all();
        $result = [];
        $result_cart = [];

        if (\Session::has('purchases_cart_session'))
        {
            $cart_session = \Session::get('purchases_cart_session');
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
        return view('sales-direct', ['items' => $result, 'suppliers' => $suppliers, 'details' => [], 'cart_items' => $result_cart]);
    }


    public function populate($id)
    {
        $cust = $this->custom;
        $suppliers = Supplier::all();
        // $drivers = Driver::all();
        $item_details = Item::find($id);
        $items = Item::all();
        $result = [];
        $result_cart = [];
        // var_dump(session()->get('sales_cart_session'));exit;

        // populate cart array if sales cart exists
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
            'suppliers' => $suppliers, 'cart_items' => $result_cart]);
    }


    public function cart_show()
    {
        $result = [];
        if (session()->has('sales_cart_session'))
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
                $cat_name = Category::find($cart_item->categories_id)
                ->value('name');
                $item_name = $cat_name.' + '.$cart_item->i_name;
                $item_arr = [
                    'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                    'price_total' => $order->price_total, 'cart_session' => $order->cart_session
                ];
                array_push($result, $item_arr);
            }
        }
        else
        {
            // redirect if cart session does not exist
            $request->session()->flash('flash_message', 'Cart is empty');
            return redirect('/order');
        }

        return view('sales-cart', ['cart_items' => $result]);
    }


    public function cart_add(Request $request)
    {
        $cust = $this->custom;
        // $this->validate($request, [
        //     'category' => 'required',
        //     'item' => 'required|min:4',
        //     // 'is_rgb' => 'required',
        //     'qty' => 'numeric',
        //     'qty_bottle' => 'numeric',
        //     'qty_content' => 'numeric',
        //     'price' => 'required|numeric',
        // ]);
// dd($request);

        $cart = new Cart;
        $cart->sales_users_id = \Session::get('id');
        // $cart->i_name = strtoupper($request->item);
        $cart->item_id = $request->item_id;
        $cart->d_name = $request->driver;
        $cart->c_name = $request->customer;
        $cart->is_rgb = $request->is_rgb;
        $cart->price_unit = $request->price;
        $cart->price_total = $request->sub_total;
        $cart->transaction_ref = $request->transaction_ref;
      
        $cart->cart_session = \Session::get('sales_cart_session');

// var_dump($request->quantity_bottle);exit;
        if ($request->is_rgb == 1)
        {
            $cart->qty_content = $request->quantity_content;
            $cart->qty_bottle = $request->quantity_bottle;
            $cart->qty = $request->quantity;
// var_dump($cart);exit;
            $qty_content = Item::where('id', $request->item_id)
            ->value('qty_content');
            $item_check = $qty_content - $request->quantity;
            if ($item_check < 1)
            {
                $request->session()->flash('flash_message', 'Stock is too low for this transaction!!');
                return redirect()->back();
            }

            $item = Item::where('id', $request->item_id)
                ->decrement('qty_content', $request->quantity);
        }
        if ($request->is_rgb == 0)
        {
            $cart->qty = $request->quantity;

            $qty = Item::where('id', $request->item_id)
            ->value('qty');
            $item_check = $qty - $request->quantity;
            if ($item_check < 1)
            {
                $request->session()->flash('flash_message', 'Stock is too low for this transaction!!');
                return redirect()->back();
            }

            $item = Item::where('id', $request->item_id)
                ->decrement('qty', $request->quantity);
        }

        $cart->save();


        $request->session()->flash('flash_message_success', 'Item added to cart');
        return redirect()->back();
    }



    public function cart_checkout(Request $request)
    {
        if (!session()->has('sales_cart_session'))
        {
            // redirect if cart session does not exist
            $request->session()->flash('flash_message', 'Cart is empty');
            return redirect('/sales');
        }
        DB::transaction(function() use ($request)
        {
            $cart = Cart::where('cart_session', $request->sales_cart_session)
                ->update(['is_confirmed' => 1]);

            // $cart_order = Cart::find($id);
            $cart_orders = Cart::where('cart_session', $request->sales_cart_session)
            ->get();
            foreach ($cart_orders as $cart_order)
            {
                $p_order_data = [
                    'sales_users_id' => $cart_order->sales_users_id, 'item_id' => $cart_order->item_id,
                    'transaction_ref' => $cart_order->transaction_ref, 'd_name' => $cart_order->d_name,
                    'c_name' => $cart_order->c_name, 'is_rgb' => $cart_order->is_rgb, 'qty_content' => $cart_order->qty_content,
                    'qty_bottle' => $cart_order->qty_bottle, 'qty' => $cart_order->qty, 'returned_qty' => $cart_order->returned_qty,
                    'returned_bottle' => $cart_order->returned_bottle, 'price_unit' => $cart_order->price_unit,
                    'price_total' => $cart_order->price_total, 'is_confirmed' => 1
                ];

                $p_order = Pending_order::create($p_order_data);
                
            }


        });

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
                'id' => $order->id, 'i_name' => $item_name, 'd_name' => $order->d_name, 'qty' => $order->qty, 
                'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref
            ];
            array_push($result, $item_arr);
        }



        \Session::forget('sales_cart_session');
        \Session::forget('transaction_ref');
        return view('pending-sales', ['pending_orders' => $result]);

    }



    public function cart_delete(Request $request, $id)
    {
        DB::transaction(function() use ($id){

            $cart = Cart::find($id);
            if ($cart->is_rgb == 0)
            {
                $item = Item::where('id', $cart->item_id)
                    ->increment('qty', $cart->qty);
            }

            if ($cart->is_rgb == 1)
            {
                $item = Item::where('id', $cart->item_id)
                    ->increment('qty_content', $cart->qty);
            }

            Cart::destroy($id);

        });

        // var_dump($user);exit;
        $request->session()->flash('flash_message', 'Item Removed From Cart');
        // url()->current()
        return redirect()->back();
    }

}
