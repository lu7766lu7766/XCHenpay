<!DOCTYPE html>
<html lang="zh-Hans-TW">
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
    <link href="{{ asset('assets/css/icons.cs') }}s" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <!-- myself style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-size: 15px;
            padding-bottom: 0;
            font-family: 'Microsoft JhengHei', 'Helvetica Neue', sans-serif;
            padding-top: 57px;
        }

        .container {
            max-width: 900px;
        }

        .table-responsive {
            overflow: inherit;
        }

        header {
            background-color: #2a3142;
            color: #fff;
            font-size: 25px;
            padding: 10px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
        }

        .download .container {
            padding-top: 30px;
        }

        .download .card-header {
            background-color: #2a3142;
            color: #fff;
        }

        .download .card-body {
            padding: 15px 10px;
        }

        .download td {
            border-top: 0;
        }

        .download .img {
            width: 60px;
        }

        .img img {
            width: 40px;
        }

        .name {
            border-bottom: 1px dotted #dfdfdf;
        }

        .name b, .name span {
            display: block;
        }

        .control {
            width: 80px;
            position: relative;
        }

        .qr-btn {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        .qr-btn i {
            font-size: 15px;
            color: #ff9800;
            cursor: pointer;
        }

        .qr-btn .no-link, .download-btn .no-link {
            color: #999;
        }

        .qr-box {
            position: absolute;
            z-index: 2;
            background-color: #fff;
            padding: 2px;
            margin-top: 10px;
            right: 87px;
            border: 1px solid #e8e8e8;
            display: none;
            top: -10px;
        }

        .qr-box::before {
            content: "";
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent #fff;
            position: absolute;
            left: 100%;
            top: 20px;
            z-index: 1;
        }

        .qr-box::after {
            content: "";
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 11px 0 11px 11px;
            border-color: transparent transparent transparent #e8e8e8;
            position: absolute;
            left: 100%;
            top: 19px;
        }

        .download-btn {
            color: #337ab7;
            position: relative;
            top: 2px;
        }

        .qr-btn:hover .qr-box {
            display: block;
        }

        @media (max-width: 575px) {
            body {
                padding-top: 50px;
            }

            header {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<div id="software">
    <download/>
</div>

<!-- end download -->
<!-- jQuery  -->
{{--<script src="{{ asset('assets/js/jquery.min.js') }}"></script>--}}
{{--<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>--}}
{{--<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>--}}
{{--<script src="{{ asset('assets/js/waves.min.js') }}"></script>--}}

{{--<script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>--}}


<!-- App js -->
{{--<script src="{{ asset('assets/js/app.js') }}'"></script>--}}
<script src="{{ asset('assets/js/View.js') }}"></script>

</body>
</html>
