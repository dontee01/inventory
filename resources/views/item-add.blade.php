@extends('layouts.layout')
@section('title', '::.Item')
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
        
        <form method="post" action="{{url('item/add')}}">
         {{ csrf_field() }}
        <div class="row modal-row">

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                    <select class="form-control" name="category" id="add-product-category" title="Choose a category">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="item" id="add-product-item" placeholder="Item" title="Item Name" />
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div >
                <label><input class="form-control" type="checkbox" name="is_rgb" id="add-product-is-rgb" title="Rgb" />Bottle</label>
                </div>
            </div>
        </div>
<div id="rgb">
        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty_content" id="add-product-content" placeholder="Content" title="Content (Crates)" />
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty_bottle" id="add-product-bottle" placeholder="Empty bottles" title="Empty Bottles (Crates)" />
                </div>
            </div>
        </div>
</div>

        <div class="panel-body" id="nrgb">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty" id="add-product-qty" placeholder="Quantity" title="Quantity" />
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="price" id="add-product-price" placeholder="Price" title="Price" />
                </div>
            </div>
        </div>


        </div>

        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            <button type="submit" class="btn btn-danger btn-recharge" id="add-product-save" >Save</button>
            <button type="reset" class="btn btn-modal-save pull-left" >Cancel</button>
        </div>

        </form>
        </div>
        </section>
@endsection