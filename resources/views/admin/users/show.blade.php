@extends('admin.layouts.default')

@section('header_styles')
    {{--放置 css--}}
@stop

@section('breadcrumb')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-flex">
                <h4 class="page-title">商户资料</h4>
                <ol class="breadcrumb ml-auto">
                    <li class="breadcrumb-item active"><a href="{{ URL::to('admin/logQuery') }}">首页</a></li>
                    <li class="breadcrumb-item"><a>商户</a></li>
                    <li class="breadcrumb-item active">商户资料</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    {{--放置 content--}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form class="form-horizontal" id="commentForm" data-parsley-validate="">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">商戶名稱</label>
                            <div class="col-sm-10 p-t-7 border-line">{{ $user->company_name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">company_service_id</label>
                            <div class="col-sm-10 p-t-7 border-line">{{ $user->company_service_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">sceret_key</label>
                            <div class="col-sm-10 p-t-7 border-line">{{ $user->sceret_key }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                @if ($user->status == 'on')
                                    <i class="mdi mdi-check-circle-outline text-green text-lg"></i>
                                @else
                                    <i class="mdi mdi-check-close-outline text-red text-lg"></i>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">下发申请</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                @if ($user->apply_status == 'on')
                                    <i class="mdi mdi-check-circle-outline text-green text-lg"></i>
                                @else
                                    <i class="mdi mdi-check-close-outline text-red text-lg"></i>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">联络电话</label>
                            <div class="col-sm-10 p-t-7 border-line">{{ $user->mobile }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">电子邮箱</label>
                            <div class="col-sm-10 p-t-7 border-line">{{ $user->email }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">QQ号</label>
                            <div class="col-sm-10 p-t-7 border-line">{{ $user->QQ_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">旧密码 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请输入旧密码" id="oldPassword"
                                       name="oldPassword" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">新密码 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请输入密码" id="password"
                                       name="password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">密码确认 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请再一次输入新密码"
                                       id="password_confirm" name="password_confirm" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                        id="change-password">提交
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect">重设</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- card end -->
        </div>
    </div>
@stop

@section('modal')
    {{--放置 modal--}}
@stop

@section('footer_scripts')
    {{--放置 js--}}
    <script src="{{ asset('plugins/bootstrap-validator/js/bootstrapValidator.min.js') }}"></script>
    {{--<script src="{{ asset('plugins/bootstrap-validator/i18n/zh_cn.js') }}"></script>--}}

    <script>
        $(function () {
            $('#change-password').click(function (e) {
                e.preventDefault();

                var $validator = $('#commentForm').data('bootstrapValidator').validate();

                console.log($('#password').val());

                if ($validator.isValid()) {
                    var sendData = '_token=' + $("input[name='_token']").val() + '&oldPassword=' + $('#oldPassword').val() + '&password=' + $('#password').val() + '&id=' + {{ $user->id }};
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

                            if (data.Result == 'error') {
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

        $("#commentForm").bootstrapValidator({
            fields: {
                oldPassword: {
                    validators: {
                        notEmpty: {
                            message: '旧密码是必须的'
                        },
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '新密码是必须的'
                        },
                        stringLength: {
                            min: 6,
                            message: '新密码必多于6个字元'
                        }
                    }
                },
                password_confirm: {
                    validators: {
                        notEmpty: {
                            message: '密码确认是必须的'
                        },
                        identical: {
                            field: 'password',
                            message: '密码确认与新密码不符'
                        }
                    }
                }
            }
        });

    </script>

@stop
