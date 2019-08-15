<?php


namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
//use App\Index;

class IndexController extends CommonController
{
    public function index(){
        return view('index/index');
    }
    public function show()
    {

//        $res = DB::table('admin')->get();
        $res = DB::select("select * from admin");
//        var_dump($res);die;
        return response()->json($res);
//        return json_encode($res);
//        return response()->json($arr);
    }
    public function delete(){
        $id = $_GET['id'];
        $res = DB::delete("delete from admin where id = '$id' ");
        $arr = ['code'=>'0','message'=>'删除成功'];
        return json_encode($arr);
    }
    public function add(){
        $name = $_GET['name'];
        $pwd = $_GET['pwd'];
        $res = DB::insert("insert into admin (`name`,`password`) values ('$name','$pwd' )");
        $arr = ['code'=>'0','message'=>'添加成功'];
        return json_encode($arr);
    }
    public function update(){
        $id = $_GET['id'];
        $name = $_GET['name'];
        $pwd = $_GET['pwd'];
        $str = ['name'=>$name,'password'=>$pwd];
        DB::table('admin')->where('id',$id)->update($str);
//        DB::update("update admin set `name` = '$name' and `password` = '$pwd' where id = '$id' ");
        $arr = ['code'=>'0','message'=>'修改成功'];
        return json_encode($arr);
    }
    /**
     * 创建新文章表单页面
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * 将新创建的文章存储到存储器
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 显示指定文章
     *
     * @param int $id
     * @return Response
     */
//    public function show($id)
//    {
//        $res = DB::select('select * from admin order by id');
//        $arr = ['data'=>$res];
//        return json_encode($arr);
////        return response()->json($arr);
//    }

    /**
     * 显示编辑指定文章的表单页面
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 在存储器中更新指定文章
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     * 从存储器中移除指定文章
     *
     * @param int $id
     * @return Response
     */
    public function destroy()
    {
       $id = $_POST['id'];
       echo $id;
        $res = DB::delete("delete from admin where id = '$id' ");
        var_dump($res);die;
        $arr = ['data'=>$res];
        return json_encode($arr);
    }
}