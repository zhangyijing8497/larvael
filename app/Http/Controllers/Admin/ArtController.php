<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Car;
use App\Model\Art;

class ArtController extends Controller
{
    // 列表展示
    public function index()
    {
        $pageSize=config('app.pageSize');
        $title=request()->title;
        $carInfo=Car::get();
        $where=[];
        if($title){
            $where[]=['art_title','like',"%$title%"];
        }
        $data=Art::Join('car','art.c_id','=','car.c_id')->where($where)->paginate($pageSize);
        $query=request()->all();
        return view('admin/art/index',['data'=>$data,'query'=>$query,'carInfo'=>$carInfo]);
    }

    // 展示添加页面
    public function create()
    {
        $carInfo=Car::get();
        return view('admin/art/create',['carInfo'=>$carInfo]);
    }

    // 执行添加
    public function store(Request $request)
    {
        
        $post=$request->except('_token');
        // dd($post);

        // 验证
        $validator = \Validator::make($post, [
            'art_title'=> 'required|unique:art',
        ],[
                'art_title.required'=>'文章标题必填',
                'art_title.unique'=>'文章标题已存在',
        ]);
        if ($validator->fails()) {
            return redirect('art/create')
            ->withErrors($validator)
            ->withInput();
        }
        if(request()->hasFile('art_logo')) {
            $post['art_logo']=$this->upload('art_logo');
        }


        $res=Art::create($post);
        if($res){
            echo "<script>alert('添加成功',location='/art/index')</script>";
        }else{
            echo "<script>alert('添加失败',location='/art/create')</script>";
        }
    }

    /*上传文件*/
    public function upload($file)
    {
        $file = request()->file($file);
        $path = $file->store('public');
        $path=strstr($path,'/');
        return $path;
    }
    // 
    public function show($id)
    {
        //
    }

    // 展示编辑的视图
    public function edit($art_id)
    {
        $carInfo=Car::get();
        $data=Art::where('art_id',$art_id)->first();
        return view('admin/art/edit',['data'=>$data,'carInfo'=>$carInfo]);
    }

    // 执行编辑
    public function update(Request $request, $art_id)
    {
        $post=$request->except('_token');
        if(request()->hasFile('art_logo')) {
            $post['art_logo']=$this->upload('art_logo');
        }
        $res=Art::where('art_id',$art_id)->update($post);
        if($res){
            echo "<script>alert('修改成功',location='/art/index')</script>";
        }else{
            echo "<script>alert('修改失败',location='/art/index')</script>";
        }
    }

    // 执行删除
    public function destroy($art_id)
    {
        if(!$art_id){
            abort(404);
        }
        $res=Art::destroy($art_id);
        if($res){
            echo "<script>alert('删除成功',location='/art/index')</script>";
        }else{
            echo "<script>alert('删除失败',location='/art/index')</script>";
        }
    }

    /*js验证*/
    public function checkOnly(){
        $art_title=request()->art_title;
        $count=Art::where('art_title',$art_title)->count();
        // echo $count;
    }
}
