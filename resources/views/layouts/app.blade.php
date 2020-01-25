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

    <title>{{ config('app.name', 'Braxton') }} - @yield('title')</title>

    @include('layouts.inc.head')

    @if(!Auth::check())
        <style>
            section.content {
                margin: 0 !important;
            }
        </style>
    @endif
</head>

<body class="theme-light-blue">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-indigo">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Aguarde ...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

@if(Auth::check())
    @include('layouts.inc.navbar')

    <section>

        @include('layouts.inc.sidebar')

    </section>
@endif
<section class="content">

    @if(Auth::check())
        @include('layouts.inc.alerts')
    @endif
    @yield('page_modals')
    @yield('page_content')
</section>


@include('layouts.inc.foot')

</body>
</html>
