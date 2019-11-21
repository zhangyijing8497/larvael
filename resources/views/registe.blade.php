<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css"> 
    <title>注册</title>
</head>
<body>

    <form class="form-horizontal" role="form" action="{{url('/doRegiste')}}" method="post">
        @csrf
        <center><h3><b>欢迎注册</b></h3></center>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="firstname" placeholder="请输入用户名">
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-10">
            <input type="email" class="form-control" name="email" id="firstname" placeholder="请输入邮箱账号">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
            <input type="password" class="form-control" name="password" id="lastname" placeholder="请输入密码">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
            <input type="password" class="form-control" name="repassword" id="lastname" placeholder="确认密码">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">注册</button>
            </div>
        </div>
    </form>
</body>
</html>