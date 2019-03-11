<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'balance' => 'required',
        'category' => 'required',
        'user_id' => 'required',
    );
}
