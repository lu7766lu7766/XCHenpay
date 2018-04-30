@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('companies/AddCompany/title.title') }}
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    {{--<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">--}}
    {{--<link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('assets/vendors/iCheck/css/all.css') }}" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="{{ asset('assets/css/pages/wizard.css') }}" rel="stylesheet">--}}
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ trans('companies/AddCompany/title.title') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    {{ trans('general.dashboard') }}
                </a>
            </li>
            <li><a href="#"> {{ trans('companies/title.title') }}</a></li>
            <li class="active">{{ trans('companies/AddCompany/title.title') }}</li>
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
                            {{ trans('companies/AddCompany/title.title') }}
                        </h3>
                        <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                        </span>
                    </div>

                    <div class="panel-body">
                        <!--main content-->
                        <form id="commentForm" action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            {{--{{ csrf_field() }}--}}

                            <div class="form-group">
                                <label for="name"
                                       class="col-sm-2 control-label">{{ trans('companies/AddCompany/form.name') }} *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{!! old('name') !!}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="service_id"
                                       class="col-sm-2 control-label">{{ trans('companies/AddCompany/form.service_id') }} *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="service_id" name="service_id" value="{!! old('service_id') !!}" required>
                                </div>
                            </div>

                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">{{ trans('companies/AddCompany/form.submit') }}</button>
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
    {{--<script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>--}}
    {{--<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>--}}
    {{--<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>--}}
    {{--    <script src="{{ asset('assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}"--}}
    {{--type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"--}}
    {{--type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"--}}
    {{--type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/js/pages/adduser.js') }}"></script>--}}
    {{--<script>--}}
    {{--function formatState(state) {--}}
    {{--if (!state.id) {--}}
    {{--return state.text;--}}
    {{--}--}}
    {{--var $state = $(--}}
    {{--'<span><img src="{{ asset('assets/img/countries_flags') }}/' + state.element.value.toLowerCase() + '.png" class="img-flag" width="20px" height="20px" /> ' + state.text + '</span>'--}}
    {{--);--}}
    {{--return $state;--}}

    {{--}--}}

    {{--$("#countries").select2({--}}
    {{--templateResult: formatState,--}}
    {{--templateSelection: formatState,--}}
    {{--placeholder: "select a country",--}}
    {{--theme: "bootstrap"--}}
    {{--});--}}

    {{--</script>--}}
@stop
