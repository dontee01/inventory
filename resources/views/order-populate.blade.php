@extends('layouts.layout')
@section('title', '::.Order')
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

        <div class="col-md-3">
            <div class="panel">
                <div class="panel-body">
                    <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                        <i class="pe pe-7s-global text-warning"> </i>
                        Products
                    </h1>
                    <div class="small">
                        <select class="form-control" onchange="location = this.value;">
                            <option value="">Select an item</option>
                        @foreach($items as $item)
                            <option value="{{url('order/'.$item['id'])}}">{{$item['i_name']}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="m-t-sm">
                      
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h1>Inventory App</h1>
            <form action="{{url('cart/add')}}" method="post">
            {{csrf_field()}}

                <div class=" form-inline">
                    <div class="form-group form-group-sm">
                    <select class="input-sm " title="Select a customer" name="customer" required="required">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{$customer->c_name}}">{{$customer->c_name}}</option>
                        @endforeach
                    </select>
                    <span class="help-block small">Choose a customer</span>
                    </div>

                    <div class="form-group form-group-sm">
                    <select class="input-sm " title="Select a driver" name="driver" required="required">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $driver)
                            <option value="{{$driver->d_name}}">{{$driver->d_name}}</option>
                        @endforeach
                    </select>
                    <span class="help-block small">Choose a driver</span>
                    </div>
                    
                    <input class="input-sm" type="hidden" name="is_rgb" id="add-quantity-is-rgb" readonly="readonly" value="{{$details->is_rgb}}" />
                    <input class="input-sm" type="hidden" name="cat_id" id="add-quantity-is-rgb" readonly="readonly" value="{{$details->categories_id}}" />
                    <input class="input-sm" type="hidden" name="transaction_ref" id="add-quantity-is-rgb" readonly="readonly" value="{{Session::get('transaction_ref')}}" />

                    @if ($details->is_rgb)
                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" name="quantity-bottle" id="add-quantity-bottle" title="Quantity" readonly="readonly" value="{{$details->qty_bottle}}" />
                        <span class="help-block small">Empty Bottles Left</span>
                    </div>

                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" name="quantity-content" id="add-quantity-content" title="Quantity" readonly="readonly" value="{{$details->qty_content}}" />
                        <span class="help-block small">Bottles with Content Left</span>
                    </div>
                    @endif

                    @if($details->is_rgb == 0)
                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" name="qty" id="add-quantity-qty" title="Quantity Left" readonly="readonly" value="{{$details->qty}}" />
                        <span class="help-block small">Quantity Left</span>
                    </div>
                    @endif

                </div>


                <div class="form-group form-group-sm">
                    <input class="input-sm" type="text" v-model="quantity" name="quantity" id="add-quantity" title="Quantity" required="required" />
                    <span class="help-block small">Quantity</span>
                </div>

                <div class=" form-inline">

                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" v-model="price" name="price" id="add-quantity-price" title="Unit Price" readonly="readonly" value="{{$details->price_unit}}" required="required" />
                        <span class="help-block small">Unit Price</span>
                    </div>

                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" name="sub_total" id="add-quantity-sub" title="Sub Total" readonly="readonly" value="@{{quantity * price}}" required="required" />
                        <span class="help-block small">Sub Total</span>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <button class="btn btn-default btn-rounded btn-block" id="add-to-cart" type="submit">Add To Cart</button>
                </div>

            </form>

        </div>
        
        
            
        </div>
        <!-- end row -->
    </div>
    <!-- end main col-8 -->


    <div class="col-md-3">
        <div class="panel">
            <div class="panel-body">
                <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                    <i class="pe pe-7s-global text-warning"> </i>
                    Ads
                </h1>
                <div class="small">
                Ads
                </div>
                <div class="m-t-sm">
                  
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main row -->


    </div>
</section>

@endsection