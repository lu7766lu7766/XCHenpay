@extends('admin.layouts.default')

{{-- Page title --}}
@section('title')
    {{ trans('Trade/title.title') }}
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
        <!--section starts-->
        <h1>@lang('Trade/LogQuery/title.title')</h1>

        <ol class="breadcrumb">
            <i class="livicon" data-name="table" data-size="14" data-loop="true"></i>
            <li class="active">
                @lang('Trade/LogQuery/title.title')
            </li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        @if($switchPromission)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="stopwatch" data-size="16" data-loop="true" data-c="#fff"
                           data-hc="white"></i>
                        @lang('Trade/LogQuery/title.form1')
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
                                <optgroup label="@lang('Trade/LogQuery/form.company_please')">
                                    <option value="">@lang('Trade/LogQuery/form.allCompanies')</option>
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
        @endif

        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="livicon" data-name="user" data-size="16" data-loop="true"
                                               data-c="#fff" data-hc="white"></i>
                        @lang('Trade/LogQuery/title.form2')
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
                                <th>{{ trans('Trade/LogQuery/form.pay_summary') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.trade_seq') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.company_name') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.amount') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.payment_type') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.fee') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.apply_time') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    <!-- row-->

        <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="livicon" data-name="settings" data-size="16" data-loop="true"
                                               data-c="#fff" data-hc="white"></i>
                        @lang('Trade/LogQuery/title.form3')
                    </h4>
                    <span class="pull-right clickable">
                                <i class="glyphicon glyphicon-chevron-up"></i>
                            </span>
                </div>

                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered width100" id="fee_table">
                            <thead>
                            <tr class="filters">
                                <th>@lang('Trade/LendManage/form.API_id')</th>
                                <th>@lang('Trade/LendManage/form.payment_name')</th>
                                <th>@lang('Trade/LendManage/form.fee')</th>
                                <th>@lang('Trade/LendManage/form.actions')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    {{--<button id="ManageAllButton" class="btn btn-primary">@lang('Trade/LendManage/form.lendAll')</button>--}}
                </div>
            </div>
    </section>
    <!-- content -->

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" ></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <div class="modal fade" id="show_FeeInfo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="edit_FeeInfo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <script>
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
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{!! route('admin.authcode.data') !!}",
                "type": "post",
                "data": function (d) {
                    @if( $switchPromission )
                    if ($('#company_selection').val() !== '')
                        d.company = $('#company_selection').val();
                    @endif
                    d.startDate = $('#daterange1').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.endDate = $('#daterange1').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
            columns: [
                {data: 'pay_summary', name: 'pay_summary'},
                {data: 'short_trade_seq', name: 'trade_seq'},
                {data: 'company_name', name: 'company_name'},
                {data: 'amount', name: 'amount'},
                {data: 'payment_name', name: 'payment_name'},
                {data: 'fee', name: 'fee'},
                {data: 'created_at', name: 'created_at'}
            ],
            order: [[6, 'desc']]
        });

        var fee_table = $('#fee_table').DataTable({
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
                }
            },
            processing: true,
            serverSide: true,
            searching: false,
            paginate: false,
            info: false,
            ajax: "{!! route('admin.authcode.feeData') !!}",
            columns: [
                {data: 'i6pay_id', name: 'id'},
                {data: 'name', name: 'payment_name'},
                {data: 'fee', name: 'fee'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']]
        });

        $(document).ready(function () {
            fee_table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });

            //clear the data in hidden modal
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });

        $('#daterange1').on('apply.daterangepicker', function(ev, picker) {
            console.log(picker.startDate.format('YYYY-MM-DD'));
            console.log(picker.endDate.format('YYYY-MM-DD'));
            table.ajax.reload();
        });

        function companyFilter() {
            table.ajax.reload();
        }

    </script>

@stop
