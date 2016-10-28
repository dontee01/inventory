<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_log extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_ref', 's_name', 'i_name', 'is_rgb', 'is_bottle', 'no_exchange', 'qty', 'qty_bottle', 'price_unit', 'price_total'
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

    public static $rules = ['i_name' => 'required']
        // 'email' => 'required|email|min:5'
    );
}
