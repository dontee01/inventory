<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'd_name', 'phone', 'address'
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

    public static $rules = ['d_name' => 'required'];
}
