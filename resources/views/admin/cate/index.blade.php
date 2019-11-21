<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>分类列表</title>
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">
</head>
<body>
    <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
            <input type="text" class="form-control" value="{{$query['name']??''}}" name="name" placeholder="请输入分类名称的关键字...">
        </div>
        <button type="submit" class="btn btn-default">搜 索</button>
    </form>
    <table class="table">
        <center><h3><b>分类列表</b></h3></center>
            <thead>
                <tr>
                    <th>分类id</th>
                    <th>分类名称</th>
                    <th>是否上架</th>
                    <th>是否在导航栏展示</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach ($data as $v)
                <tr @if($i%2==0) class="active" @else class="success" @endif>
                    <td>{{$v->cate_id}}</td>
                    <td>{{$v->cate_name}}</td>
                    <td>
                        @if($v->cate_show==1)
                            √
                        @else
                            ×
                        @endif
                        <!-- {{$v->cate_show}} -->
                    </td>
                    <td>
                        @if($v->cate_nav_show==1)
                            √
                        @else
                            ×
                        @endif
                        <!-- {{$v->cate_nav_show}} -->
                    </td>
                    <td>
                        <a href="{{url('cate/delete/'.$v->cate_id)}}">删除</a>
                        <a href="{{url('cate/edit/'.$v->cate_id)}}">编辑</a>
                    </td>
                </tr>
                @php $i++ @endphp
                @endforeach
            </tbody>
    </table>
    {{$data->appends($query)->links()}}
    <a href="{{url('cate/create')}}"><h4><b>添加</b></h4></a>
</body>
</html>