<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
      'date' => 'required',
      'income' => 'required',
      'user_id' => 'required',

    );
}
