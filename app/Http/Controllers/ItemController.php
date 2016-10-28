<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Item;
use App\Category;

use DB;
use App\Libraries\Custom;

class ItemController extends Controller
{
	protected $custom;
    public function __construct()
    {
        $this->middleware('login');
        $this->custom = new Custom();
    }

    public function index()
    {
    	$items = Item::all();
    	$result = [];
    	foreach ($items as $item)
    	{
	    // print_r($item);exit;
    		$cat_name = Category::findorfail($item->categories_id)
    		->value('name');
    		$item_arr = [
    			'id' => $item->id, 'category' => $cat_name, 'i_name' => $item->i_name, 'is_rgb' => $item->is_rgb, 'qty' => $item->qty, 'qty_bottle' => $item->qty_bottle, 
    			'qty_content' => $item->qty_content, 'price_unit' => $item->price_unit, 'date' => $item->created_at
    		];
    		array_push($result, $item_arr);
    	}
    	// $orders = DB::table('categories')
    	// ->get();
    	// print_r($result);exit;
    	return view('item', ['items' => $result]);
    }

    public function show_add()
    {
    	$categories = Category::all();
    	return view('item-add', ['categories' => $categories]);
    }

    public function show_edit($id)
    {
    	
    	$item = Item::find($id);
		$cat_name = Category::find($item->categories_id)
		->value('name');
		$result = [
			'id' => $item->id, 'category' => $cat_name, 'i_name' => $item->i_name, 'is_rgb' => $item->is_rgb, 'qty' => $item->qty, 'qty_bottle' => $item->qty_bottle, 
			'qty_content' => $item->qty_content, 'price_unit' => $item->price_unit
		];
    	return view('item-edit', ['item' => $result]);
    }

    public function add(Request $request)
    {
    	$cust = $this->custom;
    	$this->validate($request, [
	        'category' => 'required',
	        'item' => 'required|min:4',
	        // 'is_rgb' => 'required',
	        'qty' => 'numeric',
	        'qty_bottle' => 'numeric',
	        'qty_content' => 'numeric',
	        'price' => 'required|numeric',
	    ]);

    	$item = new Item;
    	$users_id = \Session::get('id');
    	$categories_id = $request->category;
    	$i_name = strtoupper($request->item);
    	$is_rgb = $request->is_rgb;
    	$qty = $request->qty;
    	$qty_content = $request->qty_content;
    	$qty_bottle = $request->qty_bottle;
    	$price_unit = $request->price;

    	$item_arr = [
    	'users_id' => $users_id, 'categories_id' => $categories_id, 'i_name' => $i_name, 'is_rgb' => 0, 'qty' => $qty, 'price_unit' => $price_unit
    	];

    	// if ($is_rgb == 1)
    	if ($is_rgb)
    	{
	    	$item_arr = [
	    	'users_id' => $users_id, 'categories_id' => $categories_id, 'i_name' => $i_name, 'is_rgb' => 1, 'qty_bottle' => $qty_bottle, 'qty_content' => $qty_content, 'price_unit' => $price_unit, 'created_at' => $cust->time_now()
	    	];
	    }
	    $item_ins = DB::table('items')
	    ->insert($item_arr);

		$request->session()->flash('flash_message', 'Item Added');
	    // return $this->index();
	    return redirect('/items');->withInput();
	    // print_r($item_arr);exit;
    	// return view('item', ['items' => $items]);
    }

    public function edit(Request $request, $id)
    {
    	// $items = Item::all();

    	$item = Item::find($id);
    	$users_id = \Session::get('id');
    	// $categories_id = $request->category;
    	// $i_name = strtoupper($request->item);
    	$is_rgb = $request->is_rgb;
    	$qty = $request->qty;
    	$qty_content = $request->qty_content;
    	$qty_bottle = $request->qty_bottle;
    	$price_unit = $request->price;

    	if ($is_rgb == 0)
    	{
	    	$item->users_id = $users_id;
	    	$item->qty = $qty;
	    	$item->price_unit = $price_unit;
	    }

    	if ($is_rgb)
    	{

	    	$item->users_id = $users_id;
	    	$item->qty_bottle = $qty_bottle;
	    	$item->qty_content = $qty_content;
	    	$item->price_unit = $price_unit;
	    }
	    // var_dump($item);exit;

	    $item->save();
		$request->session()->flash('flash_message', 'Item Updated');
	    // return $this->index();
	    return redirect('/items');
        // return redirect()->route('contact')->with('info', trans('texts.contact.sent_success'));
    }

    public function delete(Request $request, $id)
    {
    	// $item = Item::find($id);
    	// $users_id = \Session::get('id');

    	// $item->delete();
    	Item::destroy($id);

	    // var_dump($item);exit;
		$request->session()->flash('flash_message', 'Item Deleted');
	    return redirect('/items');
	    // return $this->index();
    }
}
