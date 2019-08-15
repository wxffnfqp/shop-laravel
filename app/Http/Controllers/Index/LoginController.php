<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index(){
        return view('login/index');
    }
    public function loginaction(Request $request){
//        var_dump($_POST);die;
        $name = $_GET['name'];
        $password = $_GET['password'];
//        var_dump($password);die;
        $res = DB::select("select * from admin where `name` = '$name' and `password` = '$password'");
        if (empty($res)){
            $arr = ['code'=>'1','status'=>'error','message'=>'登录失败'];
            echo json_encode($arr);
        }else{
            //$request->Session::put('name', $name);
            $request->session()->put('admin', $name);
            $arr = ['code'=>'0','status'=>'success','message'=>'登录成功'];
            return json_encode($arr);
        }
    }
    public function out(Request $request){
        $request->session()->forget('admin');
        redirect('index/login')->send();
//        $request->session()->flush();//移除所有
    }
}
