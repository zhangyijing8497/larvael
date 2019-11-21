<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理员添加</title>
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css"> 
    <script src="{{asset('/static/admin/js/jquery-3.1.1.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}"> 
</head>
<body>
    <center><h3><b>管理员添加</b></h3></center>
    <!-- @if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif -->
    <form class="form-horizontal" role="form" action="{{url('admin/store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="admin_name" id="firstname" placeholder="请输入用户名">
                <span style="color:red;">@php echo $errors->first('admin_name'); @endphp</span>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
            <input type="password" class="form-control" name="admin_pwd" id="admin_pwd" placeholder="请输入密码">
            <span style="color:red;">@php echo $errors->first('admin_pwd'); @endphp</span>
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

	// 用户名失去焦点
	$(document).on("blur","#firstname",function(){
		var _this=$(this);
		var admin_name=_this.val();
		var reg=/^[\u4e00-\u9fa5\w]{2,12}$/;
		if(!reg.test(admin_name)){
			_this.parent().addClass('has-error');
			_this.next().text('用户名不符合规范');
			return;
		}

		$.ajax({
			method: "POST",
			url: "{{url('/admin/checkOnly')}}",
			data: {admin_name:admin_name}
		}).done(function( msg ) {
			if( msg > 0){
				$('#firstname').parent().addClass('has-error');
				$('#firstname').next().text('用户名已存在');
			}
		});
	})

	// 密码失去焦点
	$(document).on("blur","#admin_pwd",function(){
		var _this=$(this);
		var admin_pwd=_this.val();
		var reg=/^[0-9]{4,6}$/;
		if(!reg.test(admin_pwd)){
			_this.parent().addClass('has-error');
			_this.next().text('密码不符合规范');
			return;
		}
	})

	$(document).on("click",".btn-default",function(){
		var _this=$(this);
		var admin_name=_this.val();
		var reg=/^[\u4e00-\u9fa5\w]{2,12}$/;
		if(!reg.test(admin_name)){
			_this.parent().addClass('has-error');
			_this.next().text('用户名不符合规范');
			return;
		}
		var flag=true;
		$.ajax({
			method: "POST",
			url: "{{url('/admin/checkOnly')}}",
			async:false,
			data: {admin_name:admin_name}
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

        var _this=$(this);
		var admin_pwd=$("#admin_pwd").val();
		var reg=/^[0-9]{4,6}$/;
		if(!reg.test(admin_pwd)){
			$("#admin_pwd").parent().addClass('has-error');
			$("#admin_pwd").next().text('密码不符合规范');
			return;
		}

		$('form').submit();
	})
</script>