@extends('layouts.shop')
@section('title', '珠宝商城')
@section('content')
    <div class="maincont">
        <header>
            <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
            <div class="head-mid">
            <h1>购物车</h1>
            </div>
        </header>
    <div class="head-top">
        <img src="/static/index/images/head.jpg" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$count}}</strong>件商品</span></td>
            <td width="25%" align="center" style="background:#fff url(/static/index/images/xian.jpg) left center no-repeat;">
                <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" class="check1"/> 全选</a></td>
        </tr>
    </table>
    @foreach($data as $v)
    <div class="dingdanlist">
        <table> 
            <tr goods_id="{{$v->goods_id}}" id="a">
                <td width="4%"><input type="checkbox" name="1" class="check2"/></td>
                <td class="dingimg" width="15%"><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" /></td>
                <td width="50%">
                    <h3>{{$v->goods_name}}</h3>
                    <time>下单时间：{{date("Y-m-d h:i:s",$v->add_time)}}</time>
                </td>     
                <td align="right">
                    <button style="width:25px;" class="less">-</button>
                    <input type="text"   style="width:30px;text-align:center;" value="{{$v->buy_number}}" class="buy_number">
                    <button style="width:25px;" class="add">+</button>
                </td>
                <input type="hidden" class="goods_num" value="{{$v->goods_num}}">
            </tr>
            <tr>
                <th colspan="4"><strong class="orange">¥{{$v->add_price*$v->buy_number}}</strong></th>
            </tr>
            <tr>
                <td colspan="4"><a href="javascript:;" class="del"> 删除</a></td> 
            </tr>
        </table>
    </div><!--dingdanlist/-->
    @endforeach
    <div class="height1"></div>
    <div class="gwcpiao">
         <table>
            <tr>
            <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
            <td width="50%">总计：<strong class="orange" id="count">¥0</strong></td>
            <td width="40%"><a href="pay.html" class="jiesuan">去结算</a></td>
            </tr>
        </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <script src="/static/admin/js/jquery-3.1.1.min.js"></script>
        <script>         
            /*点击全选*/
            $(document).on('click',".check1",function(){
                var status=$(".check1").prop("checked");//获取第一个复选框的状态
                $(".check2").prop("checked",status);//所有复选框和第一个保持一致
                getCount();
            })
            /*点击减号*/
            $(document).on('click',".less",function(){
               var _this=$(this);
               var goods_id=_this.parents("tr").attr("goods_id");
               var buy_number=parseInt(_this.next('.buy_number').val());
               
               if(buy_number<=1){
                    _this.next('.buy_number').val(1);
               }else{
                  buy_number=buy_number-1;
                  _this.next('.buy_number').val(buy_number);
               }
               changeNum(goods_id,buy_number);
               getTotal(goods_id,_this);
               getCount();
            })
            /*点击加号*/
            $(document).on('click',".add",function(){
               var _this=$(this);
               var goods_id=_this.parents("tr").attr("goods_id");
               var buy_number=parseInt(_this.prev('.buy_number').val());
               var goods_num=$(this).parent().next().val();//获取库存
               
               if(buy_number>=goods_num){
                    _this.prev('.buy_number').val(goods_num);
               }else{
                  buy_number=buy_number+1;
                  _this.prev('.buy_number').val(buy_number);
               }
               changeNum(goods_id,buy_number);
               getTotal(goods_id,_this);
               getCount();
            })
            //文本框的失去焦点
            $(document).on('blur','.buy_number',function(){
                var _this=$(this);
                var goods_id=_this.parents('tr').attr('goods_id');
                
                var buy_number=parseInt($(this).val());
                var goods_num=_this.parent().next().val();//库存
                var number=/^\d+$/;
                if(parseInt(buy_number)>=goods_num){
                    _this.val(goods_num);
                }else if(!number.test(buy_number)||parseInt(buy_number)<=0){
                    _this.val(1);
                }else{
                    _this.val(buy_number);
                }
                changeNum(goods_id,buy_number);
                getTotal(goods_id,_this);
                getCount();
            });

            
            //修改数据库的购买数量
            function changeNum(goods_id,buy_number){
                $.post(
                    "{{url('index/change')}}",
                    {goods_id:goods_id,buy_number:buy_number},
                    function(res){
                        if(res==2){
                            alert('购买数量修改失败');
                        }
                    }
                )
            }

            // 获取小计
            function getTotal(goods_id,_this){
                $.post(
                    "{{url('index/getTotal')}}",
                    {goods_id:goods_id},
                    function(res){
                        _this.parents("tr").next().find('.orange').text('￥'+res);
                    }
                )
            }

            // 重新获取总价
            function getCount(){
                var _box=$(".check2:checked");
                // alert(_box);
                var goods_id="";
                _box.each(function(index){
                    goods_id+=$(this).parents("tr").attr("goods_id")+',';
                })
                // console.log(goods_id);return;
                goods_id=goods_id.substr(0,goods_id.length-1);
                // alert(goods_id);return;
                $.post(
                    "{{url('index/getCount')}}",
                    {goods_id:goods_id},
                    function(res){
                        // console.log(res);
                        $("#count").text('￥'+res);
                    }
                )
            }
           
        </script>


    @endsection