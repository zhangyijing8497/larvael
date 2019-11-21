<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Goods;
use App\Model\Cate;
use App\Model\Brand;

class GoodsController extends Controller
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

    //列表展示
    public function index()
    {

        $pageSize=config('app.pageSize');

        // 搜索
        $name=request()->name;
        $where=[];
        if($name){
            $where[]=['goods_name','like',"%$name%"];
        }
        $data=Goods::Join('brand','goods.brand_id','=','brand.brand_id')->Join('cate','goods.cate_id','=','cate.cate_id')->where($where)->paginate($pageSize);
        $query=request()->all();
        return view('admin/goods/index',['data'=>$data,'query'=>$query]);
    }

    // 展示添加的视图
    public function create()
    {
        $cateInfo=Cate::all();
        $brandInfo=Brand::all();
        $data=$this->getcateInfo($cateInfo);
        return view('admin/goods/create',['data'=>$data,'brandInfo'=>$brandInfo]);
    }

    // 执行添加
    public function store(Request $request)
    {
        $data=$request->except('_token');
        // dd($data);
        /*文件上传*/
        if($request->hasFile('goods_img')){
            $data['goods_img']=$this->upload('goods_img');
        }

        if($request->hasFile('goods_imgs')){
            $data['goods_imgs']=$this->upload('goods_imgs');
        }
        $goods=Goods::create($data);
        if($goods){
            echo "<script>alert('添加成功');location='/goods/index'</script>";
        }else{
            echo "<script>alert('添加失败');location='/goods/create'</script>";
        }
    }
    /*文件上传*/
    public function upload($filename){
        if (request()->file($filename)->isValid()) {
            $photo = request()->file($filename);
            $store_result = $photo->store('upload');
            return $store_result;
        }
            exit('未获取到上传文件或上传过程出错');    
    }


    

    public function show($id)
    {
        //
    }

    // 展示编辑视图
    public function edit($goods_id)
    {
        $cateInfo=Cate::all();
        $brandInfo=Brand::all();
        $data=Goods::where('goods_id',$goods_id)->first();
        return view('admin/goods/edit',['cateInfo'=>$cateInfo,'brandInfo'=>$brandInfo,'data'=>$data]);
    }

    // 执行编辑
    public function update(Request $request, $goods_id)
    {
        $data=$request->except('_token');
        /*文件上传*/
        if($request->hasFile('goods_img')){
            $data['goods_img']=$this->upload('goods_img');
        }

        if($request->hasFile('goods_imgs')){
            $data['goods_imgs']=$this->upload('goods_imgs');
        }
        $res=Goods::where('goods_id',$goods_id)->update($data);
        if($res){
            echo "<script>alert('修改成功',location='/goods/index')</script>";
        }else{
            echo "<script>alert('修改失败',location='/goods/index')</script>";
        }
    }

    //执行删除
    public function destroy($goods_id)
    {
        $res=Goods::destroy($goods_id);
        if($res){
            echo "<script>alert('删除成功',location='/goods/index')</script>";
        }else{
            echo "<script>alert('删除失败',location='/goods/index')</script>";
        }
    }
}
