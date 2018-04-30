@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('companies/CompanyList/title.title') }}
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
        <h1>{{ trans('companies/title.title') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    {{ trans('general.dashboard') }}
                </a>
            </li>
            <li><a href="#">{{ trans('companies/title.title') }}</a></li>
            <li class="active">{{ trans('companies/CompanyList/title.title') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="livicon" data-name="users" data-size="16" data-loop="true"
                                               data-c="#fff" data-hc="white"></i>
                        {{ trans('companies/CompanyList/title.title') }}
                    </h4>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered width100" id="table">
                            <thead>
                            <tr class="filters">
                                <th>{{ trans('companies/CompanyList/form.ID') }}</th>
                                <th>{{ trans('companies/CompanyList/form.name') }}</th>
                                <th>{{ trans('companies/CompanyList/form.service_id') }}</th>
                                <th>{{ trans('companies/CompanyList/form.sceret_key') }}</th>
                                <th>{{ trans('companies/CompanyList/form.created_at') }}</th>
                                <th>{{ trans('companies/CompanyList/form.actions') }}</th>
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
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.companies.data') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'service_id', name: 'service_id'},
                    {data: 'sceret_key', name: 'sceret_key'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });
        });

    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop
