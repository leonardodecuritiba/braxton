<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon-->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gestão de Obras') }} - @yield('title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
{{Html::style('bower_components/bootstrap/dist/css/bootstrap.css')}}

<!-- Waves Effect Css -->
{{Html::style('bower_components/adminbsb-materialdesign/plugins/node-waves/waves.css')}}

<!-- Animation Css -->
{{Html::style('bower_components/adminbsb-materialdesign/plugins/animate-css/animate.css')}}

<!-- Custom Css -->
    {{Html::style('bower_components/adminbsb-materialdesign/css/style.css')}}

</head>
<body class="login-page">

@yield('page_content')

<!-- Jquery Core Js -->
{{Html::script('bower_components/adminbsb-materialdesign/plugins/jquery/jquery.min.js')}}

<!-- Bootstrap Core Js -->
{{Html::script('bower_components/bootstrap/dist/js/bootstrap.js')}}

<!-- Waves Effect Plugin Js -->
{{Html::script('bower_components/adminbsb-materialdesign/plugins/node-waves/waves.js')}}

<!-- Jquery Validation Plugin Css -->
@include('layouts.inc.validation.js')

<!-- Custom Js -->
{{Html::script('bower_components/adminbsb-materialdesign/js/admin.js')}}

</body>

</html>
