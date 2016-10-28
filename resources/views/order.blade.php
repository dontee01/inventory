@extends('layouts.layout')
@section('title', '::.Order')
@section('content')
    <section class="content bg-default">
            <div class="container-fluid">

                <div class="row">
                <div class="col-md-8">
                <!-- <div class="row p-content"> -->
                    
                    
                <!-- <div class="page-content" id="home-content">
                    <?php
                    // include_once 'pages/home-content.php';
                    ?>
                    <div id="error"></div>
                </div>
                        
            
                        
                <div class="page-content contact-left" id="loading-content">
                    <div class="loader">
                        <img alt="" src="images/ajax-loader.gif" />
                    </div>
                </div> -->

                <div class="row">

                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-body">
                            <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                                <i class="pe pe-7s-global text-warning"> </i>
                                Products
                            </h1>
                            <div class="small">
                            <select class="form-control">
                            @foreach($categories as $category)
                                <option value="{{$category->name}}">{{$category->name}}</option>
                            @endforeach
                            </select>
                            </div>
                            <div class="m-t-sm">
                              
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                <h1>Inventory App</h1>
                </div>
                
                    
                
                     
                
                    
                
                    
                </div>
                <!-- </div> -->

                    <div class="col-md-4">
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




            </div>
    </section>

@endsection