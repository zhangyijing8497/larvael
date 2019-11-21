<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public  $primaryKey="user_id";

    protected $table = 'login';

    public $timestamps = false;
 


    

    // 黑名单   表设计中允许为空的字段
    protected $guarded = ['user_code','user_pwd1'];
}
