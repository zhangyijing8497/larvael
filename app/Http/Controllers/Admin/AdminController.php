<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Admin;

class AdminController extends Controller
{
    // 列表展示
    public function index()
    {
        // $data=Admin::all();
        // dd($data);

        $pageSize=config('app.pageSize');

        // 搜索
        $name=request()->name;
        $where=[];
        if($name){
            $where[]=['admin_name','like',"%$name%"];
        }
        $data=Admin::where($where)->paginate($pageSize);
        $query=request()->all();

        return view('admin/admin/index',['data'=>$data,'query'=>$query]);
    }

    // 展示添加的视图
    public function create()
    {
        return view('admin/admin/create');
    }

    // 执行添加
    public function store(Request $request)
    {
        $post=request()->except('_token');

        // 验证
        $validator = \Validator::make($post, [
            'admin_name' => 'required|unique:admin',
            'admin_pwd' => 'required',
        ],[
                'admin_name.required'=>'用户名必填',
                'admin_name.unique'=>'用户名已存在',
                'admin_pwd.required'=>'密码必填'
        ]);
        if ($validator->fails()) {
            return redirect('admin/create')
            ->withErrors($validator)
            ->withInput();
        }
        $admin = Admin::create($post);
        if($admin){
            echo "<script>alert('添加成功');location='/admin/index'</script>";
        }else{
            echo "<script>alert('添加失败');location='/admin/create'</script>";
        }
    }

    public function show($id)
    {
        //
    }

    // 展示修改视图
    public function edit($admin_id)
    {
        $data=Admin::where('admin_id',$admin_id)->first();

        return view('admin/admin/edit',['data'=>$data]);
    }

    // 执行修改
    public function update(Request $request, $admin_id)
    {
        $post=request()->except('_token');

        // 验证
        $validator = \Validator::make($post, [
            'admin_name' => 'required|unique:admin',
            'admin_pwd' => 'required',
        ],[
                'admin_name.required'=>'用户名必填',
                'admin_name.unique'=>'用户名已存在',
                'admin_pwd.required'=>'密码必填'
        ]);
        if ($validator->fails()) {
            return redirect('admin/create')
            ->withErrors($validator)
            ->withInput();
        }

        $res=Admin::where('admin_id',$admin_id)->update($post);
        if($res){
            echo "<script>alert('修改成功');location='/admin/index'</script>";
        }else{
            echo "<script>alert('修改失败');location='/admin/index'</script>";
        }
    }

    // 执行删除
    public function destroy($admin_id)
    {
        if(!$admin_id){
            abort(404);
        }
        $res=Admin::destroy($admin_id);
        if($res){
            echo "<script>alert('删除成功');location='/admin/index'</script>";
        }else{
            echo "<script>alert('删除失败');location='/admin/index'</script>";
        }
    }

    /*js验证*/
    public function checkOnly(){
        $admin_name=request()->admin_name;
        $count=Admin::where('admin_name',$admin_name)->count();
        // echo $count;
    }
}
