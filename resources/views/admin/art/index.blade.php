<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">
    <script src="{{asset('/static/admin/js/jquery-3.1.1.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>文章列表</title>
</head>
<body>
    <center><h3><b>文章列表</b></h3></center>

    <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
            文章标题:<input type="text" name="title" value="{{$query['title']??''}}" class="form-control" placeholder="请输入关键字...">
        </div>
        分类:<select name="c_id">
            <option value="">--请选择--</option>
            @foreach($carInfo as $v)
                <option value="{{$v->c_id}}">{{$v->c_name}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-default">搜索</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>文章ID</th>
                <th>文章标题</th>
                <th>文章重要性</th>
                <th>是否显示</th>
                <th>文章作者</th>
                <th>作者email</th>
                <th>关键字</th>
                <th>网页描述</th>
                <th>上传文件</th>
                <th>文章分类</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
            <tr>
                <td>{{$v->art_id}}</td>
                <td>{{$v->art_title}}</td>
                <td>
                @if($v->art_impor==1)
                    普通
                @else
                    置顶
                @endif
                </td>
                <td>
                    @if($v->art_display==1)
                        √
                    @else
                        ×
                    @endif
                </td>
                <td>{{$v->art_author}}</td>
                <td>{{$v->art_email}}</td>
                <td>{{$v->art_word}}</td>
                <td>{{$v->art_desc}}</td>
                <td>
                    <img src="{{asset('storage'.$v->art_logo)}}"  width="50px" height="50px">
                </td>
                <td>{{$v->c_name}}</td>
                <td>
                    <a href="{{url('art/delete/'.$v->art_id)}}">删除</a>
                    <a href="{{url('art/edit/'.$v->art_id)}}">编辑</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$data->appends($query)->links()}}
</body>
</html>
