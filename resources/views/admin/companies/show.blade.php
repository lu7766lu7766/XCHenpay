@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('companies/ViewProfile/title.title') }}
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet"/>

    <link href="{{ asset('assets/css/pages/user_profile.css') }}" rel="stylesheet"/>
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>{{ trans('companies/ViewProfile/title.title') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    {{ trans('general.dashboard') }}
                </a>
            </li>
            <li>
                <a href="#">{{ trans('companies/title.title') }}</a>
            </li>
            <li class="active">{{ trans('companies/ViewProfile/title.title') }}</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav  nav-tabs ">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab">
                            <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
                            {{ trans('companies/ViewProfile/title.title') }}</a>
                    </li>
                    {{--//todo 要把後臺資料&API資料分成兩頁--}}
                    {{--<li>--}}
                        {{--<a href="#tab2" data-toggle="tab">--}}
                            {{--<i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>--}}
                            {{--Change Password</a>--}}
                    {{--</li>--}}


                </ul>
                <div  class="tab-content mar-top">
                    <div id="tab1" class="tab-pane fade active in">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    {{--<div class="panel-heading">--}}
                                        {{--<h3 class="panel-title">--}}

                                            {{--{{ trans('companies/ViewProfile/title.title') }}--}}
                                        {{--</h3>--}}

                                    {{--</div>--}}
                                    <div class="panel-body">
                                        {{--<div class="col-md-4">--}}
                                            {{--<div class="img-file">--}}
                                                {{--@if($company->pic)--}}
                                                    {{--<img src="{!! url('/').'/uploads/users/'.$company->pic !!}" alt="img"--}}
                                                         {{--class="img-responsive"/>--}}
                                                {{--@else--}}
                                                    {{--<img src="{{ asset('assets/images/authors/no_avatar.jpg') }}" alt="..."--}}
                                                         {{--class="img-responsive"/>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        <div class="col-md-16">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="users">

                                                        <tr>
                                                            <td>@lang('companies/ViewProfile/form.name')</td>
                                                            <td>
                                                                {{ $company->name }}
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>@lang('companies/ViewProfile/form.service_id')</td>
                                                            <td>
                                                                {{ $company->service_id }}
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>@lang('companies/ViewProfile/form.sceret_key')</td>
                                                            <td>
                                                                {{ $company->sceret_key }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/title.created_at')</td>
                                                            <td>
                                                                {!! $company->created_at->diffForHumans() !!}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div id="tab2" class="tab-pane fade">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-12 pd-top">--}}
                                {{--<form class="form-horizontal">--}}
                                    {{--<div class="form-body">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--<label for="inputpassword" class="col-md-3 control-label">--}}
                                                {{--Password--}}
                                                {{--<span class='require'>*</span>--}}
                                            {{--</label>--}}
                                            {{--<div class="col-md-9">--}}
                                                {{--<div class="input-group">--}}
                                                            {{--<span class="input-group-addon">--}}
                                                                {{--<i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>--}}
                                                            {{--</span>--}}
                                                    {{--<input type="password" id="password" placeholder="Password" name="password"--}}
                                                           {{--class="form-control"/>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="inputnumber" class="col-md-3 control-label">--}}
                                                {{--Confirm Password--}}
                                                {{--<span class='require'>*</span>--}}
                                            {{--</label>--}}
                                            {{--<div class="col-md-9">--}}
                                                {{--<div class="input-group">--}}
                                                            {{--<span class="input-group-addon">--}}
                                                                {{--<i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>--}}
                                                            {{--</span>--}}
                                                    {{--<input type="password" id="password-confirm" placeholder="Confirm Password" name="confirm_password"--}}
                                                           {{--class="form-control"/>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-actions">--}}
                                        {{--<div class="col-md-offset-3 col-md-9">--}}
                                            {{--<button type="submit" class="btn btn-primary" id="change-password">Submit--}}
                                            {{--</button>--}}
                                            {{--&nbsp;--}}
                                            {{--<input type="reset" class="btn btn-default" value="Reset"></div>--}}
                                    {{--</div>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- Bootstrap WYSIHTML5 -->
    <script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--$('#change-password').click(function (e) {--}}
                {{--e.preventDefault();--}}
                {{--var check = false;--}}
                {{--if ($('#password').val() ===""){--}}
                    {{--alert('Please Enter password');--}}
                {{--}--}}
                {{--else if  ($('#password').val() !== $('#password-confirm').val()) {--}}
                    {{--alert("confirm password should match with password");--}}
                {{--}--}}
                {{--else if  ($('#password').val() === $('#password-confirm').val()) {--}}
                    {{--check = true;--}}
                {{--}--}}

                {{--if(check == true){--}}
                {{--var sendData =  '_token=' + $("input[name='_token']").val() +'&password=' + $('#password').val() +'&id=' + {{ $company->id }};--}}
                    {{--var path = "passwordreset";--}}
                    {{--$.ajax({--}}
                        {{--url: path,--}}
                        {{--type: "post",--}}
                        {{--data: sendData,--}}
                        {{--headers: {--}}
                            {{--'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')--}}
                        {{--},--}}
                        {{--success: function (data) {--}}
                            {{--$('#password, #password-confirm').val('');--}}
                            {{--alert('password reset successful');--}}
                        {{--},--}}
                        {{--error: function (xhr, ajaxOptions, thrownError) {--}}
                            {{--alert('error in password reset');--}}
                        {{--}--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}

@stop
