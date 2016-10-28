<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id', 'categories_id', 'i_name', 'is_rgb', 'qty', 'qty_bottle', 'qty_content', 'price_unit'
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
