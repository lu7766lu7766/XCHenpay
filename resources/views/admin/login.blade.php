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
        <div class="card-body">

            <h3 class="text-center m-0">
                <a href="#" class="logo logo-admin"><img src="{{ asset('img/logo.png') }}" height="30" alt="logo"></a>
            </h3>

            <div class="p-3">
                <form class="form-horizontal" action="{{ route('signin') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="form-group">
                        <label for="email">帐户信箱</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="帐户信箱">
                    </div>

                    <div class="form-group">
                        <label for="password">密码</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="密码">
                    </div>

                    <div class="form-group row m-t-20">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember-me" name="remember-me" value="remember-me">
                                <label class="custom-control-label" for="customControlInline">保持登陆状态</label>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">登入</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="login-alert">
                @include('notifications')
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
