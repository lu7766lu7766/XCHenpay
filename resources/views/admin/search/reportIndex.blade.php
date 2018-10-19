@extends('admin.layouts.default')

{{-- Page title --}}
@section('title')
    {{ trans('Search/title.title') }}
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/tables.css') }}"/>
    <link href="{{ asset('assets/css/pages/transitions.css') }}" rel="stylesheet"/>
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/report/style.css') }}"/>


@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>@lang('Search/title.title')</h1>

        <ol class="breadcrumb">
            <i class="livicon" data-name="search" data-size="14" data-loop="true"></i>
            <li class="active">
                @lang('Search/Report/title.title')
            </li>
        </ol>
    </section>
    <section class="content">
        <!--main content-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff"
                               data-hc="white"></i> @lang('Search/Report/title.title')
                        </h3>
                    </div>
                    <div class="panel-body">

                        @yield('reportRecord')

                    </div>
                    <!--ends-->
                </div>
            </div>
        </div>
        <!--main content ends-->
    </section>
    <!-- content -->

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.css"
          rel="stylesheet"
          type="text/css"/>
    <script src="{{ asset('assets/js/report.js') }}"></script>
@stop
