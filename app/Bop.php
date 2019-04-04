<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bop extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'ha_date' => 'required',
        'category_id' => 'required',
        'memo' => 'required',
        'amount' => 'required',
        'user_id' => 'required',
    );

    // BopモデルとCategoryモデルを関連づける
    public function category()
    {
      return $this->belongsTo('App\Category');

    }
}
