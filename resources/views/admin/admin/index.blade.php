<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理员列表</title>
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">
</head>
<body>
    <center><h3><b>管理员列表页</b></h3></center>
    <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
            <input type="text" class="form-control" value="{{$query['name']??''}}" name="name" placeholder="请输入用户名关键字...">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>管理员id</th>
                <th>用户名</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($data as $v)
                <tr @if($i%2==0) class="active" @else class="success" @endif>
                    <td>{{$v->admin_id}}</td>
                    <td>{{$v->admin_name}}</td>
                    <td>
                        <a href="{{url('admin/edit/'.$v->admin_id)}}" class="btn btn-primary">编辑</a>
                        <a href="{{url('admin/delete/'.$v->admin_id)}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
    <a href="{{url('admin/create')}}"><h4><b>添加</b></h4></a>
    {{$data->appends($query)->links()}}
</body>
</html>