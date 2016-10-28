@extends('layouts.layout')
@section('title', '::.Edit User')
@section('content')

    <section class="content bg-default">
            <div class="container-fluid">

        <!-- Display Validation Errors -->
        @include('common.errors')

        @if (Session::has('flash_message'))
        <div class="alert alert-danger">
            <strong>{{Session::get('flash_message')}}</strong>

            <br><br>

        </div>
        @endif
        
        <form method="post" action="{{url('user/edit/'.$user['id'])}}">
         {{ csrf_field() }}
        <div class="row modal-row">


        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="name" id="edit-user-name" placeholder="Username" title="Username" value="{{$user['name']}}" />
                </div>
            </div>
            <span class="help-block small">Username</span>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="password" id="edit-user-password" placeholder="****" title="Password" value="{{$user['password']}}" />
                </div>
            </div>
            <span class="help-block small">Password</span>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                    <select class="form-control" name="level" id="edit-user-level">
                        <option value="1">Admin</option>
                        <option value="2">Sales</option>
                        <option value="3">Store</option>
                    </select>
                </div>
            </div>
            <span class="help-block small">User Level</span>
        </div>


        </div>

        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            <button type="submit" class="btn btn-danger btn-recharge" id="edit-user-save" >Save</button>
            <button type="reset" class="btn btn-modal-save pull-left" >Cancel</button>
        </div>

        </form>
        </div>
        </section>
@endsection