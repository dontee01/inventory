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

        if (\Session::has('purchase_cart_session'))
        {
            $cart_session = \Session::get('purchase_cart_session');
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
        // var_dump(session()->get('purchase_cart_session'));exit;

        // populate cart array if sales cart exists
        if (\Session::has('purchase_cart_session'))
        {
            $cart_session = \Session::get('purchase_cart_session');
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
        
        if (! session()->has('purchase_cart_session'))
        {
            \Session::put('purchase_cart_session', time());
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



    public function cart_add(Request $request)
    {
        $cust = $this->custom;

        $cart = new Cart_purchase;
        $cart->store_users_id = \Session::get('id');
        // $cart->i_name = strtoupper($request->item);
        $cart->item_id = $request->item_id;
        $cart->s_name = $request->supplier;
        $cart->no_exchange = $request->purchase_type;
        $cart->is_rgb = $request->is_rgb;
        $cart->price_unit = $request->price;
        $cart->price_total = $request->sub_total;
        $cart->transaction_ref = $request->transaction_ref;
      
        $cart->cart_session = \Session::get('purchase_cart_session');
        

        DB::transaction(function() use ($request, $cart){
            $item_prc = Item::where('id', $request->item_id)
            ->first();

            if ($request->is_rgb == 1 && $request->purchase_type == 0)
            {
                // no-exchange<==>0
                // $qty_content = $item->qty_content + $request->quantity_content;
                $item = Item::where('id', $request->item_id)
                ->increment('qty_content', $request->quantity);
            }
            else if ($request->is_rgb == 1 && $request->purchase_type == 1)
            {
                // exchange-bottle<==>1
                $qty_content = $item_prc->qty_content + $request->quantity_content;
                $qty_bottle = $item_prc->qty_bottle - $request->quantity_bottle;

                if ($qty_bottle < 0)
                {
                    $request->session()->flash('flash_message', 'You need to purchase more empty bottles to perform this task');
                    redirect('/purchase');
                }

                // incease value of bottles with content
                $item = Item::where('id', $request->item_id)
                ->increment('qty_content', $request->quantity);
                // decrement empty bottle value
                $item = Item::where('id', $request->item_id)
                ->decrement('qty_bottle', $request->quantity);
            }
            else if ($request->is_rgb == 0)
            {
                // $quantity = $request->qty + $request->quantity;
                $item = Item::where('id', $request->item_id)
                ->increment('qty', $request->quantity);
            }
            $cart->qty = $request->quantity;
            $cart->save();


        });


        $request->session()->flash('flash_message_success', 'Item added to cart');
        return redirect()->back();
    }



    public function bottle_add(Request $request)
    {
        $cust = $this->custom;

        $cart = new Purchase_log;
        // $cart->store_users_id = \Session::get('id');
        // $cart->i_name = strtoupper($request->item);
        $cart->item_id = $request->item_id;
        $cart->s_name = $request->supplier;
        // $cart->no_exchange = $request->purchase_type;
        $cart->is_bottle = 1;
        $cart->is_rgb = 1;
        $cart->price_unit = $request->price;
        $cart->price_total = round($request->sub_total, 2);
        $cart->transaction_ref = $request->transaction_ref;
      
        // $cart->cart_session = \Session::get('purchase_cart_session');
        

        DB::transaction(function() use ($request, $cart){

                // no-exchange<==>0
                // $qty_content = $item->qty_content + $request->quantity_content;
            $item = Item::where('id', $request->item_id)
            ->increment('qty_bottle', $request->quantity);

            $cart->qty = $request->quantity;
            $cart->save();

        });

        \Session::forget('transaction_ref');

        $request->session()->flash('flash_message_success', 'Transaction successful');
        return redirect()->back();
    }

    public function bottle_show()
    {
        $cust = $this->custom;

        $suppliers = Supplier::all();
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
        return view('purchase-bottle', ['items' => $result, 'suppliers' => $suppliers, 'details' => [] ]);
    }


    public function cart_show()
    {
        $result = [];
        if (session()->has('purchase_cart_session'))
        {
            $cart_session = \Session::get('purchase_cart_session');
            $orders = Cart_purchase::where('cart_session', $cart_session)
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
            return redirect('/purchase');
        }

        return view('purchase-cart', ['cart_items' => $result]);
    }



    public function cart_checkout(Request $request)
    {
        $transaction_ref = $request->transaction_ref;

        // $orders = Cart_purchase::where('transaction_ref', $transaction_ref)
        //         ->get();
        //         var_dump($transaction_ref);
        //         print_r($orders);exit;
        if (!session()->has('purchase_cart_session'))
        {
            // redirect if cart session does not exist
            $request->session()->flash('flash_message', 'Cart is empty');
            return redirect('/purchase');
        }
        DB::transaction(function() use ($request)
        {

            // $cart_order = Cart::find($id);
            $cart_orders = Cart_purchase::where('cart_session', $request->purchase_cart_session)
            ->where('is_confirmed', 0)
            ->get();
            foreach ($cart_orders as $cart_order)
            {
                $p_order_data = [
                    'item_id' => $cart_order->item_id,
                    'transaction_ref' => $cart_order->transaction_ref, 's_name' => $cart_order->s_name,
                    'i_name' => $cart_order->i_name, 'is_rgb' => $cart_order->is_rgb, 'is_bottle' => $cart_order->is_bottle,
                    'qty_bottle' => $cart_order->qty_bottle, 'qty' => $cart_order->qty, 'no_exchange' => $cart_order->no_exchange,
                    'price_unit' => $cart_order->price_unit,
                    'price_total' => $cart_order->price_total, 'is_confirmed' => 1
                ];

                $p_order = Purchase_log::create($p_order_data);
                
            }
            $cart = Cart_purchase::where('cart_session', $request->purchase_cart_session)
                ->update(['is_confirmed' => 1]);


        });

        // $orders = Purchase_log::groupBy('transaction_ref')
        $orders = Cart_purchase::where('transaction_ref', $transaction_ref)
                ->get();
        $result = [];
        $total = 0;
        foreach ($orders as $order)
        {
            $total += $order->price_total;
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->value('name');
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 's_name' => $order->s_name, 'qty' => $order->qty, 
                'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref
            ];
            array_push($result, $item_arr);
        }



        \Session::forget('purchase_cart_session');
        \Session::forget('transaction_ref');
        $request->session()->flash('flash_message_success', 'Transaction successful');
        // redirect('/purchase');
        return view('print-purchase', ['cart_items' => $result, 'price_total' => $total, 'transaction_ref' => $transaction_ref]);
        // return view('purchase', ['pending_orders' => $result]);

    }




    public function cart_delete(Request $request, $id)
    {
        DB::transaction(function() use ($id){

            $cart = Cart_purchase::find($id);
            if ($cart->is_rgb == 0)
            {
                $item = Item::where('id', $cart->item_id)
                    ->decrement('qty', $cart->qty);
            }

            if ($cart->is_rgb == 1 && $cart->no_exchange == 1 )
            {

                $item = Item::where('id', $cart->item_id)
                ->decrement('qty_content', $cart->qty);

                $item = Item::where('id', $cart->item_id)
                ->increment('qty_bottle', $cart->qty);
            }

            if ($cart->is_rgb == 1 && $cart->no_exchange == 0 )
            {
                $item = Item::where('id', $cart->item_id)
                    ->decrement('qty_content', $cart->qty);
            }

            Cart_purchase::destroy($id);

        });

        // var_dump($user);exit;
        $request->session()->flash('flash_message', 'Item Removed From Cart');
        // url()->current()
        return redirect()->back();
    }

}
