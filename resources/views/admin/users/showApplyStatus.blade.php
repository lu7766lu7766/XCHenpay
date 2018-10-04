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
        <h1>@lang('users/EditProfile/title.ApplyStatustitle')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="user" data-size="14" data-loop="true"></i>
                @lang('users/title.title')
            </li>
            <li class="active">@lang('users/EditProfile/title.ApplyStatustitle')</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"> <i class="livicon" data-name="users" data-size="16" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            @lang('users/EditProfile/form.EditApplyStatus')&nbsp;:&nbsp;<p class="user_name_max">{!! $user->email!!}</p>
                        </h3>
                        <span class="pull-right clickable">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                    </div>
                    <div class="panel-body">
                        <!--main content-->
                        <div class="row">

                            <div class="col-md-12">

                                {!! Form::model($user, ['url' => URL::to('admin/users/'. $user->id .'/updateApplyStatus'), 'method' => 'get', 'class' => 'form-horizontal','id'=>'commentForm', 'enctype'=>'multipart/form-data','files'=> true]) !!}
                                {{ csrf_field() }}
                                <div id="rootwizard">
                                    <ul>
                                        <li><a href="#tab1" data-toggle="tab">@lang('users/EditProfile/form.UserProfile')</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="tab1">
                                            <h2 class="hidden">&nbsp;</h2>

                                            <div class="form-group {{ $errors->first('company_name', 'has-error') }}">
                                                <label for="company_name" class="col-sm-2 control-label">@lang('users/EditProfile/form.company_name')</label>
                                                <div class="col-sm-10">
                                                    {{ $user->company_name }}
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->first('apply_status', 'has-error') }}">
                                                <label for="apply_status" class="col-sm-2 control-label">@lang('users/EditProfile/form.apply_status')</label>
                                                <div class="col-sm-10">
                                                    <label class="radio-inline"><input id="apply_status" name="apply_status" type="radio" value="on" {!! $user->apply_status == 'on' ? 'checked' : '' !!}>@lang('users/EditProfile/form.open')</label>
                                                    <label class="radio-inline"><input id="apply_status" name="apply_status" type="radio" value="off" {!! $user->apply_status == 'off' ? 'checked' : '' !!}>@lang('users/EditProfile/form.close')</label>
                                                </div>
                                            </div>

                                        </div>

                                        <ul class="pager wizard">
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
