@extends('layouts.layout')
@section('title', '::.Login')
@section('content')

<div class="container-center animated slideInDown">


        <!-- Display Validation Errors -->
        @include('common.errors')

        @if (Session::has('login_status'))
        <div class="alert alert-danger">
            <strong>{{Session::get('login_status')}}</strong>

            <br><br>

        </div>
        @endif
            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-unlock"></i>
                </div>
                <div class="header-title">
                    <h3>Login</h3>
                    <small>
                        Please enter your credentials to login.
                    </small>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-body">
                    <form action="{{ url('/') }}" id="loginForm" method="POST" novalidate>
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label" for="username">Username</label>
                            <input type="text" placeholder="Username" title="Please enter you username" required="" value="" name="username" id="username" class="form-control">
                            <span class="help-block small">Your unique username</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Password</label>
                            <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                            <!-- <span class="help-block small">Your strong password</span> -->
                        </div>
                        <div>
                            <button type="submit" class="btn btn-accent">Login</button>
                            <!-- <a class="btn btn-default" href="register.html">Register</a> -->
                        </div>
                    </form>
                </div>
            </div>

        </div>
@endsection