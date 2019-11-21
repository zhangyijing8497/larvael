<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css"> 
    <script src="{{asset('/static/admin/js/jquery-3.1.1.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>文章编辑</title>
</head>
<body>
    <center><h3><b>文章的编辑</b></h3></center>
    <form class="form-horizontal" role="form" action="{{url('art/update/'.$data->art_id)}}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">文章标题</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="art_title" id="firstname" value="{{$data->art_title}}" placeholder="请输入文章标题">
                <span style="color:red;">@php echo $errors->first('art_title'); @endphp</span>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">文章重要性</label>
            <div class="col-sm-10">
                @if($data->art_impor==1)
                    <input type="radio" name="art_impor" value="1" checked>普通
                    <input type="radio" name="art_impor" value="2">置顶
                @else
                    <input type="radio" name="art_impor" value="1">普通
                    <input type="radio" name="art_impor" value="2" checked>置顶
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">文章重要性</label>
            <div class="col-sm-10">
                @if($data->art_display==1)
                    <input type="radio" name="art_display" value="1" checked>显示
                    <input type="radio" name="art_display" value="2">不显示
                @else
                    <input type="radio" name="art_display" value="1">
                    <input type="radio" name="art_display" value="2" checked>不显示
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">文章作者</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="{{$data->art_author}}" name="art_author" placeholder="请输入文章作者">
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">作者email</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="{{$data->art_email}}" name="art_email" placeholder="请输入作者email">
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">关键字</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="{{$data->art_word}}" name="art_word" placeholder="请输入关键字">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">网页描述</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3" name="art_desc">{{$data->art_desc}}</textarea>
            </div>
	    </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">上传文件</label>
            <div class="col-sm-10">
                <input type="file" name="art_logo">
                <img src="{{asset('storage'.$data->art_logo)}}"  width="50px" height="50px">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">文章分类</label>
            <div class="col-sm-10">
                <select name="c_id">
                    <option value="">--请选择--</option>
                    @foreach($carInfo as $v)
                        @if($data->c_id==$v->c_id)
                            <option value="{{$v->c_id}}" selected>{{$v->c_name}}</option>
                        @else
                            <option value="{{$v->c_id}}">{{$v->c_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" value="编辑">
            </div>
        </div>
    </form>
</body>
</html>

<script>
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// 文章标题失去焦点
	$(document).on("blur","#firstname",function(){
		var _this=$(this);
		var art_title=_this.val();
		var reg=/^[\u4e00-\u9fa5\w]{4,15}$/;
		if(!reg.test(art_title)){
			_this.parent().addClass('has-error');
			_this.next().text('文章标题不符合规范');
			return;
		}

		$.ajax({
			method: "POST",
			url: "{{url('/art/checkOnly')}}",
			data: {art_title:art_title}
		}).done(function( msg ) {
			if( msg > 0){
				$('#firstname').parent().addClass('has-error');
				$('#firstname').next().text('文章标题已存在');
			}
		});
	})

	$(document).on("click",".btn-default",function(){
		var _this=$(this);
		var art_title=_this.val();
		var reg=/^[\u4e00-\u9fa5\w]{4,15}$/;
		if(!reg.test(art_title)){
			_this.parent().addClass('has-error');
			_this.next().text('文章标题不符合规范');
			return;
		}
		var flag=true;
		$.ajax({
			method: "POST",
			url: "{{url('/art/checkOnly')}}",
			async:false,
			data: {art_title:art_title}
		}).done(function( msg ) {
			if( msg > 0){
				$('#firstname').parent().addClass('has-error');
				$('#firstname').next().text('文章标题已存在');
				flag=false;
			}
		});
		if(!flag){
			return;
		}

		$('form').submit();
	})
</script>