<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;


class IndexController extends Controller
{
    // 首页
    public function index(){
        $data=Goods::get();
        // dd($data);
        return view('index/index/index',['data'=>$data]);
    }

    // 详情页
    public function proinfo($goods_id){
        $goodsInfo=Goods::where('goods_id',$goods_id)->first();
        // dd($goodsInfo);
        return view('index/index/proinfo',['goodsInfo'=>$goodsInfo]);
    }

    // 商品列表页
    public function prolist(){
        $data=Goods::get();
        // dd($goodsInfo);
        return view('index.index.prolist',['data'=>$data]);
    }

    
}
