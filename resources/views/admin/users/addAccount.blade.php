@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('users/title.title') }}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css"
      href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}"/>
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>@lang('users/AddAccount/title.title')</h1>
    <ol class="breadcrumb">
        <i class="livicon" data-name="eye-open" data-size="14" data-color="#000"></i>
        <li class="active">@lang('users/AddAccount/title.title')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="livicon" data-name="eye-open" data-size="16" data-loop="true"
                                           data-c="#fff" data-hc="white"></i>
                    @lang('users/AddAccount/title.account_form')
                </h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 pd-top">
                        <form id="commentForm" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="inputCode" class="col-md-3 control-label">
                                        @lang('users/AddAccount/form.VerifyCode')
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                        </span>
                                            <input type="text" id="verifyCode" placeholder=@lang('users/AddAccount/form.verifyCodeHolder') name="verifyCode" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAccount" class="col-md-3 control-label">
                                        @lang('users/AddAccount/form.AccountName')
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                    </span>
                                            <input type="text" id="AccountName" placeholder=@lang('users/AddAccount/form.AccountName') name="AccountName" class="form-control required"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputAccount" class="col-md-3 control-label">
                                        @lang('users/AddAccount/form.Account')
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                        </span>
                                            <input type="text" id="Account" placeholder=@lang('users/AddAccount/form.Account') name="Account" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputAccount" class="col-md-3 control-label">
                                        @lang('users/AddAccount/form.BankName')
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                        </span>
                                            <input type="text" id="BankName" placeholder=@lang('users/AddAccount/form.BankName') name="BankName" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputAccount" class="col-md-3 control-label">
                                        @lang('users/AddAccount/form.BankBranchName')
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="livicon" data-name="tree" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                        </span>
                                            <input type="text" id="BankBranchName" placeholder=@lang('users/AddAccount/form.BankBranchName') name="BankBranchName" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="button" class="btn btn-primary" id="add-Account" >@lang('users/AddAccount/form.submit')</button>
                                    <button type="button" class="btn btn-danger" id="send-VerifyCode" >@lang('users/AddAccount/form.send')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left">
                    <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    @lang('users/AddAccount/title.account_list')
                </h4>
                <div class="pull-right">
                    <button type="button" class="btn btn-warning btn-sm" id="refreshButton" name="refreshButton">
                        <i class="livicon" data-name="refresh" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i></button>
                </div>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered width100" id="table">
                        <thead>
                        <tr class="filters">
                            <th>@lang('users/AddAccount/form.id')</th>
                            <th>@lang('users/AddAccount/form.AccountName')</th>
                            <th>@lang('users/AddAccount/form.Account')</th>
                            <th>@lang('users/AddAccount/form.BankName')</th>
                            <th>@lang('users/AddAccount/form.BankBranchName')</th>
                            <th>@lang('users/AddAccount/form.created_at')</th>
                            <th>@lang('users/AddAccount/form.operation')</th>
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
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
    });

    $("#commentForm").bootstrapValidator({
        fields: {
            verifyCode: {
                validators: {
                    notEmpty: {
                        message: '@lang('users/AddAccount/form.VerifyCode')是必须的'
                    },
                    integer: {
                        message: '@lang('users/AddAccount/form.VerifyCode')必须为数字'
                    },
                    stringLength: {
                        max: 6,
                        message: '@lang('users/AddAccount/form.VerifyCode')必少于6个数字'
                    }
                },
                required: true
            },
            AccountName: {
                validators: {
                    notEmpty: {
                        message: '@lang('users/AddAccount/form.AccountName')是必须的'
                    }
                },
                required: true
            },
            Account: {
                validators: {
                    notEmpty: {
                        message: '@lang('users/AddAccount/form.Account')是必须的'
                    },
                    integer: {
                        message: '@lang('users/AddAccount/form.Account')必须为数字'
                    }
                },
                required: true
            },
            BankName: {
                validators: {
                    notEmpty: {
                        message: '@lang('users/AddAccount/form.BankName')是必须的'
                    }
                },
                required: true
            },
            BankBranchName: {
                validators: {
                    notEmpty: {
                        message: '@lang('users/AddAccount/form.BankBranchName')是必须的'
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
            ajax: {
                "url": "{{ route('admin.account.data') }}",
                "type": "post",
                "data": function (d) {
                    d.id = '{{ $user->id }}';
                }
            },
            language: {
                search: "@lang('dataTable.search')",
                lengthMenu: "@lang('dataTable.lengthMenu')",
                zeroRecords: "@lang('dataTable.noData')",
                info: "@lang('dataTable.pageInfo')",
                infoEmpty: "@lang('dataTable.noData')",
                infoFiltered: "@lang('dataTable.infoFiltered')",
                paginate: {
                    "next": "@lang('dataTable.next')",
                    "previous": "@lang('dataTable.previous')"
                },
                processing: "@lang('dataTable.processing')"
            },
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

        $('#send-VerifyCode').click(function (event) {
            event.preventDefault();

            var postData = {
                id: '{{ $user->id }}',
                mobile: '{{ $user->mobile }}'
            };
            $.ajax({
                url: "{{ route('admin.account.sendVerifyCode') }}",
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
                    url: "{{ route('admin.account.addAccount') }}",
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
                            $validator.resetForm();

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
@stop
