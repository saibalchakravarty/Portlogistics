<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Base Meta Tags --}}
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Port Logistics</title>
        <link rel="stylesheet" href="{{ theme('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"/>
        <link rel="stylesheet" href="{{theme('plugins/fontawesome-free/css/all.min.css')}}"/>
        <link rel="stylesheet" href="{{theme('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}"/>
        <link rel="stylesheet" href="{{theme('dist/css/adminlte.min.css')}}"/>
        <link rel="stylesheet" href="{{css('custom')}}"/>
        <style>
            .login-body-custom{
                background-image:url("{{images('login_bg')}}");
            }
        </style>

    </head>

    <body class="login-page login-body-custom">
        <!-- Start Flash Message -->
        @if (\Session::has('success'))
        <div class="alert alert-success">
            {!! \Session::get('success') !!}
        </div>
        @endif
        @if (\Session::has('error'))
        <div class="alert alert-danger">
            {!! \Session::get('error') !!}
        </div>
        @endif
      
        <!-- End Flash Message -->
        <div class="login-box">
            <!-- <div class="login-logo">
                <a href="javascript:void(0);">
                    <img src="{{theme('dist/img/Logo.png')}}" height="50"/>
                </a>
            </div> -->
            <div class="">
                @yield('content')
            </div>
        </div>
    </body>
    <script src="{{theme('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{theme('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{theme('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{theme('dist/js/adminlte.js')}}"></script>
</html>