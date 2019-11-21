<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    public  $primaryKey="goods_id";

    protected $table = 'goods';

    public $timestamps = false;
 


    // 白名单   表设计中不允许为空的字段
    protected $fillable = ['goods_name','goods_price','goods_num','goods_desc','goods_img','goods_imgs','is_new','is_best','is_hot','is_up','cate_id','brand_id'];
}
