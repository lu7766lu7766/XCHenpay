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

                    <div id="tab4" class="tab-pane fade ">
                        <div class="row">
                            <div class="col-md-12 pd-top">
                                <form id="commentForm" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="inputCode" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.VerifyCode')
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
                                                @lang('users/ViewProfile/form.AccountName')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                        </span>
                                                    <input type="text" id="AccountName" placeholder=@lang('users/ViewProfile/form.AccountName') name="AccountName" class="form-control required"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAccount" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.Account')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="text" id="Account" placeholder=@lang('users/ViewProfile/form.Account') name="Account" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAccount" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.BankName')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="text" id="BankName" placeholder=@lang('users/ViewProfile/form.BankName') name="BankName" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAccount" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.BankBranchName')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="tree" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="text" id="BankBranchName" placeholder=@lang('users/ViewProfile/form.BankBranchName') name="BankBranchName" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="button" class="btn btn-primary" id="add-Account" >@lang('users/ViewProfile/form.submit')</button>
                                            <button type="button" class="btn btn-danger" id="send-VerifyCode" >@lang('users/ViewProfile/form.send')</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <hr>

                        <section class="content paddingleft_right15">
                            <div class="row">
                                <div class="panel panel-primary ">
                                    <div class="panel-heading clearfix">
                                        <h4 class="panel-title pull-left">
                                            <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                            @lang('users/ViewProfile/title.account_list')
                                        </h4>
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-warning btn-sm" id="refreshButton" name="refreshButton">
                                                <i class="livicon" data-name="refresh" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i></button>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered width100" id="table">
                                                <thead>
                                                <tr class="filters">
                                                    <th>@lang('users/ViewProfile/form.id')</th>
                                                    <th>@lang('users/ViewProfile/form.AccountName')</th>
                                                    <th>@lang('users/ViewProfile/form.Account')</th>
                                                    <th>@lang('users/ViewProfile/form.BankName')</th>
                                                    <th>@lang('users/ViewProfile/form.BankBranchName')</th>
                                                    <th>@lang('users/ViewProfile/form.created_at')</th>
                                                    <th>@lang('users/ViewProfile/form.operation')</th>
                                                </tr>
                                                </thead>
                                                <tbody>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>    <!-- row-->
                        </section>
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
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $("#commentForm").bootstrapValidator({
            fields: {
                verifyCode: {
                    validators: {
                        notEmpty: {
                            message: '@lang('users/ViewProfile/form.VerifyCode')是必须的'
                        },
                        integer: {
                            message: '@lang('users/ViewProfile/form.VerifyCode')必须为数字',
                        },
                        stringLength: {
                            max: 6,
                            message: '@lang('users/ViewProfile/form.VerifyCode')必少于6个数字'
                        }
                    },
                    required: true
                },
                AccountName: {
                    validators: {
                        notEmpty: {
                            message: '@lang('users/ViewProfile/form.AccountName')是必须的'
                        }
                    },
                    required: true
                },
                Account: {
                    validators: {
                        notEmpty: {
                            message: '@lang('users/ViewProfile/form.Account')是必须的'
                        },
                        integer: {
                            message: '@lang('users/ViewProfile/form.Account')必须为数字',
                        }
                    },
                    required: true
                },
                BankName: {
                    validators: {
                        notEmpty: {
                            message: '@lang('users/ViewProfile/form.BankName')是必须的'
                        }
                    },
                    required: true
                },
                BankBranchName: {
                    validators: {
                        notEmpty: {
                            message: '@lang('users/ViewProfile/form.BankBranchName')是必须的'
                        }
                    },
                    required: true
                }
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                paginate: false,
                info: false,
                ajax: '{!! route('admin.account.data',['user' => $user->id]) !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'account', name: 'account' },
                    { data: 'bank_name', name: 'bank_name' },
                    { data: 'bank_branch', name: 'bank_branch'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });
            table.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            } );

            $('#refreshButton').click(function (e) {
                table.ajax.reload();
            });

            $('#change-password').click(function (e) {
                e.preventDefault();
                var check = false;
                if ($('#password').val() ===""){
                    alert('请输入密码');
                }
                else if  ($('#password').val() !== $('#password-confirm').val()) {
                    alert("密码确认与新密码不符合");
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
                    var postData = {
                        id: '{{ $user->id }}',
                        mobile: '{{ $user->mobile }}'
                    };
                    $.ajax({
                        url: "sendVerifyCode",
                        type: "post",
                        dataType: 'json',
                        data: postData,
                        success: function (data) {

                            $('#mobile').val('');
                            if (data.Result == 'OK')
                                alert('已成功发送验证码至' + '{{ $user->mobile }}');
                            else
                                alert('错误，' + data.Message);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('发送验证码失败，与服务器沟通错误');
                            console.log(this.url);
                        }
                    });
                });

            $('#add-Account').click(function (e) {
                event.preventDefault();

                var $validator = $('#commentForm').data('bootstrapValidator').validate();
                if ($validator.isValid()) {
                    var postData = {
                        id: {{ $user->id }},
                        code: $('#verifyCode').val(),
                        name: $('#AccountName').val(),
                        account: $('#Account').val(),
                        bank_name: $('#BankName').val(),
                        bank_branch: $('#BankBranchName').val()
                    };

                    $.ajax({
                        url: "addAccount",
                        type: "post",
                        dataType: 'json',
                        data: postData,
                        success: function (data) {
                            if (data.Result == 'OK'){
                                alert('帐号新增成功，可在下方表单作确认');

                                $('#verifyCode').val('');
                                $('#AccountName').val('');
                                $('#Account').val('');
                                $('#BankName').val('');
                                $('#BankBranchName').val('');

                                table.ajax.reload();
                            }
                            else
                                alert('error,' + data.Message);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log(xhr+ ' '+ thrownError);
                            alert('新增帐号失败，与服务器沟通错误');
                        }
                    });
                }
            });
        });
    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop

