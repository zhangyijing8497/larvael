<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
    public  $primaryKey="art_id";

    protected $table = 'art';

    public $timestamps = false;
 


    // 白名单   表设计中不允许为空的字段
    protected $fillable = ['art_title','art_impor','art_display','art_author','art_email','art_word','art_desc','art_logo','c_id'];
}
