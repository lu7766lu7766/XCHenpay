@extends('admin.layouts.default')

{{-- Page title --}}
@section('title')
@lang('users/DeletedUsers/title.title')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
    <!-- end page css -->
@stop

{{-- Page content --}}
@section('content')

<section class="content-header">
                <h1>@lang('users/DeletedUsers/title.title')</h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="livicon" data-name="user" data-size="14" data-loop="true"></i>
                        @lang('users/title.title')
                    </li>
                    <li class="active">@lang('users/DeletedUsers/title.title')</li>
                </ol>
            </section>
            <!-- Main content -->
         <section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="livicon" data-name="users-remove" data-size="18" data-c="#ffffff" data-hc="#ffffff"></i>
                    @lang('users/DeletedUsers/title.list')
                </h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                    <tr class="filters">
                        <th>@lang('users/DeletedUsers/form.ID')</th>
                        <th>@lang('users/DeletedUsers/form.company_name')</th>
                        <th>@lang('users/DeletedUsers/form.full_name')</th>
                        <th>@lang('users/DeletedUsers/form.User_Email')</th>
                        <th>@lang('users/DeletedUsers/form.Deleted_At')</th>
                        <th>@lang('users/DeletedUsers/form.Actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{!! $user->id !!}</td>
                            <td>{!! $user->company_name !!}</td>
                            <td>{!! $user->last_name . ' ' . $user->first_name !!}</td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! \Carbon\Carbon::parse($user->deleted_at)->diffForHumans() !!}</td>
                            <td>
                                <a href="{{ route('admin.restore.user', $user->id) }}" title=@lang('users/DeletedUsers/form.restoreUser')>
                                    <i class="livicon" data-name="user-flag" data-c="#6CC66C" data-hc="#6CC66C" data-size="18"></i></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</section>

        
    @stop

{{-- page level scripts --}}
@section("footer_scripts")
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@stop
