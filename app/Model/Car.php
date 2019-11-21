<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public  $primaryKey="c_id";

    protected $table = 'car';

    public $timestamps = false;
 


    // 黑名单   表设计中允许为空的字段
    protected $guarded = [];
}
