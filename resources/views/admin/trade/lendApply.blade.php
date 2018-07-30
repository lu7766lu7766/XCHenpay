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
    <link href="{{ asset('assets/vendors/jquery-datatables-checkboxes/css/dataTables.checkboxes.css') }}" rel="stylesheet"/>

@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>@lang('Trade/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="balance" data-size="14" data-loop="true"></i>
                @lang('Trade/title.title')
            </li>
            <li class="active">@lang('Trade/LendApply/title.title')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content paddingleft_right15">

        <!-- 商戶篩選 -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="filter" data-size="16" data-loop="true" data-c="#fff"
                       data-hc="white"></i>
                    @lang('Trade/LendApply/form.company_switch')
                </h3>
                <span class="pull-right clickable">
                                <i class="glyphicon glyphicon-chevron-up"></i>
                            </span>
            </div>
            <div class="panel-body text-center">
                <!--content starts-->
                <div class="warp">
                    <p>
                        <select id="company_selection" name="company_selection" class="js--animations form-control"
                                onchange="companyFilter(this.value);">
                                <option value="">@lang('Trade/LendApply/form.company_please')</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </p>
                </div>
                <!--content ends-->
            </div>
        </div>

        <!-- 下發申請 -->
        <div class="panel panel-primary hidden" id="hidepanel1">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    @lang('Trade/LendApply/title.title'): <i id="lendTitle"></i>
                </h3>
                <span class="pull-right clickable">
                    <i class="glyphicon glyphicon-chevron-up"></i>
                </span>
            </div>
            <div class="panel-body">

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="users">

                            <tr>
                                <td>@lang('Trade/LendApply/form.totalMoney')</td>
                                <td id="td_totalMoney">
                                    {{ 'null' }}
                                </td>
                            </tr>

                            <tr>
                                <td>@lang('Trade/LendApply/form.totalFee')</td>
                                <td id="td_totalFee">
                                    {{ 'null' }}
                                </td>
                            </tr>

                            <tr>
                                <td>@lang('Trade/LendApply/form.totalLended')</td>
                                <td id="td_totalLended">
                                    {{ 'null' }}
                                </td>
                            </tr>

                            <tr>
                                <td>@lang('Trade/LendApply/form.totalIncome')</td>
                                <td id="td_totalIncome">
                                    {{ 'null' }}
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>

                <form id="applyForm" class="form-horizontal">
                    <!-- CSRF Token -->
                    <!-- Money input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="money">@lang('Trade/LendApply/form.lendMoney') *</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="livicon" data-name="piggybank" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                </span>
                                <input id="money" name="money" type="text" class="form-control"></div>
                        </div>
                    </div>
                    <!-- Account input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="account">@lang('Trade/LendApply/form.lendAccount') *</label>
                        <div class="col-md-9">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="livicon" data-name="credit-card" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                </span>

                                <select id="account_selections" class="form-control">
                                    <option>@lang('Trade/LendApply/form.pleaseSelect')</option>

                                </select>
                           </div>

                        </div>
                    </div>

                    <!-- Description body -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="description">@lang('Trade/LendApply/form.description')</label>
                        <div class="col-md-9">
                            <textarea class="form-control resize_vertical" id="description" name="description" rows="5"></textarea>
                        </div>
                    </div>

                    <!-- Form actions -->
                    <div class="form-position">
                        <div class="col-md-12 text-center">
                            <button id="lendApply" type="button" class="btn btn-responsive btn-primary btn-sm">@lang('Trade/LendApply/form.lendApply')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- 申請列表 -->
        <div class="panel panel-primary hidden" id="hidepanel2">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="livicon" data-name="table" data-size="16" data-loop="true"
                                           data-c="#fff" data-hc="white"></i>
                    @lang('Trade/LendApply/title.list')
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
                    <!-- /.input group -->
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered width100" id="table">
                        <thead>
                        <tr class="filters">
                            <th>@lang('Trade/LendApply/form.lend_summary')</th>
                            <th>@lang('Trade/LendApply/form.account_name')</th>
                            <th>@lang('Trade/LendApply/form.account_seq')</th>
                            <th>@lang('Trade/LendApply/form.bank_name')</th>
                            <th>@lang('Trade/LendApply/form.account_branch')</th>
                            <th>@lang('Trade/LendApply/form.amount')</th>
                            <th>@lang('Trade/LendApply/form.lend_fee')</th>
                            <th>@lang('Trade/LendApply/form.apply_time')</th>
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
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" ></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">

    </script>

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
                applyLabel: '@lang('Trade/LogQuery/form.filter')',
                cancelLabel: '@lang('Trade/LogQuery/form.cancel')',
                daysOfWeek: ["日","一","二","三","四","五","六"],
                monthNames: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"]
            }
        });

        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            order: [[7, 'desc']],
            language: {
                search: "@lang('Trade/LendApply/form.search')",
                lengthMenu: "@lang('Trade/LendApply/form.lengthMenu')",
                zeroRecords: "@lang('Trade/LendApply/form.noData')",
                info: "@lang('Trade/LendApply/form.pageInfo')",
                infoEmpty: "@lang('Trade/LendApply/form.noData')",
                infoFiltered: "@lang('Trade/LendApply/form.infoFiltered')",
                paginate: {
                    "next": "@lang('Trade/LendApply/form.next')",
                    "previous": "@lang('Trade/LendApply/form.previous')"
                }
            },
            ajax: {
                "url": "{!! route('admin.lendApply.data') !!}",
                "type": "post",
                "data": function (d) {
                    d.companyId = $('#company_selection').val();
                    d.startDate = $('#daterange1').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.endDate = $('#daterange1').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
            columns: [
                {data: 'lend_summary', name: 'lend_summary'},
                {data: 'account_name', name: 'account_name'},
                {data: 'account_seq', name: 'account_seq'},
                {data: 'bank_name', name: 'bank_name'},
                {data: 'account_branch', name: 'account_branch'},
                {data: 'amount', name: 'amount'},
                {data: 'fee', name: 'lend_fee'},
                {data: 'created_at', name: 'created_at'}
            ]
        });

        $(document).ready(function () {
            $('#lendApply').click(function (e){
                if($('#money').val() > Number($('#td_totalIncome').text())){
                    alert("@lang('Trade/LendApply/form.lendMoney')必需小于@lang('Trade/LendApply/form.totalIncome')");
                    return;
                }

                if($('#account_selections').val() == "@lang('Trade/LendApply/form.pleaseSelect')"){
                    alert("請選擇銀行卡");
                    return;
                }

                var $validator = $('#applyForm').data('bootstrapValidator').validate();


                if ($validator.isValid()) {
                    var postData = {
                        client: $("#company_selection :selected").val(),
                        amount: $('#money').val(),
                        account: $('#account_selections').val(),
                        description: $('#description').val()
                    };

                    console.log(postData);

                    $.ajax({
                        url: "{{ route('admin.lendApply.apply') }}",
                        type: "post",
                        data: postData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        success: function (data) {
                            complete(data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('错误，与服务器沟通失败');
                        }
                    });

                    var complete = function (data){
                        console.log(data);
                        if(data.Result == 'error'){
                            alert(data.Message);
                            return;
                        }

                        alert("成功申请下发，详见下方下发列表");
                        table.ajax.reload();
                        return;
                    };
                }
            });
        });

        $('#daterange1').on('apply.daterangepicker', function(ev, picker) {
            table.ajax.reload();
        });

        function companyFilter() {
            if($('#company_selection').val() !== ''){

                var data = {
                    id: $("#company_selection :selected").val()
                };

                $.ajax({
                    url: "{{ route('admin.lendApply.getLendInfo') }}",
                    type: "post",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    success: function (data) {
                        complete(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert('错误，与服务器沟通失败');
                    }
                });

                var complete = function (data) {
                    document.getElementById("lendTitle").innerHTML = $("#company_selection :selected").text();

                    document.getElementById("td_totalMoney").innerHTML = data.totalMoney;
                    document.getElementById("td_totalFee").innerHTML = data.totalFee;
                    document.getElementById("td_totalLended").innerHTML = data.totalLended;
                    document.getElementById("td_totalIncome").innerHTML = data.totalIncome;
                    lendLimit = data.totalIncome;       //设定下发限制金额

                    data.accounts.forEach(function(account, index){
                        document.getElementById("account_selections").innerHTML += '<option value=' + account.id + '>' + account.account + '</option>';
                    });

                    table.ajax.reload();
                    $('#hidepanel1').removeClass("hidden");
                    $('#hidepanel2').removeClass("hidden");

                    return;
                };

            }else {
                $('#hidepanel1').addClass("hidden");
                $('#hidepanel2').addClass("hidden");
            }

        }

    </script>

@stop