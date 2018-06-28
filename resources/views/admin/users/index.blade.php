@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('users/UserList/title.title') }}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>{{ trans('users/title.title') }}</h1>
    <ol class="breadcrumb">
        <li>
            <i class="livicon" data-name="user" data-size="14" data-loop="true"></i>
            {{ trans('users/title.title') }}
        </li>
        <li class="active">{{ trans('users/UserList/title.title') }}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    {{ trans('users/UserList/title.title') }}
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-bordered width100" id="table">
                    <thead>
                        <tr class="filters">
                            <th>{{ trans('users/UserList/form.ID') }}</th>
                            <th>{{ trans('users/UserList/form.company_name') }}</th>
                            <th>{{ trans('users/UserList/form.full_name') }}</th>
                            <th>{{ trans('users/UserList/form.User_Email') }}</th>
                            <th>{{ trans('users/UserList/form.Status') }}</th>
                            <th>{{ trans('users/UserList/form.Actions') }}</th>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

<script>
    $(function() {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.users.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'company_name', name: 'company_name' },
                { data: 'full_name', name: 'first_name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        table.on( 'draw', function () {
            $('.livicon').each(function(){
                $(this).updateLivicon();
            });
        } );
    });

</script>

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
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
