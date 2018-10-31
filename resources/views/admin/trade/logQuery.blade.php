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

    <section class="content">
        @if($switchPromission)
            <div class="row">
                <div class="col-md-12">
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
                                    <select id="company_selection" name="company_selection"
                                            class="js--animations form-control"
                                            onchange="companyFilter(this.value);">
                                        <option value="">@lang('Trade/LogQuery/form.company_please')</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </p>
                            </div>
                            <!--content ends-->
                        </div>
                    </div>
                </div>
            </div>
    @endif

    <!-- 手續費列表-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary client-switch @if($switchPromission){{ 'hidden' }}@endif">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="livicon" data-name="list-ol" data-size="16" data-loop="true" data-c="#fff"
                               data-hc="white"></i>
                            @lang('Trade/LogQuery/title.form3')
                        </h4>
                        <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                        </span>
                    </div>

                    <fee-list/>
                </div>
            </div>
        </div>

        <!-- 訂單查詢-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary client-switch @if($switchPromission){{ 'hidden' }}@endif" id="logQuery">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="livicon" data-name="user" data-size="16" data-loop="true"
                                                   data-c="#fff" data-hc="white"></i>
                            @lang('Trade/LogQuery/title.form2')
                        </h4>
                        <span class="refresh pull-right" onclick="vm.$root.$emit('reload')">
                            <i class="livicon" data-name="refresh" data-size="18" data-loop="true" data-c="#fff"
                               data-hc="white" id="livicon-26" style="width: 18px; height: 18px;">
                            </i>
                            刷新
                        </span>
                    </div>
                    <br/>
                    <order-search/>
                </div>
            </div>
        </div>

    </section>
    <!-- content -->

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script>
                @if(!$switchPromission)
        var company = '{{ Sentinel::getUser()->id }}';
        @endif
    </script>


    <script type="text/javascript" src="{{ asset('assets/js/OrderSearch.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

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

    <div class="modal fade" id="show_Info" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="stateEditModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                },
                processing: "@lang('dataTable.processing')"
            },
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "全部"]],
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{!! route('admin.authcode.data') !!}",
                "type": "post",
                "data": function (d) {
                    @if($switchPromission)
                        d.company = $('#company_selection').val();
                    @else
                        d.company = '{{ Sentinel::getUser()->id }}';
                    @endif
                        d.startDate = $('#daterange1').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.endDate = $('#daterange1').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    d.payState = $('#paystate').val();
                }
            },
            columns: [
                {data: 'pay_summary', name: 'pay_summary'},
                {data: 'trade_seq', name: 'trade_seq'},
                {data: 'trade_service_id', name: 'trade_service_id'},
                {data: 'company_name', name: 'company_name'},
                {data: 'amount', name: 'amount'},
                {data: 'payment_name', name: 'payment_name'},
                {data: 'fee', name: 'fee'},
                {data: 'created_at', name: 'created_at'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            columnDefs: [{
                "targets": [1, 7],
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css('max-width', '120px');
                    $(td).css('white-space', 'nowrap');
                    $(td).css('text-overflow', 'ellipsis');
                    $(td).css('word-break', 'break-all');
                    $(td).css('overflow', 'hidden');
                    $(td).attr('title', cellData);
                }
            }],
            order: [[7, 'desc']],
            fnFooterCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get float data for summation
                var floatVal = function (f) {
                    return (f != null) ? new Decimal(f) : new Decimal(0.0);
                };

                // Total over this pages
                pageAmount = api
                    .column(4, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return Decimal.add(floatVal(a), floatVal(b));
                    }, 0);

                // Total over this page
                pageFee = api
                    .column(6, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return Decimal.add(floatVal(a), floatVal(b));
                    }, 0);

                // Update total amount
                document.getElementById("td_totalMoney").innerHTML = pageAmount;
                document.getElementById("td_totalFee").innerHTML = pageFee;
            }
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
            ajax: {
                "url": "{!! route('admin.authcode.feeData') !!}",
                "type": "post",
                "data": function (d) {
                    @if($switchPromission)
                        d.company = $('#company_selection').val();
                    @else
                        d.company = '{{ Sentinel::getUser()->id }}';
                    @endif
                }
            },
            columns: [
                {data: 'i6pay_id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'fee', name: 'fee'},
                {data: 'status', name: 'status'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            order: [[0, 'asc']]
        });

        $(document).ready(function () {
            fee_table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
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

            $(document).on('click', '.notifyBtn', function () {
                var postData = {
                    id: $(this).data('callurl')
                };

                $.ajax({
                    url: '{{ route('admin.authcode.callNotify') }}',
                    type: 'post',
                    data: postData,
                    dataType: 'json',
                    success: function (data) {
                        if (data.Result == 'OK') {
                            alert('回调成功');

                            table.ajax.reload();
                        }
                        else
                            alert(data.Message);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr + ' ' + thrownError);
                        alert('与服务器沟通错误');
                    }
                });
            });
        });

        $('#daterange1').on('apply.daterangepicker', function (ev, picker) {
            table.ajax.reload();
        });

        function companyFilter() {
            if ($('#company_selection').val() !== '') {
                table.ajax.reload();
                // fee_table.ajax.reload();
                vm.$root.$emit('getFeeData')
                $('.client-switch').removeClass("hidden");
            } else {
                $('.client-switch').addClass("hidden");
            }
        }

        function stateFilter() {
            table.ajax.reload();
            // fee_table.ajax.reload();
            vm.$root.$emit('getFeeData')
        }

        {{--重新整理--}}
        $("#refresh_button").click(function () {
            companyFilter();
        });

    </script>

@stop
