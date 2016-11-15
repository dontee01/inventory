<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bottle_debtor extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_ref', 'users_id', 'd_name', 'i_name', 'error_type', 'is_cleared', 'is_rgb_content', 'qty_bottle', 'amount_paid', 'comment'
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
}
