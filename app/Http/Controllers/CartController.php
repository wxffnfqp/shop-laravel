<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //api中间件验证
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function my_car(){
        $arr = auth()->user();
        $id= $arr->id;
        $res = DB::table('shop_car')
            ->join('one_goods as og', 'og.id', '=', 'shop_car.one_goods_id')
            ->select('og.name as og_name','shop_car.id','og.attr_name','og.price','shop_car.num')
//            ->orderBy('')
            ->where('u_id',$id)->get();
        return response()->json($res);
    }
    public function add_car(Request $request)
    {
        $data = $request->input();
//        var_dump($data);
        $arr = auth()->user();
        $u_id = $arr->id;
        $res = DB::table('shop_car')->where('u_id',$u_id)->where('one_goods_id',$data['one_goods_id'])->first();
        if (!empty($res)){
            $num = $res->num + $data['num'];
            $up = ['num' => $num];
            DB::table('shop_car')->where('id',$res->id)->update($up);
            $json = ['code'=>'200','status'=>'success','message'=>'添加成功'];
            return $json;
        }
//        $id = DB::table('goods')->insertGetId($row);//获取自增id
        $data['u_id']=$u_id;
//        array_push($data,['u_id'=>$u_id]);//向数组追加元素
        unset($data['token']);
//        var_dump($data);
        DB::table('shop_car')->insert($data);
    }
    public function up_car(Request $request){
        $data = $request->input();
//        var_dump($data);
        auth()->user();
        $id = $data['id'];
        $num = $data['num'];
        DB::table('shop_car')->where('id',$id)->update(['num'=>$num]);
        $json = ['code'=>'200','status'=>'success','message'=>'添加成功'];
        return $json;
    }
    public function del(Request $request){
        $id = $request->input('id');
        DB::delete("delete from shop_car where id = '$id' ");
        $arr = ['code'=>'200','status'=>'success','message'=>'删除成功'];
        return $arr;
    }
    public function myCarTwo(Request $request){
        DB::connection()->enableQueryLog();#开启执行日志
        $arr = auth()->user();
        $id= $arr->id;
        $ids = $request->input('ids');
        $res = DB::table('shop_car')
            ->join('one_goods as og', 'og.id', '=', 'shop_car.one_goods_id')
            ->select('og.name as og_name','shop_car.id','og.attr_name','og.price','shop_car.num')
//            ->orderBy('')
            ->where('u_id',$id)
            ->whereIn('shop_car.id',$ids)
            ->get();
        // 获取查询日志
//        $logs = DB::getQueryLog();
//        print_r($logs);
//        var_dump($logs);
        return $res;
//        return response()->json($res);
    }
}
