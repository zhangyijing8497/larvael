@extends('layouts.shop')
@section('title', '珠宝商城--注册')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('login/doReg')}}" method="post" class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="{{url('login')}}">登陆</a></h3>
      @csrf
      <div class="lrBox">
       <div class="lrList"><input type="text" name="user_email" placeholder="输入手机号码或者邮箱号" id="email"/></div>
       <div class="lrList2"><input type="text" name="user_code" placeholder="输入短信验证码" /> <button type="button" id="but">获取验证码</button></div>
       <div class="lrList"><input type="password" name="user_pwd" id="pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="password" name="user_pwd1" id="pwd1" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     </form><!--reg-login/-->
     <script src="/static/admin/js/jquery-3.1.1.min.js"></script>
     <script>
          $(document).on("click","#but",function(){
               var email=$("#email").val();
               // 验证
               reg=/^\w+@\w+\.com$/;
               if(email==""){
                    alert('邮箱必填');
                    return false;
               }else if(!reg.test(email)){
                    alert('邮箱格式不正确');
                    return false;
               }    

               $.post(
                    "{{url('login/send')}}",
                    {email:email,_token:"{{csrf_token()}}"},
                    function(res){
                        alert('发送成功');
                        return false;
                    }
               )
          })

          $(document).on("blur","#pwd1",function(){
               var pwd=$("#pwd").val();
               var pwd1=$("#pwd1").val();
               if(pwd!==pwd1){
                    alert('确认密码与密码不一致');
                    return false;
               }
          })
     </script>

     @include('index/public/footer')
     @endsection

  