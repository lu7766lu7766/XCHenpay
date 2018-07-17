@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('users/AddUser/title.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/pages/wizard.css') }}" rel="stylesheet">
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>@lang('users/AddUser/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="user" data-size="14" data-loop="true"></i>
                @lang('users/title.title')
            </li>
            <li class="active">@lang('users/AddUser/title.title')</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff"
                               data-loop="true"></i>
                            @lang('users/AddUser/title.title')
                        </h3>
                        <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                    </div>
                    <div class="panel-body">
                        <!--main content-->
                        <form id="commentForm" action="{{ route('admin.users.store') }}"
                              method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                            <div id="rootwizard">
                                <ul>
                                    <li><a href="#tab1" data-toggle="tab">@lang('users/AddUser/form.UserProfile')</a></li>
                                    <li><a href="#tab2" data-toggle="tab">@lang('users/AddUser/form.UserContact')</a></li>
                                    <li><a href="#tab3" data-toggle="tab">@lang('users/AddUser/form.UserGroup')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane" id="tab1">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="form-group {{ $errors->first('company_name', 'has-error') }}">
                                            <label for="company_name"
                                                   class="col-sm-2 control-label">@lang('users/AddUser/form.company_name')
                                                *</label>
                                            <div class="col-sm-10">
                                                <input id="company_name" name="company_name"
                                                       placeholder=@lang('users/AddUser/form.company_name')
                                                               type="text"
                                                       class="form-control required"
                                                       value="{!! old('company_name') !!}"/>

                                                {!! $errors->first('company_name', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab2" disabled="disabled">
                                        <h2 class="hidden">&nbsp;</h2>

                                        <div class="form-group {{ $errors->first('mobile', 'has-error') }}">
                                            <label for="mobile"
                                                   class="col-sm-2 control-label">@lang('users/AddUser/form.mobile')
                                                *</label>
                                            <div class="col-sm-10">
                                                <input id="mobile" name="mobile" type="tel"
                                                       placeholder=@lang('users/AddUser/form.mobile')  type="tel"
                                                       class="form-control required" value="{!! old('mobile') !!}"/>
                                                {!! $errors->first('mobile', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                            <label for="email"
                                                   class="col-sm-2 control-label">@lang('users/AddUser/form.user_email')
                                                *</label>
                                            <div class="col-sm-10">
                                                <input id="email" name="email"
                                                       placeholder="@lang('users/AddUser/form.user_email')" type="text"
                                                       class="form-control required email"
                                                       value="{!! old('email') !!}"/>
                                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('QQ_id', 'has-error') }}">
                                            <label for="QQ_id"
                                                   class="col-sm-2 control-label">@lang('users/AddUser/form.QQ_id')
                                                *</label>
                                            <div class="col-sm-10">
                                                <input id="QQ_id" name="QQ_id"
                                                       placeholder="@lang('users/AddUser/form.QQ_id')"
                                                       type="text" class="form-control required"/>
                                                {!! $errors->first('QQ_id', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab3" disabled="disabled">
                                        <p class="text-danger">
                                            <strong>@lang('users/AddUser/form.group_warning')</strong></p>

                                        <div class="form-group required">
                                            <label for="group"
                                                   class="col-sm-2 control-label">@lang('users/AddUser/form.group')
                                                *</label>
                                            <div class="col-sm-10">
                                                <select class="form-control required" title="Select group..." name="group" id="group">
                                                    <option value="">Select</option>
                                                    @foreach($groups as $group)
                                                        <option value="{{ $group->id }}"
                                                                @if($group->id == old('group')) selected="selected" @endif >{{ $group->name}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('group', '<span class="help-block">:message</span>') !!}
                                            </div>
                                            <span class="help-block">{{ $errors->first('group', ':message') }}</span>
                                        </div>
                                    </div>
                                    <ul class="pager wizard">
                                        <li class="previous"><a href="#">@lang('users/AddUser/form.previous')</a></li>
                                        <li class="next"><a href="#">@lang('users/AddUser/form.next')</a></li>
                                        <li class="next finish" style="display:none;"><a href="javascript:;">@lang('users/AddUser/form.finish')</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--row end-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}"type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/adduser.js') }}"></script>
@stop
