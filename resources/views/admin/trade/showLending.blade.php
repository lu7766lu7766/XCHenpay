@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('Trade/title.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/tables.css') }}"/>
    <link href="{{ asset('assets/css/pages/transitions.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}"/>

@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>@lang('Trade/showLending/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="balance" data-size="14" data-loop="true"></i>
                @lang('Trade/title.title')
            </li>
            <li class="active">@lang('Trade/showLending/title.title')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content paddingleft_right15">

        <!-- 下發資訊 -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="livicon" data-name="mail" data-size="16" data-loop="true"
                                           data-c="#fff" data-hc="white"></i>
                    @lang('Trade/showLending/title.form1')
                </h4>
                <span class="pull-right clickable">
                                <i class="glyphicon glyphicon-chevron-up"></i>
                            </span>
            </div>
            <div class="panel-body">

                <div class="panel-body border">
                    <form enctype="multipart/form-data" class="form-horizontal form-bordered">
                        <div class="form-group striped-col">
                            <label class="col-md-2 control-label">@lang('Trade/showLending/form.totalMoney')</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="td_totalMoney">
                                </p>
                            </div>
                        </div>

                        <div class="form-group striped-col">
                            <label class="col-md-2 control-label">@lang('Trade/showLending/form.totalFee')</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="td_totalFee">
                                </p>
                            </div>
                        </div>

                        <div class="form-group striped-col">
                            <label class="col-md-2 control-label">@lang('Trade/showLending/form.totalLending')</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="td_totalLending">
                                </p>
                            </div>
                        </div>

                        <div class="form-group striped-col">
                            <label class="col-md-2 control-label">@lang('Trade/showLending/form.totalLended')</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="td_totalLended">
                                </p>
                            </div>
                        </div>

                        <div class="form-group striped-col">
                            <label class="col-md-2 control-label">@lang('Trade/showLending/form.totalIncome')</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="td_totalIncome">
                                </p>
                            </div>
                        </div>

                    </form>
                </div>

                <hr>

                <form id="applyForm" class="form-horizontal">
                    <!-- CSRF Token -->
                    <!-- Money input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="money">@lang('Trade/LendApply/form.lendMoney')
                            *</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="livicon" data-name="piggybank" data-size="16" data-loop="true"
                                       data-c="#000" data-hc="#000"></i>
                                </span>
                                <input id="money" name="money" type="text" class="form-control">
                            </div>
                            <p class="text-warning">@lang('Trade/LendApply/form.lendMoney')最少填入1000</p>
                        </div>
                    </div>


                    <!-- Account input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="account">@lang('Trade/LendApply/form.lendAccount')
                            *</label>
                        <div class="col-md-9">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="livicon" data-name="credit-card" data-size="16" data-loop="true"
                                       data-c="#000" data-hc="#000"></i>
                                </span>

                                <select id="account_selections" class="form-control">
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- Description body -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"
                               for="description">@lang('Trade/LendApply/form.description')</label>
                        <div class="col-md-9">
                            <textarea class="form-control resize_vertical" id="description" name="description"
                                      rows="5"></textarea>
                        </div>
                    </div>

                    <!-- Form actions -->
                    <div class="form-position">
                        <div class="col-md-12 text-center">
                            <p class="text-danger">申请金额将自动加上 0.02% 的申请手续费</p>
                            <button id="lendApply" type="button"
                                    class="btn btn-responsive btn-primary btn-sm">@lang('Trade/LendApply/form.lendApply')</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!-- 申請列表 -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="livicon" data-name="table" data-size="16" data-loop="true"
                                           data-c="#fff" data-hc="white"></i>
                    @lang('Trade/showLending/title.form2')
                </h4>
                <span class="pull-right clickable">
                                <i class="glyphicon glyphicon-chevron-up"></i>
                            </span>
            </div>
            <br/>
            <div class="panel-body">

                <div class="form-group">
                    <div class="col-lg-4 input-group">
                        <div class="input-group-addon">
                            <i class="livicon" data-name="calendar" data-size="16" data-c="#555555"
                               data-hc="#555555" data-loop="true"></i>
                        </div>
                        <input type="text" class="form-control" id="daterange1"/>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered width100" id="table">
                        <thead>
                        <tr class="filters">
                            <th>@lang('Trade/showLending/form.lend_summary')</th>
                            <th>@lang('Trade/showLending/form.record_seq')</th>
                            <th>@lang('Trade/showLending/form.account_name')</th>
                            <th>@lang('Trade/showLending/form.account')</th>
                            <th>@lang('Trade/showLending/form.total_amount')</th>
                            <th>@lang('Trade/showLending/form.apply_time')</th>
                            <th>@lang('Trade/showLending/form.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"
            type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>

    <div class="modal fade" id="lend_info" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <script type="text/javascript">
        $("#applyForm").bootstrapValidator({
            fields: {
                money: {
                    validators: {
                        notEmpty: {
                            message: '@lang('Trade/LendApply/form.lendMoney')是必须的'
                        },
                        integer: {
                            message: '@lang('Trade/LendApply/form.lendMoney')必须为整数字'
                        }
                        {{--greaterThan: {--}}
                        {{--message: '@lang('Trade/LendApply/form.lendMoney')最少填入1000',--}}
                        {{--inclusive: true,--}}
                        {{--min: 1000--}}
                        {{--}--}}
                        {{--lessThan: {     //todo 一直沒有過這裡--}}
                        {{--max: 10,--}}
                        {{--message: '@lang('Trade/LendApply/form.lendMoney')必需少于@lang('Trade/LendApply/form.totalIncome')'--}}
                        {{--}--}}
                    },
                    required: true
                },
                account_selections: {
                    validators: {
                        notEmpty: {
                            message: '请选择@lang('Trade/LendApply/form.lendAccount')'
                        }
                    },
                    required: true
                },
                description: {
                    validators: {
                        stringLength: {
                            max: 200,
                            message: '@lang('Trade/LendApply/form.description')必少于200个字元'
                        }
                    }
                }
            }
        });

        $("#daterange1").daterangepicker({
            locale: {
                startDate: moment(),
                endDate: moment(),
                format: 'YYYY/MM/DD',
                applyLabel: '@lang('dateRangePicker.filter')',
                cancelLabel: '@lang('dateRangePicker.cancel')',
                daysOfWeek: [
                    '@lang('dateRangePicker.SUN')',
                    '@lang('dateRangePicker.MON')',
                    '@lang('dateRangePicker.TUE')',
                    '@lang('dateRangePicker.WED')',
                    '@lang('dateRangePicker.THU')',
                    '@lang('dateRangePicker.FRI')',
                    '@lang('dateRangePicker.SAT')'
                ],
                monthNames: [
                    '@lang('dateRangePicker.JAN')',
                    '@lang('dateRangePicker.FEB')',
                    '@lang('dateRangePicker.MAR')',
                    '@lang('dateRangePicker.APR')',
                    '@lang('dateRangePicker.MAY')',
                    '@lang('dateRangePicker.JUN')',
                    '@lang('dateRangePicker.JUL')',
                    '@lang('dateRangePicker.AUG')',
                    '@lang('dateRangePicker.SEP')',
                    '@lang('dateRangePicker.OCT')',
                    '@lang('dateRangePicker.NOV')',
                    '@lang('dateRangePicker.DEC')'

                ]
            }
        });

        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            order: [[5, 'desc']],
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
            ajax: {
                "url": "{!! route('admin.showLending.data') !!}",
                "type": "post",
                "data": function (d) {
                    d.startDate = $('#daterange1').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.endDate = $('#daterange1').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
            columns: [
                {data: 'lend_summary', name: 'lend_summary'},
                {data: 'record_seq', name: 'record_seq'},
                {data: 'account_name', name: 'account_name'},
                {data: 'account', name: 'account'},
                {data: 'tatol_amount', name: 'amount'},
                {data: 'created_at', name: 'created_at'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ]
        });

        $(document).ready(function () {
            $('#lendApply').click(function (e) {
                if ($('#money').val() < 1000) {
                    alert('@lang('Trade/LendApply/form.lendMoney')最少填入1000');
                    return;
                }

                if ($('#money').val() > Number($('#td_totalIncome').text())) {
                    alert("@lang('Trade/LendApply/form.lendMoney')必需小于@lang('Trade/LendApply/form.totalIncome')");
                    return;
                }

                if ($('#account_selections').val() == "@lang('Trade/LendApply/form.pleaseSelect')") {
                    alert("請選擇銀行卡");
                    return;
                }

                var $validator = $('#applyForm').data('bootstrapValidator').validate();


                if ($validator.isValid()) {
                    var postData = {
                        amount: $('#money').val(),
                        account: $('#account_selections').val(),
                        description: $('#description').val()
                    };

                    $.ajax({
                        url: "{{ route('admin.showLending.apply') }}",
                        type: "post",
                        data: postData,

                        success: function (data) {
                            complete(data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('错误，与服务器沟通失败');
                        }
                    });

                    var complete = function (data) {
                        if (data.Result == 'error') {
                            alert(data.Message);
                            return;
                        }

                        alert("成功申请下发，详见下方下发列表");
                        $('#description').val('');
                        $('#money').val('');
                        $validator.resetForm();

                        //refresh 商戶資料
                        refreshMoneyInfo();

                        return;
                    };
                }
            });

            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });

            //clear the data in hidden modal
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });

            refreshMoneyInfo();
        });

        $('#daterange1').on('apply.daterangepicker', function (ev, picker) {
            table.ajax.reload();
        });

        function refreshMoneyInfo() {
            $.ajax({
                url: "{{ route('admin.showLending.getInfo') }}",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                success: function (data) {
                    applyInfo();
                    complete(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert('错误，与服务器沟通失败');
                }
            });

            var complete = function (data) {
                document.getElementById("td_totalMoney").innerHTML = data.totalMoney;
                document.getElementById("td_totalFee").innerHTML = data.totalFee;
                document.getElementById("td_totalLending").innerHTML = data.totalLending;
                document.getElementById("td_totalLended").innerHTML = data.totalLended;
                document.getElementById("td_totalIncome").innerHTML = data.totalIncome;

                document.getElementById("account_selections").innerHTML = '<option>' + '@lang('Trade/LendApply/form.pleaseSelect')' + '</option>';
                data.accounts.forEach(function (account, index) {
                    document.getElementById("account_selections").innerHTML += '<option value=' + account.id + '>' + account.name + '/' + account.account + '/' + account.bank_name + '</option>';
                });

                table.ajax.reload();

                return;
            };
        }

        function applyInfo () {
            $.ajax({
                url: "{{ route('admin.showLending.getUserInfo') }}",
                type: "get",
                success: function (data) {
                    if (data.apply_status == 'off') $('#applyForm').addClass("hidden");
                    else $('#applyForm').removeClass("hidden")
                    return;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert('错误，与服务器沟通失败');
                }
            })
        }


    </script>

@stop
