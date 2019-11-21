<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Illuminate\Support\Facades\Auth;
use App\User;

class RegController extends Controller
{
    public function doLogin(){
        $post=request()->except('_token');
        
        if (Auth::attempt($post)) {
            // 认证通过...
            echo "<script>alert('登陆成功');location='/brand/index'</script>";
        }else{
            echo "<script>alert('登陆失败');location='/login'</script>";
        }
    }

    public function doRegiste(){
        $post=request()->except('_token');
        $post['password']=Bcrypt($post['password']);
        $res=User::create($post);
        if ($res) {
            echo "<script>alert('注册成功');location='/login'</script>";
        }else{
            echo "<script>alert('注册失败');location='/registe'</script>";
        }
    }
}
