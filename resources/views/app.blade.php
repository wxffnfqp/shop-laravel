<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>hangge.com</title>
    <script type='text/javascript'>
    </script>
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>