<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Customer;
use App\Item;
use App\Cart;

use DB;
use App\Libraries\Custom;

class CartController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
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
        // print_r($categories);exit;
        return view('order', ['items' => $result, 'customers' => $customers]);
        // return view('order', compact('items', 'customers') );
        // ->with('categories', $categories);
    }

    public function add(Request $request)
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
        $cart->store_users_id = \Session::get('id');
        $cart->i_name = strtoupper($request->item);
        $cart->is_rgb = $request->is_rgb;
        $cart->price_unit = $request->price;
        $cart->price_total = $request->sub_total;
      
        $cart->cart_session = \Session::get('cart_session');

        if ($request->is_rgb == 1)
        {
            $cart->qty_content = $request->qty_content;
            $cart->qty_bottle = $request->qty_bottle;
            $cart->qty = $request->quantity;

            $item = Item::where('i_name', $request->i_name)
                ->decrement('qty_content', $request->quantity);
        }
        if ($request->is_rgb == 0)
        {
            $cart->qty = $request->quantity;
            
            $item = Item::where('i_name', $request->i_name)
                ->decrement('qty', $request->quantity);
        }

        $cart->save();


        $request->session()->flash('flash_message_success', 'Item added to cart');
        return redirect()->back();
    }
}
