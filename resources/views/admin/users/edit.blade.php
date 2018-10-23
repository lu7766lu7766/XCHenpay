@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('users/EditProfile/title.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/wizard.css') }}" rel="stylesheet">
    <!--end of page level css-->

@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>@lang('users/EditProfile/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="user" data-size="14" data-loop="true"></i>
                @lang('users/title.title')
            </li>
            <li class="active">@lang('users/EditProfile/title.title')</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"> <i class="livicon" data-name="users" data-size="16" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            @lang('users/EditProfile/form.Editing')<p class="user_name_max">{!! $user->email!!}</p>
                        </h3>
                    <span class="pull-right clickable">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                    </div>
                    <div class="panel-body">
                        <!--main content-->
                        <div class="row">

                            <div class="col-md-12">

                                {!! Form::model($user, ['url' => URL::to('admin/users/'. $user->id.''), 'method' => 'put', 'class' => 'form-horizontal','id'=>'commentForm', 'enctype'=>'multipart/form-data','files'=> true]) !!}
                                    {{ csrf_field() }}

                                    <div id="rootwizard">
                                        <ul>
                                            <li><a href="#tab1" data-toggle="tab">@lang('users/EditProfile/form.UserProfile')</a></li>
                                            @if(Sentinel::getUser()->roles->first()->slug == "admin")
                                                <li><a href="#tab2" data-toggle="tab">@lang('users/EditProfile/form.UserGroup')</a></li>
                                            @endif
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane" id="tab1">
                                                <h2 class="hidden">&nbsp;</h2>

                                                <div class="form-group {{ $errors->first('company_name', 'has-error') }}">
                                                    <label for="company_name" class="col-sm-2 control-label">@lang('users/EditProfile/form.company_name') *</label>
                                                    <div class="col-sm-10">
                                                        <input id="company_name" name="company_name" placeholder=@lang('users/EditProfile/form.company_name')
                                                                type="text"
                                                               class="form-control required"
                                                               value="{!! old('company_name', $user->company_name) !!}"/>
                                                    </div>
                                                    {!! $errors->first('company_name', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('mobile', 'has-error') }}">
                                                    <label for="mobile" class="col-sm-2 control-label">@lang('users/EditProfile/form.mobile') *</label>
                                                    <div class="col-sm-10">
                                                        <input id="mobile" name="mobile" type="text"
                                                               placeholder="@lang('users/EditProfile/form.mobile')" class="form-control required"
                                                               value="{!! old('mobile', $user->mobile) !!}"/>
                                                    </div>
                                                    {!! $errors->first('mobile', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                                    <label for="email" class="col-sm-2 control-label">@lang('users/EditProfile/form.email') *</label>
                                                    <div class="col-sm-10">
                                                        <input id="email" name="email" placeholder="@lang('users/EditProfile/form.email')" type="text"
                                                               class="form-control required email"
                                                               value="{!! old('email', $user->email) !!}"/>

                                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group {{ $errors->first('status', 'has-error') }}">
                                                    <label for="status" class="col-sm-2 control-label">@lang('users/EditProfile/form.status') *</label>
                                                    <div class="col-sm-10">
														<label class="radio-inline"><input id="status_on" name="status" type="radio"  value="on" {!! $user->status == 'on' ? 'checked' : '' !!}>@lang('users/EditProfile/form.open')</label>
														<label class="radio-inline"><input id="status_off" name="status" type="radio" value="off" {!! $user->status == 'off' ? 'checked' : '' !!}>@lang('users/EditProfile/form.close')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group {{ $errors->first('apply_status', 'has-error') }}">
                                                    <label for="apply_status" class="col-sm-2 control-label">@lang('users/EditProfile/form.apply_status') *</label>
                                                    <div class="col-sm-10">
														<label class="radio-inline"><input id="apply_status_on" name="apply_status" type="radio" value="on" {!! $user->apply_status == 'on' ? 'checked' : '' !!}>@lang('users/EditProfile/form.open')</label>
														<label class="radio-inline"><input id="apply_status_off" name="apply_status" type="radio" value="off" {!! $user->apply_status == 'off' ? 'checked' : '' !!}>@lang('users/EditProfile/form.close')</label>
                                                    </div>
                                                </div>



                                                <div class="form-group {{ $errors->first('QQ_id', 'has-error') }}">
                                                    <label for="QQ_id" class="col-sm-2 control-label">@lang('users/EditProfile/form.QQ_id') *</label>
                                                    <div class="col-sm-10">
                                                        <input id="QQ_id" name="QQ_id" type="text"
                                                               placeholder="@lang('users/EditProfile/form.QQ_id')" class="form-control required"
                                                               value="{!! old('QQ_id', $user->QQ_id) !!}"/>
                                                    </div>
                                                    {!! $errors->first('QQ_id', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                                    <p class="text-warning">@lang('users/EditProfile/form.password_message')</p>
                                                    <label for="password" class="col-sm-2 control-label">@lang('users/EditProfile/form.password') </label>
                                                    <div class="col-sm-10">
                                                        <input id="password" name="password" type="password" placeholder="@lang('users/EditProfile/form.password')"
                                                               class="form-control" value="{!! old('password') !!}"/>
                                                    </div>
                                                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                                    <label for="password_confirm" class="col-sm-2 control-label">@lang('users/EditProfile/form.confirm_password') </label>
                                                    <div class="col-sm-10">
                                                        <input id="password_confirm" name="password_confirm" type="password"
                                                               placeholder="@lang('users/EditProfile/form.confirm_password')" class="form-control"
                                                               value="{!! old('password_confirm') !!}"/>
                                                        {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="tab-pane" id="tab2" disabled="disabled">
                                                <p class="text-danger"><strong>@lang('users/EditProfile/form.group_warning')</strong></p>
                                                <div class="form-group {{ $errors->first('group', 'has-error') }}">
                                                    <label for="group" class="col-sm-2 control-label">@lang('users/EditProfile/form.group') *</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control " title="Select group..." name="groups[]" id="groups" required>
                                                            <option value="">Select</option>
                                                            @foreach($roles as $role)
                                                                <option value="{!! $role->id !!}" {{ (array_key_exists($role->id, $userRoles) ? ' selected="selected"' : '') }}>{{ $role->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div
                                                            {!! $errors->first('group', '<span class="help-block">:message</span>') !!}>
                                                </div>

                                            </div>

                                            <ul class="pager wizard">
                                                <li class="previous"><a href="#">@lang('users/EditProfile/form.previous')</a></li>
                                                <li class="next"><a href="#">@lang('users/EditProfile/form.next')</a></li>
                                                <li class="next finish" style="display:none;"><a href="javascript:;">@lang('users/EditProfile/form.finish')</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!--main content end-->
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
    <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/edituser.js') }}"></script>
@stop
