<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Math\Adder;

class OrderController extends Controller
{
    public function add(Request $request){
        $data = $request->input();
        $arr = auth()->user();//根据token获取用户信息
        $u_id = $arr->id;//获取用户id
//        $id = DB::table('goods')->insertGetId($row);//获取自增id
        $goods_arr = $data['arr'];//订单对应的货品的数组
        $data['u_id']=$u_id;
        unset($data['token']);
        unset($data['arr']);
        //var_dump($data);die;
        DB::beginTransaction();//手动开启事务从而对回滚和提交有更好的控制
        $id = DB::table('goods_order')->insertGetId($data);//添加订单并获取自增id
        if (empty($id)){
            DB::rollBack();//通过 rollBack 方法回滚事务：
            $json = ['code'=>'1','status'=>'error','message'=>'提交失败'];
            return $json;
        }
        $order_sn = 'DSN'.date('Ymd').mt_rand(999, 9999).$id;//拼接订单编号
        $res2 = DB::table('goods_order')->where('id',$id)->update(['order_sn'=>$order_sn]);
        if ($res2 != 1){
            DB::rollBack();
            $json = ['code'=>'1','status'=>'error','message'=>'提交失败'];
            return $json;
        }
        foreach ($goods_arr as $v){
            $data2 = ['one_goods_id'=>$v['id'],'one_goods_name'=>$v['og_name'],'one_goods_attr_name'=>$v['attr_name'],'order_num'=>$v['num'],'order_price'=>$v['price'],'goods_order_id'=>$id];
            //订单不只一件商品，所以生成订单的同时，在把订单货品添加至数据裤
            $res3 = DB::table('user_order')->insert($data2);
            $car_id = $v['id'];
            //订单生成后会删除购物车的货品
//            $res4 = DB::delete("delete from shop_car where id = '$car_id' and u_id = '$u_id' ");
//            if ($res3 != 1 || $res4 != 1){
//                DB::rollBack();
//                $json = ['code'=>'1','status'=>'error','message'=>'提交失败'];
//                return $json;
//            }
        }
        DB::commit();//通过 commit 方法提交事务：
        $json = ['code'=>'200','status'=>'success','message'=>'添加成功','order_sn'=>$order_sn];
        return $json;
    }
    public function pay(Request $request){
        $data = $request->input();
        var_dump($data);die;
        $order_sn = $data['out_trade_no'];
        DB::table('goods_order')->where('order_sn',$order_sn)->update(['status'=>1]);
        $json = ['code'=>'200','status'=>'success','message'=>'添加成功'];
        return $json;
    }
//    private function shiwu($data,$goods_arr){
////        DB::table('goods_order')->insert($data);
//            $id = DB::table('goods_order')->insertGetId($data);//获取自增id
//            $order_num = 'DSN'.$id;
//            DB::table('goods_order')->where('id',$id)->update(['order_num'=>$order_num]);
//            foreach ($goods_arr as $v){
//                $data2 = ['one_goods_id'=>$v['id'],'one_goods_name'=>$v['og_name'],'one_goods_attr_name'=>$v['attr_name'],'order_num'=>$v['num'],'order_price'=>$v['price'],'goods_order_id'=>$id];
//                DB::table('user_order')->insert($data2);
//            }
//
//    }
}
