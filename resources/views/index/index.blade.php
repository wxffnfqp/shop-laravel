
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
</head>
</body>
    <a href="/index/out">退出</a>
    <div id="add_show" >
        <input type="text" id="name"><br>
        <input type="text" id="pwd"><br>
        <button id="add_action">添加</button>
    </div>
    <div id="up_show" style="display: none">
        <input type="text" id="up_id"><br>
        <input type="text" id="up_name"><br>
        <input type="text" id="up_pwd"><br>
        <button id="up_action">修改</button><button id="up_hide">收起</button>
    </div>
    <table id="table_show" border="1">
        <thead>
            <th>ID</th>
            <th>姓名</th>
            <th>密码</th>
            <th>操作</th>
        </thead>
        <tbody>

        </tbody>
    </table>
    <script type="text/javascript" src="{{asset('js/jquery.js') }}"></script>
    <script type="text/javascript"  src="{{asset('js/app.js') }}"></script>
    <script>
        function shwo(){
            $.ajax({
                url:'/index/index/show/',
                dataType:'json',
                type:'post',
                success:function (res) {
                    var tr = ''
                    //console.log(res)
                    $.each(res,function (k,v) {
                        //alert(v)
                        tr += "<tr>";
                        tr += "<td>"+v.id+"</td>";
                        tr += "<td>"+v.name+"</td>";
                        tr += "<td>"+v.password+"</td>";
                        tr += "<td><button onclick='del("+v.id+")'>删除</button> <button onclick=update("+v.id+",'"+v.name+"','"+v.password+"')>修改</button></td>";
                        tr += "</tr>";
                    })
                    console.log(tr)

                     $('#table_show tbody').html(tr)
                }
            })
        }
        shwo()
        function del(id) {
            console.log(id)
            var url = '/index/delete/'
            $.get(url,{id:id},function (res) {
                if (res.code=='0'){
                    shwo()
                }
            },'json');
        }
        $('#add_action').click(function () {
            {{--_token:'{{csrf_token()}}'--}}
            var url = '/index/add/'
            var name = $('#name').val()
            var pwd = $('#pwd').val()
            $.get(url,{name:name,pwd:pwd},function (res) {
                if (res.code=='0'){
                    alert(res.message)
                    history.go(0)
                }
            },'json');
        })
        $('#up_hide').click(function () {
            $('#up_show').css('display','none')
            $('#add_show').css('display','block')
        })
        function update(id,name,pwd) {
            $('#up_show').css('display','block')
            $('#add_show').css('display','none')
            $('#up_id').val(id)
            $('#up_name').val(name)
            $('#up_pwd').val(pwd)
        }
        $('#up_action').click(function () {
            var url = '/index/update/'
            var id = $('#up_id').val()
            var name = $('#up_name').val()
            var pwd = $('#up_pwd').val()
            console.log(id)
            console.log(name)
            console.log(pwd)
            $.get(url,{id:id,name:name,pwd:pwd},function (res) {
                if (res.code=='0'){
                    alert(res.message)
                    history.go(0)
                }
            },'json');
        })
    </script>
</html>

