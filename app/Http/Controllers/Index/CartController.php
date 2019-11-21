<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Cart;

class CartController extends Controller
{
    // 加入购物车
    public function addCart(){
        if(session()->has('user_id')){
            $goods_id=request()->goods_id;
            $buy_number=request()->buy_number;
            $user_id=session('user_id');
            $add_price=Goods::where('goods_id',$goods_id)->value('goods_price');
            $where=[
                ['goods_id','=',$goods_id],
                ['user_id','=',$user_id],
                ['is_del','=',1]
            ];
            $cartInfo=Cart::where($where)->first();
            if(!empty($cartInfo)){
                $result=$this->checkGoodsNum($goods_id,$buy_number,$cartInfo['buy_number']);
                if(empty($result)){
                    echo 3;exit;
                }
                // 累加
                $res=$cartInfo->where($where)->update(['buy_number'=>$cartInfo['buy_number']+$buy_number,'add_time'=>time()]);
            }else{
                $result=$this->checkGoodsNum($goods_id,$buy_number,$cartInfo['buy_number']);
                if(empty($result)){
                    echo 3;exit;
                }
                //添加
                $arr=['goods_id'=>$goods_id,'buy_number'=>$buy_number,'add_time'=>time(),'user_id'=>$user_id,'add_price'=>$add_price];
                $res=Cart::create($arr);
                if($res){
                    echo 1;
                }else{
                    echo 4;
                }
            }            
        }else{
            echo 2;
        }
    }

    // 检测库存
    public function checkGoodsNum($goods_id,$buy_number,$already_number=0){
        //根据商品Id查询此商品的库存
        $goods_num=Goods::where('goods_id',$goods_id)->value('goods_num');
        if($buy_number+$already_number>$goods_num){
            return false;
        }else{
            return true;
        }
    }

    // 购物车列表
    public function cart(){
        $data=Cart::Join('goods','cart.goods_id','=','goods.goods_id')->get();
        $count=Cart::count();
        return view('index/index/cart',['data'=>$data,'count'=>$count]);
    }

    /** 修改购买数量 */
    public function change(){
        $goods_id=request()->goods_id;
        $buy_number=request()->buy_number;
        $user_id=session('user_id');
        $where=[
            ['user_id','=',$user_id],
            ['goods_id','=',$goods_id],
            ['is_del','=',1]
        ];
        $res=Cart::where($where)->update(['buy_number'=>$buy_number]);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }

    /** 重新获取小计 */
    public function getTotal(){
        $goods_id=request()->goods_id;
        $user_id=session('user_id');
        $where=[
            ['user_id','=',$user_id],
            ['goods_id','=',$goods_id],
            ['is_del','=',1]
        ];
        $goodsInfo=Cart::where($where)->first();
        $total=$goodsInfo['add_price']*$goodsInfo['buy_number'];
        echo $total;
    }

    /** 重新获取总价 */
    public function getCount(){
        $goods_id=request()->goods_id;
        $goods_id=explode(',',$goods_id);
        // echo $goods_id;exit;
        $user_id=session('user_id');
        // echo $user_id;die;
        $where=[
            ['user_id','=',$user_id],
            ['is_del','=',1]
        ];
        $goodsInfo=Cart::where($where)->whereIn('goods_id',$goods_id)->get();
        // print_r($goodsInfo);exit;
        $count=0;
        foreach($goodsInfo as $k=>$v){
            $count+=$v['add_price']*$v['buy_number'];
        }
        echo $count;
    }

   
    
}
