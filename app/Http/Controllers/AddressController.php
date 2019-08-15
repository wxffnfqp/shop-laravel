<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use think\Console;


class AddressController extends Controller
{
    public function areashow(Request $request){
        $pid = $request->input('pid');
        $res = DB::select("select * from area where `parent_id` = '$pid'");
        return $res;
    }
    public function add(Request $request){
        $data = $request->input();
        $arr = auth()->user();
        $u_id = $arr->id;
//        $id = DB::table('goods')->insertGetId($row);//获取自增id
        $data['u_id']=$u_id;
        unset($data['token']);
        DB::table('address')->insert($data);
        $json = ['code'=>'200','status'=>'success','message'=>'添加成功'];
        return $json;
    }
    public function show(){
        $arr = auth()->user();
        $u_id = $arr->id;
        $res = DB::select("select * from address where `u_id` = '$u_id' order by id");
        return $res;
    }
    public function del(Request $request){
        $arr = auth()->user();
        $u_id = $arr->id;
        $id = $request->input('id');
        DB::delete("delete from address where id = '$id' and u_id = '$u_id' ");
        $arr = ['code'=>'200','message'=>'删除成功'];
        return $arr;
    }
}
