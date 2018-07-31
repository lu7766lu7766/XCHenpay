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
        <h1>@lang('Trade/LendManage/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="balance" data-size="14" data-loop="true"></i>
                @lang('Trade/title.title')
            </li>
            <li class="active">@lang('Trade/LendManage/title.title')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content paddingleft_right15">
        {{--商戶篩選--}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="filter" data-size="16" data-loop="true" data-c="#fff"
                       data-hc="white"></i>
                    @lang('Trade/LendManage/form.company_switch')
                </h3>
                <span class="pull-right clickable">
                                <i class="glyphicon glyphicon-chevron-up"></i>
                            </span>
            </div>
            <div class="panel-body text-center">
                <!--content starts-->
                <div class="warp">
                    <p>
                        <select id="company_selection" name="company_selection" class="js--animations form-control" onchange="companyFilter(this.value);">
                            <option value="">@lang('Trade/LendManage/form.company_please')</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    </p>
                </div>
                <!--content ends-->
            </div>
        </div>

        {{--申請列表--}}
        <div class="panel panel-primary hidden" id="hidepanel1">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="livicon" data-name="table" data-size="16" data-loop="true"
                                           data-c="#fff" data-hc="white"></i>
                    @lang('Trade/LendManage/title.list'): <i id="lendTitle"></i>
                </h4>
                <span class="pull-right clickable">
                                <i class="glyphicon glyphicon-chevron-up"></i>
                            </span>
            </div>

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
                            {{--<th></th>--}}
                            <th>@lang('Trade/LendManage/form.lend_summary')</th>
                            <th>@lang('Trade/LendManage/form.record_seq')</th>
                            <th>@lang('Trade/LendManage/form.account_name')</th>
                            <th>@lang('Trade/LendManage/form.account')</th>
                            <th>@lang('Trade/LendManage/form.total_amount')</th>
                            <th>@lang('Trade/LendManage/form.apply_time')</th>
                            <th>@lang('Trade/LendManage/form.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                {{--<button id="ManageAllButton" class="btn btn-primary">@lang('Trade/LendManage/form.lendAll')</button>--}}
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

    <div class="modal fade" id="lend_manage" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="lend_info" tabindex="-1" role="dialog" aria-hidden="true">
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
                "url": "{!! route('admin.lendManage.data') !!}",
                "type": "post",
                "data": function (d) {
                    d.companyId = $('#company_selection').val();
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
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[5, 'desc']]
        });

        $('#daterange1').on('apply.daterangepicker', function(ev, picker) {
            table.ajax.reload();
        });

        $(document).ready(function () {
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });

            //clear the data in hidden modal
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });

        //Manage selected students
        $('#ManageAllButton').on('click', function () {
            console.log("todo");
        });

        function companyFilter() {
            if($('#company_selection').val() !== ''){

                var data = {
                    id: $("#company_selection :selected").val()
                };

                $.ajax({
                    url: "{{ route('admin.lendManage.getLendInfo') }}",
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

                    table.ajax.reload();
                    $('#hidepanel1').removeClass("hidden");

                    return;
                };

            }else {
                $('#hidepanel1').addClass("hidden");
            }

        }

    </script>

@stop