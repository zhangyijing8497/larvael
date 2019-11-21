<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    public  $primaryKey="cate_id";

    protected $table = 'cate';

    public $timestamps = false;
 


    // 白名单   表设计中不允许为空的字段
    protected $fillable = ['cate_name','cate_show','parent_id'];

}
