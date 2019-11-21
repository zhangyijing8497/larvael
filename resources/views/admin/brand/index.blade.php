<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">  
</head>
<body>
    <center>
        <h3><b>商品品牌列表</b></h3>
    </center>

    <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <input type="text" class="form-control" value="{{$query['word']??''}}" name="word" placeholder="请输入品牌名称关键字...">
                <input type="text" class="form-control" value="{{$query['desc']??''}}" name="desc" placeholder="请输入备注关键字...">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>品牌id</th>
                <th>品牌名称</th>
                <th>品牌logo</th>
                <th>品牌网址</th>
                <th>品牌备注</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($data as $v)
            <tr @if($i%2==0) class="active" @else class="success" @endif>
                <td>{{$v->brand_id}}</td>
                <td>{{$v->brand_name}}</td>
                <td><img src="{{env('UPLOAD_URL')}}{{$v->brand_logo}}" width="60px" height="60px"></td>
                <td>{{$v->brand_url}}</td>
                <td>{{$v->brand_desc}}</td>
                <td>
                    <a href="{{url('/brand/edit/'.$v->brand_id)}}" class="btn btn-primary">编辑</a>
                    <a href="{{url('/brand/delete/'.$v->brand_id)}}" class="btn btn-danger">删除</a>
                </td>
            </tr>
            @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
    <a href="{{url('/brand/create')}}"><h4><b>添加</b></h4></a>
    {{$data->appends($query)->links()}}
</body>
</html>

