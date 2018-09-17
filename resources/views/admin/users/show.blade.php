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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>@lang('users/ViewProfile/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="user" data-size="14" data-loop="true"></i>
                @lang('users/title.title')
            </li>
            <li class="active">@lang('users/ViewProfile/title.title')</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs ">

                    <li class="active">
                        <a href="#tab1" data-toggle="tab">
                            <i class="livicon" data-name="notebook" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
                            @lang('users/ViewProfile/title.information')</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">
                            <i class="livicon" data-name="cellphone" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            @lang('users/ViewProfile/title.contact_information')</a>
                    </li>

                    <li>
                        <a href="#tab3" data-toggle="tab">
                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            @lang('users/ViewProfile/title.change_password')</a>
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
                                                            <td>@lang('users/ViewProfile/form.QQ_id')</td>
                                                            <td>
                                                                {{ $user->QQ_id }}
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
                                <form class="form-horizontal" id="commentForm">
                                    <div class="form-body">

                                        <div class="form-group">
                                            {{ csrf_field() }}
                                            <label for="inputoldpassword" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.oldPassword')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                    </span>
                                                    <input type="password" id="oldPassword" placeholder=@lang('users/ViewProfile/form.oldPasswordHolder') name="oldPassword"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                        </div>

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
                                                    <input type="password" id="password_confirm" placeholder=@lang('users/ViewProfile/form.confirmPasswordHolder') name="password_confirm"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="button" class="btn btn-primary" id="change-password">@lang('users/ViewProfile/form.submit')</button>
                                            <input type="reset" class="btn btn-default" value=@lang('users/ViewProfile/form.reset')>
                                        </div>
                                    </div>
                                </form>
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
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $("#commentForm").bootstrapValidator({
            fields: {
                oldPassword: {
                    validators: {
                        notEmpty: {
                            message: '@lang('users/ViewProfile/form.oldPassword')是必须的'
                        },
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '@lang('users/ViewProfile/form.newPassword')是必须的'
                        },
                        stringLength: {
                            min: 6,
                            message: '@lang('users/ViewProfile/form.newPassword')必多于6个字元'
                        }
                    }
                },
                password_confirm: {
                    validators: {
                        identical: {
                            field: 'password',
                            message: '@lang('users/ViewProfile/form.confirmPassword')与密码不符'
                        }
                    }
                }
            }
        });

        $(document).ready(function () {
            $('#change-password').click(function (e) {
                e.preventDefault();

                var $validator = $('#commentForm').data('bootstrapValidator').validate();

                console.log($('#password').val());

                if ($validator.isValid()) {
                    var sendData =  '_token=' + $("input[name='_token']").val() + '&oldPassword=' + $('#oldPassword').val() +'&password=' + $('#password').val() +'&id=' + {{ $user->id }};
                    var path = "passwordreset";
                    $.ajax({
                        url: path,
                        type: "post",
                        data: sendData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        success: function (data) {
                            $('#oldPassword, #password, #password_confirm').val('');
                            $validator.resetForm();

                            if(data.Result == 'error'){
                                alert(data.Message);
                                return;
                            }
                            alert('密码已成功设定');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('设定失败，与服务器供沟通失败');
                        }
                    });
                }
            });
        });
    </script>

    <script>

    </script>
@stop

