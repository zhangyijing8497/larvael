<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public  $primaryKey="brand_id";

    protected $table = 'brand';

    public $timestamps = false;
 


    // 白名单   表设计中不允许为空的字段
    protected $fillable = ['brand_name','brand_url','brand_desc','brand_logo'];

    // 黑名单   表设计中允许为空的字段
    // protected $guarded = ['brand_logo','brand_desc'];

}
