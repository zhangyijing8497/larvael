<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>品牌添加</title>
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css"> 
	<script src="{{asset('/static/admin/js/jquery-3.1.1.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<form action="{{url('brand/store')}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
	<center><h3>添加商品品牌</h3></center>

	<!-- @if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif -->


	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">品牌名称</label>
		<div class="col-sm-10">
			<input type="text" name="brand_name" class="form-control" id="firstname" placeholder="请输入品牌名称">
			<span style="color:red;">@php echo $errors->first('brand_name'); @endphp</span>
		</div>
	</div>
	
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌网址</label>
		<div class="col-sm-10">
			<input type="text" name="brand_url" class="form-control" id="brand_url" placeholder="请输入品牌网址">
			<span style="color:red;">@php echo $errors->first('brand_url'); @endphp</span>
		</div>
    </div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌logo</label>
		<div class="col-sm-10">
			<input type="file" name="brand_logo">
		</div>
    </div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌简介</label>
		<div class="col-sm-10">
            <textarea class="form-control" rows="3" name="brand_desc"></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input type="button" class="btn btn-default" value="提 交">
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

	// 品牌名称失去焦点
	$(document).on("blur","#firstname",function(){
		var _this=$(this);
		var brand_name=_this.val();
		// alert(brand_name);
		var reg=/^[\u4e00-\u9fa5\w]{2,12}$/;
		if(!reg.test(brand_name)){
			_this.parent().addClass('has-error');
			_this.next().text('品牌名称不符合规范');
			return;
		}

		$.ajax({
			method: "POST",
			url: "{{url('/brand/checkOnly')}}",
			data: {brand_name:brand_name}
		}).done(function( msg ) {
			if( msg > 0){
				$('#firstname').parent().addClass('has-error');
				$('#firstname').next().text('品牌名称已存在');
			}
		});
	})

	// 品牌名称失去焦点
	$(document).on("blur","#brand_url",function(){
		var _this=$(this);
		var brand_url=_this.val();
		// alert(brand_url);
		var reg=/^https?:\/\/?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
		if(!reg.test(brand_url)){
			_this.parent().addClass('has-error');
			_this.next().text('品牌网址不符合规范');
			return;
		}
	})

	$(document).on("click",".btn-default",function(){
		// alert(111);return;
		// 名称验证
		var brand_name=$('#firstname').val();
		var reg=/^[\u4e00-\u9fa5\w]{2,12}$/;
		if(!reg.test(brand_name)){
			$('#firstname').parent().addClass('has-error');
			$('#firstname').next().text('品牌名称不符合规范');
			return;
		}
		var flag=true;
		$.ajax({
			method: "POST",
			url: "{{url('/brand/checkOnly')}}",
			async:false,
			data: {brand_name:brand_name}
		}).done(function( msg ) {
			if( msg > 0){
				$('#firstname').parent().addClass('has-error');
				$('#firstname').next().text('品牌名称已存在');
				flag=false;
			}
		});
		if(!flag){
			return;
		}

		var brand_url=$('#brand_url').val();
		var reg=/^https?:\/\/?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
		if(!reg.test(brand_url)){
			$('#brand_url').parent().addClass('has-error');
			$('#brand_url').next().text('品牌网址不符合规范');
			return;
		}

		$('form').submit();
	})
</script>