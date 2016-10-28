<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;

use DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
    	$categories = Category::all();
    	// $orders = DB::table('categories')
    	// ->get();
    	// print_r($categories);exit;
    	return view('order', ['categories' => $categories]);
    	// ->with('categories', $categories);
    }

    public function list_categories($id)
    {
    	$id = $id;

    }
}
