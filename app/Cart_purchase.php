<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart_purchase extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_ref', 'cart_session', 'store_users_id', 'item_id', 's_name', 'i_name', 'no_exchange', 'is_rgb', 'is_bottle', 'is_confirmed', 'qty_bottle', 'qty', 'price_unit', 'price_total', 'deleted'
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
