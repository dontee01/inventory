@extends('layouts.layout')
@section('title', '::.Process Pending Sales')
@section('content')


<section class="content bg-default">
    <div class="container-fluid">

    <!-- Display Validation Errors -->
        @include('common.errors')

        @if (Session::has('flash_message'))
        <div align="center" class="alert alert-danger alert-dismissable mw800 center-block">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" color="blue">x</button>
            <strong>{{Session::get('flash_message')}}</strong>

            <br><br>

        </div>
        @endif

        @if (Session::has('flash_message_success'))
        <div align="center" class="alert alert-success alert-dismissable mw800 center-block">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" color="blue">x</button>
            <strong>{{Session::get('flash_message_success')}}</strong>

            <br><br>

        </div>
        @endif



<div class="row">

    <div class="col-md-9">

        <div class="row">

        <div class="col-md-12">
            <h1>Inventory App</h1>

            <div class="m-t-sm">
                @if(count($orders) != 0)
                <!-- <div class="small">
                Cart is empty
                </div> -->
                <table class="table table-hover table-striped" id="table-custom">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key=>$order)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$order['i_name']}}</td>
                        <td>{{$order['qty']}}</td>
                        <td>{{$order['price_total']}}
                        <input type="hidden" id="id-add-item" value="{{$order['id']}}" />
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" align="right"><strong>Total</strong></td>
                        <td><strong>{{$price_total}}</strong>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="form-group form-group-sm">
                    <!-- <button class="btn btn-danger btn-rounded btn-block" id="add-to-cart" type="submit">Checkout</button> -->
                </div>
                @endif

            </div>

        </div>
        
        
            
        </div>
        <!-- end row -->
        

        <div class="row">

            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                            <i class="pe pe-7s-global text-warning"> </i>
                            <!-- Returned Items -->
                        </h1>
                        <div class="small">
                            
                        </div>
                        <div class="m-t-sm">
                          
                        <form action="{{url('sales/checkout/'.$order['transaction_ref'])}}" method="post">
                        {{csrf_field()}}
                            <div class=" form-inline">

                                <div class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="total" id="check-quantity-bottle" title="Quantity"  readonly="readonly" value="{{$price_total}}" />
                                    <span class="help-block small">Total</span>
                                </div>
                                <div class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="amount" id="check-quantity-bottle" title="Quantity" required="required" value="0" />
                                    <span class="help-block small">Amount Paid</span>
                                </div>


                                <input class="input-sm" type="hidden" name="d_name" id="check-quantity-is-rgb" readonly="readonly" value="{{$order['d_name']}}" />

                            </div>

                            <div class="form-group form-group-sm">
                                <button class="btn btn-danger btn-rounded btn-block" id="add-to-cart" type="submit">Checkout</button>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->



    </div>
    <!-- end main col-8 -->


    <div class="col-md-3">
        <div class="panel">
            <div class="panel-body">

            </div>
        </div>
    </div>
</div>
<!-- end main row -->


    </div>
</section>

@endsection