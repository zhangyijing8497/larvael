<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public  $primaryKey="cart_id";

    protected $table = 'cart';

    public $timestamps = false;
 


    // 黑名单   表设计中允许为空的字段
    protected $guarded = [];
}
