<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品列表</title>
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">  
</head>
<body>
    <center>
        <h3><b>商品列表</b></h3>
    </center>

    <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <input type="text" class="form-control" value="{{$query['name']??''}}" name="name" placeholder="请输入品牌名称关键字...">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>商品id</th>
                <th>商品名称</th>
                <th>商品价格</th>
                <th>商品图片</th>
                <th>商品相册</th>
                <th>商品库存</th>
                <th>商品介绍</th>
                <th>新品</th>
                <th>精品</th>
                <th>热卖</th>
                <th>是否上架</th>
                <th>品牌</th>
                <th>分类</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($data as $v)
            <tr @if($i%2==0) class="active" @else class="success" @endif>
                <td>{{$v->goods_id}}</td>
                <td>{{$v->goods_name}}</td>
                <td>{{$v->goods_price}}</td>
                <td><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" width="60px" height="60px"></td>
                <td><img src="{{env('UPLOAD_URL')}}{{$v->goods_imgs}}" width="60px" height="60px"></td>
                <td>{{$v->goods_num}}</td>
                <td>{{$v->goods_desc}}</td>
                <td>
                    @if($v->is_new==1)
                        √
                    @else
                        ×
                    @endif
                </td>
                <td>
                    @if($v->is_best==1)
                        √
                    @else
                        ×
                    @endif
                </td>
                <td>
                    @if($v->is_hot==1)
                        √
                    @else
                        ×
                    @endif
                </td>
                <td>
                    @if($v->is_up==1)
                        √
                    @else
                        ×
                    @endif
                </td>
                <td>{{$v->brand_name}}</td>
                <td>{{$v->cate_name}}</td>
                <td>
                    <a href="{{url('/goods/edit/'.$v->goods_id)}}" class="btn btn-primary">编辑</a>
                    <a href="{{url('/goods/delete/'.$v->goods_id)}}" class="btn btn-danger">删除</a>
                </td>
            </tr>
            @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
    <a href="{{url('/goods/create')}}"><h4><b>添加</b></h4></a>
    {{$data->appends($query)->links()}}
</body>
</html>

