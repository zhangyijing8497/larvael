<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Login;

class LoginController extends Controller
{
    // 发送邮件
    public function send(){
        $email=request()->email;

        $code=rand(100000,999999);
        session(['regcode'=>['code'=>$code,'email'=>$email]]);
        $message="您正在注册珠宝商会员,您的验证码为:".$code.",五分钟内有效,请勿泄露于他人";
        
        \Mail::raw($message ,function($message)use($email){
            //设置主题
            $message->subject("欢迎注册滕浩有限公司");
            //设置接收方
            $message->to($email);
        });
    }
    // 执行注册
    public function doReg(){
        $post=request()->except('_token');
        $regcode=session('regcode');
        // dd($post);
        if($post['user_email']!=$regcode['email']){
            echo "<script>alert('邮箱账号有误');window.history.go(-1);</script>";die;
        }
        if($post['user_code']!=$regcode['code']){
            echo "<script>alert('验证码有误');window.history.go(-1);</script>";die;
        }
        if($post['user_pwd']!=$post['user_pwd1']){
            echo "<script>alert('确认密码与密码不一致');window.history.go(-1);</script>";die;
        }
        $post['addtime']=time();
        $login=Login::create($post);
        if($login){
            echo "<script>alert('注册成功');location='/login'</script>";
        }else{
            echo "<script>alert('注册失败');location='/reg'</script>";
        }
    }

    public function doLogin(){
        $post=request()->except('_token');
        $where[]=['user_email','=',$post['user_email']];
        $res=Login::where($where)->first();
        // dd($res);
        // if($post['user_pwd']!=$res['user_pwd']){
        //     echo "<script>alert('密码有误');window.history.go(-1);</script>";die;
        // }
        if($res){
            if($post['user_pwd']==$res['user_pwd']){
                session(['user_id'=>$res['user_id']]);
                echo "<script>alert('登陆成功');location='/'</script>";    
            }
        }else{
            echo "<script>alert('登陆失败');location='/login'</script>";
        }
    }
}
 