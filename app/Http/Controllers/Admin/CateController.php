<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Cate;

class CateController extends Controller
{
     /**无限极分类 */
     public function getcateInfo($cateInfo,$parent_id=0,$level=1){
        static $info = [];
        foreach($cateInfo as $k=>$v){
            if($v['parent_id']==$parent_id){
                $v['level']=$level;
                $info[]=$v;
                $this->getcateInfo($cateInfo,$v['cate_id'],$level+1);
            }
        }
        return $info;
    }

    /**列表展示 */
    public function index()
    {
        $pageSize=config('app.pageSize');

        // 搜索
        $name=request()->name;
        $where=[];
        if($name){
            $where[]=['cate_name','like',"%$name%"];
        }
        $data=Cate::where($where)->paginate($pageSize);
        $query=request()->all();
        return view('admin/cate/index',['data'=>$data,'query'=>$query]);
    }

    /**显示添加的视图 */
    public function create()
    {
        $cateInfo=Cate::get();
        $data=$this->getcateInfo($cateInfo);
        return view('admin/cate/create',['data'=>$data]);
    }

   
    /**执行添加 */
    public function store(Request $request)
    {
        // 接收值
        $post=request()->except('_token');

        // 验证
        $validator = \Validator::make($post, [
            'cate_name' => 'required|unique:cate',
        ],[
                'cate_name.required'=>'分类名称必填',
                'cate_name.unique'=>'分类名称已存在',
        ]);
        if ($validator->fails()) {
            return redirect('cate/create')
            ->withErrors($validator)
            ->withInput();
        }


        $cate=Cate::create($post);
        if($cate){
            echo "<script>alert('添加成功',location='/cate/index')</script>";
        }else{
            echo "<script>alert('添加失败',location='/cate/create')</script>";
        }
    }

    /** */
    public function show($id)
    {
        //
    }

    /**展示编辑视图 */
    public function edit($cate_id)
    {
        $cateInfo=Cate::get();
        $data=Cate::where('cate_id',$cate_id)->first();
        // dd($data);
        return view('admin/cate/edit',['data'=>$data,'cateInfo'=>$cateInfo]);
    }

    /**执行编辑 */
    public function update(Request $request, $cate_id)
    {
        $post=request()->except('_token');

        // 验证
        $validator = \Validator::make($post, [
            'cate_name' => 'required|unique:cate',
        ],[
                'cate_name.required'=>'分类名称必填',
                'cate_name.unique'=>'分类名称已存在',
        ]);
        if ($validator->fails()) {
            return redirect('cate/create')
            ->withErrors($validator)
            ->withInput();
        }

        $res=Cate::where('cate_id',$cate_id)->update($post);
        if($res){
            echo "<script>alert('修改成功');location='/cate/index'</script>";
        }else{
            echo "<script>alert('修改失败');location='/cate/index'</script>";
        }
    }

    /**执行删除 */
    public function destroy($cate_id)
    {
        // echo $cate_id;exit;
        if(!$cate_id){
            abort(404);
        }
        $res=Cate::destroy($cate_id);
        if($res){
            echo "<script>alert('删除成功',location='/cate/index')</script>";
        }else{
            echo "<script>alert('删除失败',location='/cate/index')</script>";
        }
    }

    /*js验证*/
    public function checkOnly(){
        $cate_name=request()->cate_name;
        $count=Cate::where('cate_name',$cate_name)->count();
        // echo $count;
    }
    
}
