<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>龙亨支付</title>
    <meta content="Admin Dashboard" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <!-- default style -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <!-- myself style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<!-- Begin page -->
<div class="wrapper-page">
    <div class="card">
        <div class="card-block">

            <div class="ex-page-content text-center">
                <h1 class="text-dark">404!</h1>
                <h4 class="">抱歉, 您访问的网页不存在</h4><br>
                <a class="btn btn-primary mb-5 waves-effect waves-light" href="{{ URL::to('admin/logQuery') }}"><i class="mdi mdi-home"></i> 返回首页</a>
            </div>

        </div>
    </div>

</div>


<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/waves.min.js') }}"></script>

<script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

</body>
</html>
