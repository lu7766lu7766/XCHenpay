<!DOCTYPE html>
<html lang="zh-Hans-TW">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>龙亨支付</title>
    <meta content="Admin Dashboard" name="description"/>
    <meta content="Themesbrand" name="author"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link href="{{ asset('plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

    <!-- default style -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <!-- myself style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    @yield('header_styles')
</head>

<body>

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <!-- Logo container-->
        @include('admin.layouts.logo')
        <!-- End Logo container-->

            <!-- Topbar container-->
        @include('admin.layouts.topbar')
        <!-- End Topbar container-->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="container-fluid">
        @yield('breadcrumb')
    </div>

    <!-- MENU Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            @include('admin.layouts.menu')
        </div> <!-- end navigation -->
    </div> <!-- end container-fluid -->
</header>
<!-- End Navigation Bar-->

<div id="app" class="wrapper">
    <div class="container-fluid">
        @include('notifications')
        @yield('content')
    </div> <!-- end container -->
</div>
<!-- end wrapper -->

@yield('modal')

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/waves.min.js') }}"></script>

<script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

<!-- App js -->
{{--<script src="{{ asset('assets/js/app.js') }}"></script>--}}

<script src="{{ asset('plugins/datepicker/js/moment.min.js') }}"></script>
<script src="{{ asset('plugins/datepicker/js/moment_zh-cn.js') }}"></script>
<script src="{{ asset('plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('plugins/sweet-alert2/sweetalert2.min.js') }}"></script>

<script src="{{ asset('assets/js/App.js') }}"></script>

@yield('footer_scripts')
</body>
</html>
