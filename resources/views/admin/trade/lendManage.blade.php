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
            <li class="active">@lang('Trade/LendManage/title.title')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        {{--商戶篩選--}}
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
                            <optgroup label="@lang('Trade/LendApply/form.company_please')">
                                <option value="">@lang('Trade/LendApply/form.allCompanies')</option>
                                {{--@foreach($companies as $company)--}}
                                {{--<option value="{{ $company->id }}">{{ $company->company_name }}</option>--}}
                                {{--@endforeach--}}
                            </optgroup>
                        </select>
                    </p>
                </div>
                <!--content ends-->
            </div>
        </div>

        {{--申請列表--}}
        <div class="row">
            <div class="panel panel-primary ">
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
                                <th></th>
                                <th>@lang('Trade/LendManage/form.lend_summary')</th>
                                <th>@lang('Trade/LendManage/form.account_name')</th>
                                <th>@lang('Trade/LendManage/form.account_seq')</th>
                                <th>@lang('Trade/LendManage/form.bank_name')</th>
                                <th>@lang('Trade/LendManage/form.account_branch')</th>
                                <th>@lang('Trade/LendManage/form.amount')</th>
                                <th>@lang('Trade/LendManage/form.lend_fee')</th>
                                <th>@lang('Trade/LendManage/form.apply_time')</th>
                                <th>@lang('Trade/LendManage/form.action')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" ></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-datatables-checkboxes/js/dataTables.checkboxes.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js') }}" ></script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script type="text/javascript">
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
            language: {
                search: "@lang('Trade/LendManage/form.search')",
                lengthMenu: "@lang('Trade/LendManage/form.lengthMenu')",
                zeroRecords: "@lang('Trade/LendManage/form.noData')",
                info: "@lang('Trade/LendManage/form.pageInfo')",
                infoEmpty: "@lang('Trade/LendManage/form.noData')",
                infoFiltered: "@lang('Trade/LendManage/form.infoFiltered')",
                paginate: {
                    "next": "@lang('Trade/LendManage/form.next')",
                    "previous": "@lang('Trade/LendManage/form.previous')"
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
            columnDefs: [
                {'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            columns: [
                {data: 'id',name: 'select'},
                {data: 'lend_summary', name: 'lend_summary'},
                {data: 'account_name', name: 'account_name'},
                {data: 'account_seq', name: 'account_seq'},
                {data: 'bank_name', name: 'bank_name'},
                {data: 'account_branch', name: 'account_branch'},
                {data: 'amount', name: 'amount'},
                {data: 'fee', name: 'amount'},
                {data: 'created_at', name: 'lend_fee'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[8, 'desc']]
        });

        $(document).ready(function () {

            //Delete selected students
            $('#LendAllButton').on('click', function () {
                var $selectedRows = $('#StudentTableContainer').jtable('selectedRows');

                $('#StudentTableContainer').jtable('manageButtonClickedForRows', $selectedRows);
            });

            //Re-load records when user click 'load records' button.
            $('#LoadRecordsButton').on('click', function (e) {
                e.preventDefault();
                $('#StudentTableContainer').jtable('load', {
                    trade_service_id: $('#service_id').val()
                });
            });
        });

    </script>

@stop