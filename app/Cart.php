<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['quantity'];

    function get_product(){
        return $this->belongsTo('App\Product', 'product_id');
    }
}
