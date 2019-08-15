<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function __construct()
    {
        $this->request = request();

        // 验证是否登录
        $this->middleware(function ($request, $next) {
            if (!\Session::get('admin')) {
                redirect('index/login')->send();exit();
            }
            return $next($request);
        });
    }
}
