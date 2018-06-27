@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('users/ViewProfile/title.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet"/>

    <link href="{{ asset('assets/css/pages/user_profile.css') }}" rel="stylesheet"/>
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>@lang('users/ViewProfile/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    @lang('general.dashboard')
                </a>
            </li>
            <li>
                <a href="#">@lang('users/title.title')</a>
            </li>
            <li class="active">@lang('users/ViewProfile/title.title')</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav  nav-tabs ">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab">
                            <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
                            @lang('users/ViewProfile/title.title')</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            @lang('users/ViewProfile/title.contact_password')</a>
                    </li>

                    <li>
                        <a href="#tab3" data-toggle="tab">
                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            @lang('users/ViewProfile/title.change_password')</a>
                    </li>

                    <li>
                        <a href="#tab4" data-toggle="tab">
                            <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            @lang('users/ViewProfile/title.add_account')</a>
                    </li>



                </ul>
                <div  class="tab-content mar-top">

                    <div id="tab1" class="tab-pane fade active in">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="col-md-16">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="users">

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.company_name')</td>
                                                            <td>
                                                                {{  $user->company_name }}
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.company_service_id')</td>
                                                            <td>
                                                                {{ $user->company_service_id }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.sceret_key')</td>
                                                            <td>
                                                                {{ $user->sceret_key }}
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="col-md-16">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="users">

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.full_name')</td>
                                                            <td>
                                                                {{  $user->last_name . ' ' . $user->first_name }}
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.mobile')</td>
                                                            <td>
                                                                {{ $user->mobile }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.email')</td>
                                                            <td>
                                                                {{ $user->email }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.address')</td>
                                                            <td>
                                                                {{ $user->address }}
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab3" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 pd-top">
                                <form class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            {{ csrf_field() }}
                                            <label for="inputpassword" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.newPassword')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="password" id="password" placeholder=@lang('users/ViewProfile/form.PasswordHolder') name="password"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputnumber" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.confirmPassword')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="password" id="password-confirm" placeholder=@lang('users/ViewProfile/form.confirmPasswordHolder') name="confirm_password"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary" id="change-password">@lang('users/ViewProfile/form.submit')
                                            </button>
                                            &nbsp;
                                            <input type="reset" class="btn btn-default" value=@lang('users/ViewProfile/form.reset')></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="tab4" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 pd-top">
                                <form class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            {{ csrf_field() }}
                                            <label for="inputPhoneNum" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.inputPhoneNum')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="livicon" data-name="cellphone" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                    </span>
                                                    <input type="text" id="mobile" placeholder=@lang('users/ViewProfile/form.PhoneNumHolder') name="mobile" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputCode" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.inputVerifyCode')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="text" id="verifyCode" placeholder=@lang('users/ViewProfile/form.verifyCodeHolder') name="verifyCode" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAccount" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.inputAccount')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="text" id="acount" placeholder=@lang('users/ViewProfile/form.accountHolder') name="acount" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="col-md-offset-3 col-md-6">
                                            <input type="submit" class="btn btn-primary" id="add-Account" value=@lang('users/ViewProfile/form.submit')></div>
                                            <input type="send" class="btn btn-danger" id="send-VerifyCode" value=@lang('users/ViewProfile/form.send')></div>
                                    </div>
                                </form>

                                <!-- BEGIN SAMPLE TABLE PORTLET-->
                                <div class="portlet box primary">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                            @lang('users/ViewProfile/title.account_list')
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>@lang('users/ViewProfile/form.id')</th>
                                                    <th>@lang('users/ViewProfile/form.inputAccount')</th>
                                                    <th>@lang('users/ViewProfile/form.created_at')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Airi Satou</td>
                                                    <td>Kelly</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Angelica</td>
                                                    <td>Ramos</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Ashton</td>
                                                    <td>Cox</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Bradley</td>
                                                    <td>Greer</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- END SAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- Bootstrap WYSIHTML5 -->
    <script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#change-password').click(function (e) {
                e.preventDefault();
                var check = false;
                if ($('#password').val() ===""){
                    alert('Please Enter password');
                }
                else if  ($('#password').val() !== $('#password-confirm').val()) {
                    alert("confirm password should match with password");
                }
                else if  ($('#password').val() === $('#password-confirm').val()) {
                    check = true;
                }

                if(check == true){
                var sendData =  '_token=' + $("input[name='_token']").val() +'&password=' + $('#password').val() +'&id=' + {{ $user->id }};
                    var path = "passwordreset";
                    $.ajax({
                        url: path,
                        type: "post",
                        data: sendData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        success: function (data) {
                            $('#password, #password-confirm').val('');
                            alert('password reset successful');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('error in password reset');
                        }
                    });
                }
            });

            $('#send-VerifyCode').click(function (event) {
                event.preventDefault();

                if ($('#mobile').val() ===""){
                    alert('请输入手机号码');
                }
                else if ($('#mobile').val().length != 11){
                    alert('手机号码长度应为11码');
                }
                else if (isNaN($('#mobile').val())){
                    alert('请输入有效手机号码');
                }
                else{
                    var postData = {
                        id: {{ $user->id }},
                        mobile: $('#mobile').val()

                        // timestamp: $.now()
                    };
                    //var path = "sendVerifyCode"
                    $.ajax({
                        url: "sendVerifyCode",
                        type: "post",
                        dataType: 'json',
                        data: postData,
                        success: function (data) {
                            $('#mobile').val('');
                            if (data.Result == 'OK')
                                alert('发送验证码成功，请检查您的手机讯息');
                            else
                                alert('错误，' + data.Message);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('发送验证码失败，与服务器沟通错误');
                        }
                    });
                }
            });

            $('#add-Account').click(function (e) {
                event.preventDefault();

                if ($('#verifyCode').val() ==="" || $('#account').val() ===""){
                    alert('请填齐『验证码』及『帐号』');
                }
                else if (isNaN($('#verifyCode'))){
                    alert('请输入有效验证码');
                }
                else if (isNaN($('#account').val())){
                    alert('请输入有效帐号');
                }
                else {
                    var postData = {
                        id: {{ $user->id }},
                        code: $('#verifyCode').val(),
                        account: $('#account').val()
                    };

                    $.ajax({
                        url: "addAccount",
                        type: "post",
                        dataType: 'json',
                        data: postData,
                        success: function (data) {
                            if (data.Result == 'OK')
                                alert('帐号新增成功，可在下方表单作确认');
                            else
                                alert('error,' + data.Message);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('新增帐号失败，与服务器沟通错误');
                        }
                    });
                }
            });
        });
    </script>

@stop
