<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Brand;
use \App\Http\Requests\StoreBrandPost;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;


class BrandController extends Controller
{
    /*列表展示*/
    public function index(){
        /*getAll(); 调用一个方法*/
        /*session的使用*/
        /*设置session*/
        //session(['user'=>'zhangsan']);
        request()->session()->put('username','lisi');
        
        /*获取*/
        // echo session('user');
        //echo request()->session()->get('username');


        /*删除*/
        // session(['user'=>null]);
        // echo request()->session()->pull('username');//先获取再删除


        /*request()->session()->flush();//删除所有
        dump(session('user'));
        dd(session('username')); */
         


        /*DB类查询*/
        /*$data=DB::table('brand')->get();*/
        /*ORM查询*/
        /*$data=Brand::all();  $data=Brand::get();*/

        $page=request()->page??1;
        $word=request()->word;
        $desc=request()->desc;
        
        // echo 'data_'.$page.'_'.$word.'_'.$desc;
        // $data=Cache::get('data_'.$page.'_'.$word.'_'.$desc);

        $data=Redis::get('data_'.$page.'_'.$word.'_'.$desc);
        dump($data);
        if(!$data){
            echo 'db===';
        $pageSize=config('app.pageSize');


        /*搜索品牌名称*/
        $word=request()->word;
        $where=[];
        if($word){
            $where[]=['brand_name','like',"%$word%"];
        }
        /*搜索品牌描述*/
        $desc=request()->desc;
        if($desc){
            $where[]=['brand_desc','like',"%$desc%"];
        }
        // DB::connection()->enableQueryLog();
        
        $data=Brand::where($where)->paginate($pageSize);
        
        // Cache::put('data_'.$page.'_'.$word.'_'.$desc, 30);

        $data=serialize($data);
        Redis::set('data_'.$page.'_'.$word.'_'.$desc, $data, 30);
    }
    $data=unserialize($data);

        // $logs = DB::getQueryLog();
        // dump($logs);
        $query=request()->all(); //搜索
        return view('admin.brand.index',['data'=>$data,'query'=>$query]); //搜索后加的query
    }


    /*展示视图 */
    public function create(){
        return view('admin.brand.create');
    }


    /*执行添加*/
    public function store(Request $request){
        /*第二种验证*/
        /*public function store(\App\Http\Requests\StoreBrandPost $request){*/
        
        /*这是第一种表单验证*/
        /*$request->validate([
            'brand_name' => 'required|unique:brand',
            'brand_url' => 'required',
        ],[
            'brand_name.required'=>'品牌名称必填',
            'brand_name.unique'=>'品牌名称已经存在',
            'brand_url.required'=>'品牌网址必填'
        ]); */
        /*except是接收排除_token的值*/
        $post=$request->except(['_token']);
       
        $validator = \Validator::make($post, [
                'brand_name' => 'required|unique:brand',
                'brand_url' => 'required',
        ],[
                'brand_name.required'=>'品牌名称必填',
                'brand_name.unique'=>'品牌名称已经存在',
                'brand_url.required'=>'品牌网址必填'
        ]);
        if ($validator->fails()) {
            return redirect('brand/create')
            ->withErrors($validator)
           ->withInput();
        }
        
        /*只接收某个字段的值 
        $post=$request->only(['brand_name','brand_desc']);*/


        /*文件上传*/
        if($request->hasFile('brand_logo')){
            $post['brand_logo']=$this->upload('brand_logo');
        }
        // dd($post);


        //DB添加
        /*$res=DB::table('brand')->insert($post);//返回的是布尔类型的值
        $res=DB::table('brand')->insertGetId($post);//这里返回的是自增的id/数据库数据的数量*/


        //ORM添加
        $brand=Brand::create($post);
        // echo $brand->brand_id;


        /*这里是save添加*/
        /*$brand=new Brand;
        $brand->brand_name=$post['brand_name'];
        $brand->brand_url=$post['brand_url'];
        $brand->brand_logo=$post['brand_logo'];
        $brand->brand_desc=$post['brand_desc'];
        $brand->save();*/


        if($brand->brand_id){
            return redirect('/brand/index');
        }
    }


    /*删除*/
    public function destroy($id){
        
        if(!$id){
            abort(404);
        }


        /*DB删除*/
        // $res=DB::table('brand')->where('brand_id',$id)->delete();
        /*ORM删除*/
        $res=Brand::destroy($id);
        // $res=Brand::where('brand_id',$id)->delete();
        if($res){
            return redirect('/brand/index');
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


    /*展示修改视图*/
    public function edit($id){
        if(!$id){
            return;
        }
        /*DB单条查询*/
        /*$data=DB::table('brand')->where('brand_id',$id)->first();*/
       
        /*ORM单条查询*/
        /*$data=Brand::find($id);*/
        $data=Brand::where('brand_id',$id)->first();
        // dd($data);
        return view('admin.brand.edit',['data'=>$data]);
    }


    /*执行修改*/
    public function update(StoreBrandPost $request,$id){
        /*接值并去除_token*/
        $post=$request->except('_token');
        /*判断有无文件上传*/
        if($request->hasFile('brand_logo')){
            $post['brand_logo']=$this->upload('brand_logo');
        }


        /*更新进入数据库*/
        $data=Brand::where('brand_id',$id)->update($post);
        return redirect('/brand/index');
    }

  /*js验证*/
     public function checkOnly(){
        $brand_name=request()->brand_name;
        $count=Brand::where('brand_name',$brand_name)->count();
        // echo $count;
    }
}