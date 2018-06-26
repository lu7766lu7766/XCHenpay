@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('users/ViewProfile/title.title')
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
        <h1>@lang('users/ViewProfile/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    @lang('general.dashboard')
                </a>
            </li>
            <li>
                <a href="#">@lang('users/title.title')</a>
            </li>
            <li class="active">@lang('users/ViewProfile/title.title')</li>
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
                            @lang('users/ViewProfile/title.title')</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            @lang('users/ViewProfile/title.contact_password')</a>
                    </li>
                    <li>
                        <a href="#tab3" data-toggle="tab">
                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            @lang('users/ViewProfile/title.change_password')</a>
                    </li>



                </ul>
                <div  class="tab-content mar-top">

                    <div id="tab1" class="tab-pane fade active in">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="col-md-16">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="users">

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.company_name')</td>
                                                            <td>
                                                                {{  $user->company_name }}
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.company_service_id')</td>
                                                            <td>
                                                                {{ $user->company_service_id }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.sceret_key')</td>
                                                            <td>
                                                                {{ $user->sceret_key }}
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

                    <div id="tab2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="col-md-16">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="users">

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.full_name')</td>
                                                            <td>
                                                                {{  $user->last_name . ' ' . $user->first_name }}
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.mobile')</td>
                                                            <td>
                                                                {{ $user->mobile }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.email')</td>
                                                            <td>
                                                                {{ $user->email }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>@lang('users/ViewProfile/form.address')</td>
                                                            <td>
                                                                {{ $user->address }}
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

                    <div id="tab3" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 pd-top">
                                <form class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            {{ csrf_field() }}
                                            <label for="inputpassword" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.newPassword')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="password" id="password" placeholder=@lang('users/ViewProfile/form.PasswordHolder') name="password"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputnumber" class="col-md-3 control-label">
                                                @lang('users/ViewProfile/form.confirmPassword')
                                                <span class='require'>*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="password" id="password-confirm" placeholder=@lang('users/ViewProfile/form.confirmPasswordHolder') name="confirm_password"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary" id="change-password">@lang('users/ViewProfile/form.submit')
                                            </button>
                                            &nbsp;
                                            <input type="reset" class="btn btn-default" value=@lang('users/ViewProfile/form.reset')></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- Bootstrap WYSIHTML5 -->
    <script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#change-password').click(function (e) {
                e.preventDefault();
                var check = false;
                if ($('#password').val() ===""){
                    alert('Please Enter password');
                }
                else if  ($('#password').val() !== $('#password-confirm').val()) {
                    alert("confirm password should match with password");
                }
                else if  ($('#password').val() === $('#password-confirm').val()) {
                    check = true;
                }

                if(check == true){
                var sendData =  '_token=' + $("input[name='_token']").val() +'&password=' + $('#password').val() +'&id=' + {{ $user->id }};
                    var path = "passwordreset";
                    $.ajax({
                        url: path,
                        type: "post",
                        data: sendData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        success: function (data) {
                            $('#password, #password-confirm').val('');
                            alert('password reset successful');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('error in password reset');
                        }
                    });
                }
            });
        });
    </script>

@stop
