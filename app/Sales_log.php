<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_log extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_ref', 'users_id', 'd_name', 'i_name', 'is_rgb', 'qty', 'qty_bottle', 'qty_content', 'total', 'amount_paid'
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
