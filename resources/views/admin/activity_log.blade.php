@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('ActivityLog/title.title') }}
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
        <h1>{{ trans('ActivityLog/title.title') }}</h1>
        <ol class="breadcrumb">
            <i class="livicon" data-name="eye-open" data-size="14" data-color="#000"></i>
            <li class="active">{{ trans('ActivityLog/title.title') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="livicon" data-name="eye-open" data-size="16" data-loop="true"
                                               data-c="#fff" data-hc="white"></i>
                        {{ trans('ActivityLog/title.title') }}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered width100" id="table" >
                            <thead>
                            <tr class="filters">
                                <th>{{ trans('ActivityLog/form.CompanyName') }}</th>
                                <th>{{ trans('ActivityLog/form.Description') }}</th>
                                <th>{{ trans('ActivityLog/form.CreatedAt') }}</th>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script>
$(function() {
    var table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.activity_log.data') !!}',
        order: [[2, 'desc']],
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
            { data: 'log_name', name: 'log_name', width: '25%'},
            { data: 'description', name: 'description', width: '50%' },
            { data: 'created_at', name:'created_at', width: '25%'}
        ]
    });
});
    </script>
@stop
