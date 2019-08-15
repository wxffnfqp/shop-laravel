<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use think\Console;

//use App\Index;

class GoodsController extends Controller
{
    public function index(){
        return view('index/index');
    }
    public function goods_category()
    {
        //查出的是数组格式，不是对象格式
//        $arr = DB::table('goods_category')->get()->map(function ($value) {
//            return (array)$value;
//        })->toArray();;
        $arr = DB::select("select * from goods_category");
        $res = $this->tree($arr,0,0);
        return $res;
    }
    //无限极递归
    function tree($arr,$id,$level)
    {
        $list =array();
        foreach ($arr as $k=>$v){
            if ($v->pid == $id){
                $v->level=$level;
                $v->son = $this->tree($arr,$v->id,$level+1);
                $list[] = $v;
            }
        }
        return $list;
    }
    public function floor()
    {
        $my_res = [];
        $arr = DB::table('floor_category')
            ->join('floor', 'floor.floor_cate_id', '=', 'floor_category.id')
            ->join('goods', 'floor.goods_id', '=', 'goods.id')
            ->join('goods_img', 'floor.goods_id', '=', 'goods_img.goods_id')
            ->select('floor_category.cate_name', 'floor_category.floor', 'goods.goods_name','goods.id', 'goods.goods_price','goods_img.big_img')
            ->orderBy('floor_category.id')
            ->get();
//        var_dump($arr);
//        $res = $this->floor_tree($arr,0,0);
//        var_dump($res);
        foreach ($arr as $k => $v){
            $a = "http://www.hzy.com/uploads/goodsimg/";
            $v->big_img = $a.$v->big_img;
            $my_res[$v->cate_name][]=$v;
        }
        $my_res = json_encode($my_res, JSON_UNESCAPED_SLASHES);
        return $my_res;
    }
//    public function goods(Request $request)
//    {
//        $my_res = [];
//        $id=$request->input('id');
//        $arr = DB::table('goods_attr')
//            ->join('attribute', 'attribute.id', '=', 'goods_attr.attr_id')
//            ->join('attr_details', 'attr_details.id', '=', 'goods_attr.attr_details_id')
//            ->select('attr_details.name as ad_name', 'attribute.name as a_name','goods_attr.*')
//            ->where('goods_attr.goods_id',$id)
//            ->get();
//
//        foreach ($arr as $k => $v){
//            $my_res[$v->a_name][]=$v;
//        }
////        var_dump($res);
////        $my_res = json_encode($my_res, JSON_UNESCAPED_SLASHES);
//        return $my_res;
//    }
    public function goods(Request $request){
//        var_dump($request->input('id'));
        $id=$request->input('id');
        $arr = DB::select("select * from one_goods where goods_id = '$id'");
//        $res = DB::table('one_goods')->where('goods_id',$id)->get();

        return response()->json($arr);
    }
    public function one_goods(Request $request){
        $id=$request->input('id');
        $res = DB::table('one_goods')->where('id',$id)->first();
        return response()->json($res);
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