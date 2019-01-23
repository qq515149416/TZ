<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')-腾正科技有限公司</title>
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/css/index.css") }}" />
</head>
<body>
    <div class="container-fluid main">
        @yield('content')
    </div>
    <script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
</body>
</html>
