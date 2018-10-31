<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | @lang('general.app_name')
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>

    <![endif]-->
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- global css -->

    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->

    <!-- end of global css -->
    <!--page level css-->
@yield('header_styles')
<!--end of page level css-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"
            type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.9/metisMenu.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.9/metisMenu.min.css" rel="stylesheet"
          type="text/css"/>

    <!-- vue used library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.css"
          rel="stylesheet"
          type="text/css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"/>

    {{--<script type="text/javascript" src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}"></script>--}}
{{--<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"--}}
{{--type="text/javascript"></script>--}}
{{--<script src="{{ asset('assets/vendors/decimal/decimal.min.js') }}" type="text/javascript"></script>--}}

<body class="skin-josh">
<header class="header">
    <a href="{{ route('admin.authcode.index') }}" class="logo">
        <img src="{{ asset('assets/img/3rdpay_logo.png') }}" alt="logo">
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                {{--@include('admin.layouts._messages')--}}
                {{--@include('admin.layouts._notifications')--}}
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Sentinel::getUser()->roles()->first()->slug === "admin")
                            <img src="{{ asset('assets/images/authors/admin_avatar.png') }}" alt="img" height="35px"
                                 width="35px"
                                 class="img-circle img-responsive pull-left"/>

                        @elseif(Sentinel::getUser()->roles()->first()->slug === "finance")
                            <img src="{{ asset('assets/images/authors/finance_avatar.png') }}" alt="img"
                                 height="35px" width="35px"
                                 class="img-circle img-responsive pull-left"/>

                        @elseif(Sentinel::getUser()->roles()->first()->slug === "user")
                            <img src="{{ asset('assets/images/authors/user_avatar.png') }}" alt="img" height="35px"
                                 width="35px"
                                 class="img-circle img-responsive pull-left"/>

                        @else
                            <img src="{{ asset('assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px"
                                 width="35px"
                                 class="img-circle img-responsive pull-left"/>
                        @endif
                        <div class="riot">
                            <div>
                                <p class="user_name_max">{{ Sentinel::getUser()->email }}</p>
                                <span>
                                        <i class="caret"></i>
                                    </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            @if(Sentinel::getUser()->roles()->first()->slug === "admin")
                                <img src="{{ asset('assets/images/authors/admin_avatar.png') }}" alt="img"
                                     height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>

                            @elseif(Sentinel::getUser()->roles()->first()->slug === "finance")
                                <img src="{{ asset('assets/images/authors/finance_avatar.png') }}" alt="img"
                                     height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>

                            @elseif(Sentinel::getUser()->gender === "user")
                                <img src="{{ asset('assets/images/authors/user_avatar.png') }}" alt="img"
                                     height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>
                            @else
                                <img src="{{ asset('assets/images/authors/no_avatar.jpg') }}" alt="img"
                                     height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>
                            @endif
                            <p class="topprofiletext">{{ Sentinel::getUser()->email }}</p>
                        </li>
                        <!-- Menu Body -->
                        <li>
                            <a href="{{ URL::route('admin.users.showProfile') }}">
                                <i class="livicon" data-name="user" data-s="18"></i>
                                @lang('users/title.viewProfile')
                            </a>
                        </li>
                        <li role="presentation"></li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ URL::route('admin.lockscreen',Sentinel::getUser()->id) }}">
                                    <i class="livicon" data-name="lock" data-size="16" data-c="#555555"
                                       data-hc="#555555" data-loop="true"></i>
                                    @lang('DefaultBlade/form.Lock')
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ URL::to('admin/logout') }}">
                                    <i class="livicon" data-name="sign-out" data-s="15"></i>
                                    @lang('DefaultBlade/form.Logout')
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="nav_icons">
                    <ul class="sidebar_threeicons">
                        <li>
                            <a href="{{ route('admin.authcode.index') }}">
                                <i class="livicon" data-name="table" title="Dashboard" data-loop="true"
                                   data-color="#e9573f" data-hc="#\" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/users/showProfile') }}">
                                <i class="livicon" data-name="user" title="Users" data-loop="true"
                                   data-color="#6CC66C" data-hc="#6CC66C" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/logQuery') }}">
                                <i class="livicon" data-name="balance" title="Advanced tables" data-loop="true"
                                   data-color="#418BCA" data-hc="#418BCA" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/activity_log') }}">
                                <i class="livicon" data-name="eye-open" title="Activity Log" data-loop="true"
                                   data-color="#F89A14" data-hc="#F89A14" data-s="25"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
            @include('admin.layouts._left_menu')
            <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side" id="app">

        <!-- Notifications -->
        <div id="notific">
            @include('notifications')
        </div>

        <!-- Content -->

        @yield('content')

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<script src="{{ asset('assets/js/app.js') }}" type="text/javascript"></script>
<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
<!-- end page level js -->
</body>
</html>
