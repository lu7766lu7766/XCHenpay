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
                            @lang('users/EditProfile/form.Editing')<p class="user_name_max">{!! $user->first_name!!} {!! $user->last_name!!}</p>
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

                                                <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                                    <label for="last_name" class="col-sm-2 control-label">@lang('users/EditProfile/form.last_name') *</label>
                                                    <div class="col-sm-10">
                                                        <input id="last_name" name="last_name" type="text" placeholder="@lang('users/EditProfile/form.last_name')"
                                                               class="form-control required"
                                                               value="{!! old('last_name', $user->last_name) !!}"/>
                                                    </div>
                                                    {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                                    <label for="first_name" class="col-sm-2 control-label">@lang('users/EditProfile/form.first_name') *</label>
                                                    <div class="col-sm-10">
                                                        <input id="first_name" name="first_name" type="text"
                                                               placeholder="@lang('users/EditProfile/form.first_name')" class="form-control required"
                                                               value="{!! old('first_name', $user->first_name) !!}"/>
                                                    </div>
                                                    {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
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

                                                <div class="form-group {{ $errors->first('address', 'has-error') }}">
                                                    <label for="address" class="col-sm-2 control-label">@lang('users/EditProfile/form.address')</label>
                                                    <div class="col-sm-10">
                                                        <input id="address" name="address" type="text"
                                                               placeholder="@lang('users/EditProfile/form.address')" class="form-control required"
                                                               value="{!! old('address', $user->address) !!}"/>
                                                    </div>
                                                    {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
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

                                                {{--<div class="form-group">--}}
                                                    {{--<label for="activate" class="col-sm-2 control-label">@lang('users/EditProfile/form.activate')</label>--}}
                                                    {{--<div class="col-sm-10">--}}
                                                        {{--<input id="activate" name="activate" type="checkbox" class="pos-rel p-l-30 custom-checkbox" value="1" @if($status) checked="checked" @endif  >--}}
                                                        {{--<span>@lang('users/EditProfile/form.activate_message')</span>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
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
    <script>
        function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="{{asset('assets/img/countries_flags')}}/'+ state.element.value.toLowerCase() + '.png" class="img-flag" width="20px" height="20px" /> ' + state.text + '</span>'
            );
            return $state;

}
$(".country_field").select2({
    templateResult: formatState,
    templateSelection: formatState,
    placeholder: "select a country",
    theme:"bootstrap"
});


</script>
@stop
