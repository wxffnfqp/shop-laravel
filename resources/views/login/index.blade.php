
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
</body>
    <input type="text" id="name">
    <input type="text" id="pwd">
    <button onclick="login()">登录</button>
    <script type="text/javascript" src="{{asset('js/jquery.js') }}"></script>
    <script type="text/javascript"  src="{{asset('js/app.js') }}"></script>
    <script>
        function login(){
            var name = $('#name').val()
            var password = $('#pwd').val()
            $.ajax({
                url:'/laravel/public/index/loginaction/',
                data:{
                    {{--'_token':'{{csrf_token()}}',--}}
                    name:name,
                    password:password,
                },
                dataType:'json',
                // type:'post',
                success:function (res) {
                    if (res.code=='0'){
                        window.location.href = "/laravel/public/index/index/";
                    }
                    if (res.status=='error'){
                        alert(res.message)
                    }
                }
            })
        }
    </script>
</html>

