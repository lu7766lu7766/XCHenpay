@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('users/createdUser/title.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/pages/user_profile.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}"/>
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>@lang('users/createdUser/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="user" data-size="14" data-loop="true"></i>
                @lang('users/title.title')
            </li>
            <li>
                <i class="livicon" data-name="user-add" data-size="14" data-loop="true"></i>
                @lang('users/title.addUser')
            </li>
            <li class="active">@lang('users/createdUser/title.title')</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="doc-portrait" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>@lang('users/ViewProfile/title.information')
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form action="#" class="form-horizontal">
                            <div class="form-body" style="padding: 0 15px;">
                                <h3>@lang('users/createdUser/title.information')</h3>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">@lang('users/createdUser/form.company_name') :</label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{  $user->company_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">@lang('users/createdUser/form.company_service_id') :</label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{ $user->company_service_id }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">@lang('users/createdUser/form.sceret_key') :</label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{ $user->sceret_key }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">@lang('users/createdUser/form.mobile') :</label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{ $user->mobile }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">@lang('users/createdUser/form.QQ_id') :</label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{ $user->QQ_id }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">@lang('users/createdUser/form.group') :</label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{ $role->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3>@lang('users/createdUser/title.name_pwd')</h3>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">@lang('users/createdUser/form.email') :</label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">@lang('users/createdUser/form.password') :</label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">{{ $pwd }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop

