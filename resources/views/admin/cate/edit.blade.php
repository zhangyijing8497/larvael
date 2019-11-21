<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">
    <script src="{{asset('/static/admin/js/jquery-3.1.1.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">   
    <title>分类修改</title>
</head>
<body>
    <center><h3>分类修改</h3></center>
    <form action="{{url('cate/update/'.$data->cate_id)}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">分类名称</label>
            <div class="col-sm-10">
                <input type="text" name="cate_name" value="{{$data->cate_name}}" class="form-control" id="firstname"  placeholder="请输入分类名称">
                <span style="color:red;">@php echo $errors->first('cate_name'); @endphp</span>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">是否上架</label>
            @if($data->cate_show==1)
            <div class="col-sm-10">
                <input type="radio" name="cate_show" value="1" checked>是
                <input type="radio" name="cate_show" value="2">否
            @else
                <input type="radio" name="cate_show" value="1">是
                <input type="radio" name="cate_show" value="2" checked>否
            @endif
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">是否在导航栏展示</label>
            <div class="col-sm-10">
                @if($data->cate_nav_show==1)
                    <input type="radio" name="cate_nav_show" value="1" checked>是
                    <input type="radio" name="cate_nav_show" value="2">否
                @else
                    <input type="radio" name="cate_nav_show" value="1">是
                    <input type="radio" name="cate_nav_show" value="2"  checked>否
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">父类</label>
            <div class="col-sm-10">
            <tr>
                <td>
                    <select name="parent_id">
                        <option value="">---------请选择---------</option>
                        @foreach($cateInfo as $v)
                            @if($data->parent_id==$v->parent_id)
                                <option value="{{$v->cate_id}}" selected>{{str_repeat("----",$v['level'])}}{{$v->cate_name}}</option>
                            @else
                                <option value="{{$v->cate_id}}">{{str_repeat("----",$v['level'])}}{{$v->cate_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </td>      
            </tr> 
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            <input type="button" class="btn btn-default" value="修 改">
            </div>
        </div>
    </form>
</body>
</html>


<script>
	// $.ajaxSetup({
	// 	headers: {
	// 	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 	}
	// });

	// 用户名失去焦点
	$(document).on("blur","#firstname",function(){
		var _this=$(this);
		var cate_name=_this.val();
		var reg=/^[\u4e00-\u9fa5\w]{2,12}$/;
		if(!reg.test(cate_name)){
			_this.parent().addClass('has-error');
			_this.next().text('用户名不符合规范');
			return;
		}

		$.ajax({
			method: "POST",
			url: "{{url('/cate/checkOnly')}}",
			data: {cate_name:cate_name}
		}).done(function( msg ) {
			if( msg > 0){
				$('#firstname').parent().addClass('has-error');
				$('#firstname').next().text('用户名已存在');
			}
		});
	})

	$(document).on("click",".btn-default",function(){
		var _this=$(this);
		var cate_name=_this.val();
		var reg=/^[\u4e00-\u9fa5\w]{2,12}$/;
		if(!reg.test(cate_name)){
			_this.parent().addClass('has-error');
			_this.next().text('用户名不符合规范');
			return;
		}
		var flag=true;
		$.ajax({
			method: "POST",
			url: "{{url('/cate/checkOnly')}}",
			async:false,
			data: {cate_name:cate_name}
		}).done(function( msg ) {
			if( msg > 0){
				$('#firstname').parent().addClass('has-error');
				$('#firstname').next().text('用户名已存在');
				flag=false;
			}
		});
		if(!flag){
			return;
		}

		$('form').submit();
	})
</script>