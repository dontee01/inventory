<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

use View;
use Input;
use Validator;
use Redirect;
class UserController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(\Session::has('id'))
    {
      return redirect('home');
    }
    // $users = User::all();
    return view('login');
  }

  public function login(Request $request)
  {
    $req_all = $request->all();
    // print_r($req_all);exit;
    $this->validate($request, [
        'username' => 'required|max:255',
        'password' => 'required|min:4|max:32'
    ]);
    $user = User::where('name', $request->username)
    ->where('password', $request->password)
    ->first();
    // dd($user);exit;
    if ($user)
    {
      $request->session()->put('id', $user->id);
      $request->session()->put('name', $user->name);
    // dd(session()->all());exit;
      return redirect('home');
    }
    else
    {
      $request->session()->flash('flash_message', 'Login Failed!');
      return redirect('/');
      // ->withInput($request->all());
    }
  }

  public function logout(Request $request)
  {
    \Session::flush();
    return redirect('/');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return View::make('users.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $input = Input::all();
    $validation = Validator::make($input, User::$rules);

    if ($validation->passes())
    {
        User::create($input);

        return Redirect::route('users.index');
    }

    return Redirect::route('users.create')
        ->withInput()
        ->withErrors($validation)
        ->with('message', 'There were validation errors.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user = User::find($id);
    if (is_null($user))
    {
        return Redirect::route('users.index');
    }
    return View::make('users.edit', compact('user'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $input = Input::all();
    $validation = Validator::make($input, User::$rules);
    if ($validation->passes())
    {
        $user = User::find($id);
        $user->update($input);
        return Redirect::route('users.show', $id);
    }
	return Redirect::route('users.edit', $id)
	        ->withInput()
	        ->withErrors($validation)
	        ->with('message', 'There were validation errors.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    User::find($id)->delete();
    return Redirect::route('users.index');
  }
  
}