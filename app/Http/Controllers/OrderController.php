<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Customer;
use App\Driver;
use App\Item;

use DB;
use App\Libraries\Custom;

class OrderController extends Controller
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

    public function populate($id)
    {
        $cust = $this->custom;
        $customers = Customer::all();
        $drivers = Driver::all();
    	$item_details = Item::find($id);
        $items = Item::all();
        $result = [];
        
        if (! session()->has('cart_session'))
        {
            \Session::put('cart_session', time());
        }

        if (! session()->has('transaction_ref'))
        {
            $token_session = $cust->generate_session('test@random.pos', $cust->time_cur());
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

        return view('order-populate', ['items' => $result, 'details' => $item_details, 'customers' => $customers, 'drivers' => $drivers]);
    }
}
