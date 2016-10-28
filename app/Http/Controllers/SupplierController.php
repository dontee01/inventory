<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Supplier;

use DB;
use App\Libraries\Custom;

class SupplierController extends Controller
{
	protected $custom;
    public function __construct()
    {
        $this->middleware('login');
        $this->custom = new Custom();
    }

    public function index()
    {
    	$suppliers = Supplier::all();
    	// print_r($result);exit;
    	return view('supplier', ['suppliers' => $suppliers]);
    }

    public function show_add()
    {
    	return view('supplier-add');
    }

    public function show_edit($id)
    {
    	
    	$supplier = Supplier::find($id);
    	return view('supplier-edit', ['supplier' => $supplier]);
    }

    public function add(Request $request)
    {
    	$cust = $this->custom;
    	$this->validate($request, [
	        's_name' => 'required',
	        'phone' => 'required|numeric',
	        'address' => 'required'
	    ]);

    	$supplier = new Supplier;
    	$supplier->s_name = ucwords($request->s_name);
    	$supplier->phone = $request->phone;
    	$supplier->address = $request->address;
    	
        $supplier->save();

		$request->session()->flash('flash_message', 'Supplier Added');
	    return redirect('/suppliers')->withInput($request->all());
    }

    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            's_name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required'
        ]);
    	$supplier = Supplier::find($id);

        $supplier->s_name = ucwords($request->s_name);
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;


	    $supplier->save();
		$request->session()->flash('flash_message', 'Supplier Updated');
	    return redirect('/suppliers')->withInput($request->all());
    }

    public function delete(Request $request, $id)
    {
    	Supplier::destroy($id);

	    // var_dump($supplier);exit;
		$request->session()->flash('flash_message', 'Supplier Deleted');
	    return redirect('/suppliers');
    }
}
