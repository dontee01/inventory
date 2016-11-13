<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pending_order extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_ref', 'store_users_id', 'sales_users_id', 'item_id', 'd_name', 'i_name', 'c_name', 'is_rgb', 'is_confirmed', 'deleted', 'qty_content', 'qty_bottle', 'qty', 'returned_qty', 'returned_bottle', 'price_unit', 'price_total'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password'
    // ];

    protected $guarded = ['id'];
    // protected $fillable = array('name', 'email');

    public static $rules = ['i_name' => 'required'];
        // 'email' => 'required|email|min:5'
}
