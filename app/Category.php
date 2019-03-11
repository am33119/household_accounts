<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'date' => 'required',
        'income' => 'required',
        'user_id' => 'required',
    );
}
