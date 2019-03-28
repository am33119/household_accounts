<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = array('id');

    public static $rules = array(

        'balance' => 'required',
        'category' => 'required',
    );

    // BopモデルとCategoryモデルを関連づける
    public function bops()
    {
      return $this->hasMany('App\Bop');

    }
}
