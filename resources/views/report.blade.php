@extends('layouts.layout')
@section('title', '::.Report')
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
            <h4>Report</h4>

            <form action="{{url('report/show')}}" method="post">
            {{csrf_field()}}

                <div class=" form-inline">
 <!-- <input name="dayfrom" type="text" class="tcal" required="required" autocomplete="off" /> -->
                    <div class="form-group form-group-sm">
                        <div class='input-group date' id='datetimepicker6'>
                            <input type='text' class="input-sm" name="from" required="required" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    <span class="help-block small">Choose a date</span>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class='input-group date' id='datetimepicker7'>
                            <input type='text' class="input-sm" name="to" required="required" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    <span class="help-block small">Choose a date</span>
                    </div>


                    <input class="input-sm" type="hidden" name="transaction_ref" id="add-quantity-is-rgb" readonly="readonly" value="{{Session::get('transaction_ref')}}" />

                </div>


                <div class="form-group form-group-sm">
                <select class="input-sm " title="How did the bottles break ?" name="report_type" required="required">
                    <option value="">Select Report Type</option>
                    <option value="sales">Sales</option>
                    <option value="purchases">Purchases</option>
                    <option value="bottle-log">Bottle Log</option>
                    <option value="stock">Stock</option>
                </select>
                <span class="help-block small">What report type would you like to see ?</span>
                </div>


                <div class="form-group form-group-sm">
                    <button class="btn btn-default btn-rounded btn-block" id="add-to-cart" type="submit">Add</button>
                </div>

            </form>


        </div>
        
        
            
        </div>
        <!-- end row -->
    </div>
    <!-- end main col-8 -->


    <div class="col-md-3">
        <!-- <div class="panel">
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
        </div> -->
    </div>
</div>
<!-- end main row -->


    </div>
</section>

@endsection