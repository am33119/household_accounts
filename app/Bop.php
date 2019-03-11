<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bop extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'category' => 'required',
        'memo' => 'required',
        'amount' => 'required',
        'user_id' => 'required',
    );
}
