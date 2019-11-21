<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">  
    <script src="{{asset('/static/admin/js/jquery-3.1.1.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>商品添加</title>
</head>
<body>
    <center><h3><b>商品添加页面</b></h3></center>
    <form class="form-horizontal" role="form" action="{{url('goods/store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">商品名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="goods_name" id="firstname" placeholder="请输入商品名称">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">商品价格</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="goods_price" id="lastname" placeholder="请输入商品价格">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">库存</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="goods_num" id="lastname" placeholder="请输入库存">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">商品简介</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3" name="goods_desc"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">图片</label>
            <div class="col-sm-10">
                <input type="file" name="goods_img">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">相册</label>
            <div class="col-sm-10">
                <input type="file" name="goods_imgs">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">新品</label>
            <div class="col-sm-10">
            <input type="radio" name="is_new" value="1" checked>是
            <input type="radio" name="is_new" value="2">否
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">精品</label>
            <div class="col-sm-10">
            <input type="radio" name="is_best" value="1" checked>是
            <input type="radio" name="is_best" value="2">否
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">热卖</label>
            <div class="col-sm-10">
            <input type="radio" name="is_hot" value="1" checked>是
            <input type="radio" name="is_hot" value="2">否
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">上架</label>
            <div class="col-sm-10">
            <input type="radio" name="is_up" value="1" checked>是
            <input type="radio" name="is_up" value="2">否
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">品牌</label>
            <div class="col-sm-10">
                <select name="brand_id">
                    <option value="">--请选择--</option>
                    @foreach($brandInfo as $v)
                    <option value="{{$v->brand_id}}">{{$v->brand_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">分类</label>
            <div class="col-sm-10">
                <select name="cate_id">
                    <option value="">---------请选择---------</option>
                    @foreach($data as $v)
                        <option value="{{$v->cate_id}}">{{str_repeat("----",$v['level'])}}{{$v->cate_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" value="提 交">
            </div>
        </div>
    </form>
</body>
</html>
