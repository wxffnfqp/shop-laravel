<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['notify','return']]);
    }
    protected $config = [
        'alipay' => [
            'app_id' => '2016101000650431',             // 支付宝提供的 APP_ID
            // 支付宝公钥，1行填写
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3bDz1ggIcEMb4wb0ZebuNMp6qHUCatH8JRBOcY4Wd8A2LtEou9+Yda9kOvOXeYKyo/r6Im8/Bp8lW1AeLdJzx6AP71GDPZt1SoJpuj8B/T3Ic3qgaGCac2hmajrSe9vdDpicrJBXhPQAq0Kr8jK80ww3qVuvSXbBYK/jVv7J4ZOmVygy5kJny86Kwkce1pPOFw/1rCLQ22xBunUrHKcpaX1f77Eplx1+KcR5CHxjnTAK86BVngSzxcU3yvCW1GjNXgs+nD6sgEW6LCtt1avhDx80Rix63oBfh2y67GF3+88QaObuVaPRfcC0PcN7PlJWVGgen7cQyJL+TbxFqdBEOQIDAQAB',     // 支付宝公钥，1行填写
            // 自己的私钥，1行填写
            'private_key' => 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCIxt/ibmYpBU5tBSIQZgHplhyhjW/pRSE8RdACU7ZnGSQJsAPjpkaZqiKrjto+VdHnf7Jd8c5SurAAB0JxsvRly427/lNGAPVO6jLEP+kX/wtv2cwMjlm1bP6bxBZfVK/i2nrR58t+fxcTcMjrBQorAdcXT7lSXc6TM76gvGvQ+LwIvZKwZJjNPKffX+XzXBDaG3TplLf1Pyzp4LXtcKg5Ck5vPJgPlE1YrwktN123AxeAM6DLUHX/9TdIJ+zCaENwDWjdehVP9KP4tQ8lIEHgkeTDqMbomqsIYFsM3WqOaHHHPB8OnMYEWCu/OaPl11XLwrKHxV0aNsTKUWmiDLxRAgMBAAECggEAcPFwDIVHPNZR5XpYn5vsNlurdsfZQpHAGQo48sL3mvjKpmk/POuf3uH70RicJN8u/m+W9TZoPi5EiTF1b3frkmdcuYEQeHzwE+MWWrG/o/4KDqmVckTV1ReUw0FPjBbdSoFI7C3w/pqpjncSoec+dzcEyw4dJOOrYihXYFlW2m5looM5g/M4mJCwqEh81i6iUQM0RLe9MOG/RoYG87U2SFlqsUctrqkYRMUk/sEP9uaQnsS2LdxjfvYNcl4GfNDXWIWc0ky78JnZn4c0yp0NNBWe/X8YH4vgvgAukNn/qC497sf+3q061nKiDk1Fu9SEL0Sh5TsqyL7UParqB+bytQKBgQC8yC2lL6GhqjlAXzPeVYhkD1pskQ1PLP/F9kHEt5bRF0TGl4ioMGgJKT3e6eYGm58Su5DjGCYKhNpul3uwFKgwLawO0JwbfGJwrTzauT0F1X867MvOa4zrWGluzbm07eXNJ4ZPyQCxrNsOzBm1J1H8HinVPPdg7IFfHYdSqcocnwKBgQC5elYcjmyrTtly0iQpkZ1/v/wnJ+d4yYoU6NHZeo5KK4qfIxCgXf5j7+BhSxIb7vbSfamekNfioX6khzx3NbedyQiuir9gwDqm8HhLCyK5LG7jhIOuAP3o4/jP9n7SMY6f9tdpd/N7eQQm7AD4qxY8WGlLOFKCfLDRcBxUq6GRDwKBgDSf5MGAdqEXT6BXKaFX3I5wDTfoc3pXw/EORaUtvFgLEXv+r/SakdXD7mBeeWXsKbrSGICFsc0K3c0oYy1hhMTxZl423t12ngZk9GrQamde7Xmimumu53iPi8x8gsEh9AZtdy50jMH6upH0aVIrZNpQGj88IIWfSC0YkSmE9TdnAoGASUiC2YmUeiMPW4SX8SytlBog4L+tf1XyDszmjQ0VR0zo2nOaUCKTLp1KhGaK4yqJryUjbZlBEzRHu24Lf/ZjdB5IJd6AOxP4mJkOjmf58jwSHCbxeEDAEdJxLonwFdCqz51SA0P3meN4toAs6hN/F5y/DY9VWmU136pyJyohDhUCgYBEr6n/JFT9yRc6XovOjS+8ynaBaxbBgde9HJbEiP0LFjOAdvCGYs9fMS2HKYun+oyYLY5FfkfhkKPxOM28XJgW5I/ex190yLKnWh8irdQWdQAfqqabiEKk3jK04nNtiygYdBq1MpJem0TrbTYvlqrliC+keLpFjXQ6BPVmDiSs2g==',        // 自己的私钥，1行填写
//            'return_url' => 'http://www.blog.com/api/order/pay',         // 同步通知 url，*强烈建议加上本参数*
            'return_url' => 'https://laravel.1221y.com/api/pay/return',         // 同步通知 url，*强烈建议加上本参数*
            'notify_url' => 'https://laravel.1221y.com/api/pay/notify',         // 异步通知 url，*强烈建议加上本参数*
        ],
    ];

    public function index(Request $request)
    {
        $data = $request->input();
        $order_sn = $data['order_sn'];
        $total_amount = DB::table('goods_order')->where('order_sn', $order_sn)->value('total_price');
        $config_biz = [
            'out_trade_no' => $order_sn,
            'total_amount' => $total_amount,
            'subject'      => 'test subject',
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);

        $arr = $pay->driver('alipay')->gateway()->verify($request->all());
        $order_id=$arr['out_trade_no'];
        $total_price=$arr['total_amount'];
        $order_time=$arr['timestamp'];
        header("location:http://vue.1221y.com/#/shop_car3?order_id=$order_id&total_price=$total_price&order_time=$order_time");
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            DB::table('goods_order')->where('order_sn',$request->out_trade_no)->update(['status'=>1]);
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}
