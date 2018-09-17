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

        <!-- 商户切换-->
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

        <!-- 行卡查詢-->
        <div class="panel panel-primary hidden" id="hidepanel">
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
    </section>
    <!-- content -->

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

    <script>
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
                    d.id = $('#company_selection').val();
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

        $(document).ready(function () {

            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });
        });

        function companyFilter() {
            if($('#company_selection').val() !== ''){
                table.ajax.reload();
                $('#hidepanel').removeClass("hidden");
            }else {
                $('#hidepanel').addClass("hidden");
            }

        }
    </script>

@stop
