<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;
use App\Customer;
use App\Supplier;
use App\Driver;
use App\Item;
use App\Bottle_debtor;

use DB;
use App\Libraries\Custom;

class BottleController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        $this->middleware('login');
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
