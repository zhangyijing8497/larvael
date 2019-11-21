<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public  $primaryKey="admin_id";

    protected $table = 'admin';

    public $timestamps = false;
 


    // 白名单   表设计中不允许为空的字段
    protected $fillable = ['admin_name','admin_pwd'];
}
