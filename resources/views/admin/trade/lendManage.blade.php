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
                                <th>@lang('Trade/LendApply/form.pay_summary')</th>
                                <th>@lang('Trade/LendApply/form.trade_seq')</th>
                                <th>@lang('Trade/LendApply/form.company_name')</th>
                                <th>@lang('Trade/LendApply/form.amount')</th>
                                <th>@lang('Trade/LendApply/form.payment_type')</th>
                                <th>@lang('Trade/LendApply/form.fee')</th>
                                <th>@lang('Trade/LendApply/form.apply_time')</th>
                                <th>@lang('Trade/LendApply/form.operation')</th>
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
        $(document).ready(function () {

            //Prepare jtable plugin
            $('#StudentTableContainer').jtable({
                title: '订单列表',
                paging: true, //Enable paging
                pageSize: 10, //Set page size (default: 10)
                sorting: true, //Enable sorting
                defaultSorting: 'id ASC', //Set default sorting
                selecting: true, //Enable selecting
                multiselect: true, //Allow multiple selecting
                selectingCheckboxes: true,
                //selectOnRowClick: false, //Enable this to only select using checkboxes
                ajaxSettings: {
                    type: 'GET',
                    dataType: 'json'
                },
                actions: {
                    listAction:  "{{ url('admin/lendManage/data') }}",
                    manageAction: function (postData) {
                        // console.log("creating from custom lendAction...");
                        return $.Deferred(function ($dfd) {
                            $.ajax({
                                url: "{{ url('admin/lendManage') }}",
                                type: 'POST',
                                dataType: 'json',
                                data: postData,
                                success: function (data) {
                                    console.log('success');
                                    console.log(data);
                                    $dfd.resolve(data);
                                },
                                error: function (data) {
                                    console.log('error');
                                    console.log(data);
                                    $dfd.reject();
                                }
                            });
                        });
                    }
                },
                fields: {
                    id: {
                        key: true,
                        create: false,
                        edit: false,
                        list: false
                    },
                    pay_summary: {
                        title: '交易状态',{{--@lang('Trade/landApply/form.pay_summary')--}}
                        width: '20%',
                        inputClass: 'validate[required], form-control'
                    },
                    trade_service_id: {
                        title: '交易服务编号',
                        width: '20%',
                        inputClass: 'validate[required], form-control'
                    },
                    item_code: {
                        title: '产品编号',
                        width: '20%',
                        inputClass: 'validate[required], form-control'
                    },
                    payment_type: {
                        title: '交易方式',
                        width: '15%',
                        inputClass: 'validate[required], form-control'
                    },
                    amount: {
                        title: '金额',
                        width: '10%',
                        inputClass: 'validate[required], form-control'
                    },
                    currency: {
                        title: '币别',
                        width: '20%',
                        inputClass: 'validate[required,custom[email]], form-control'
                    }

                }
            });

            //Load student list from server
            $('#StudentTableContainer').jtable('load');

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

            $('#reset-search').on('click', function (e) {
                $('#service_id').val('');
            });

            $('.jtable-left-area select').addClass('form-control');
            // $('button').addClass('btn btn-default');
            // $('#AddRecordDialogSaveButton, #EditDialogSaveButton').removeClass('btn-default').addClass('btn-primary');
            // $('#DeleteDialogButton').removeClass('btn-default').addClass('btn-danger');
            // $('#DeleteAllButton,#LoadRecordsButton').removeClass('btn-default');
        });

    </script>

@stop