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


@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>@lang('Search/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="search" data-size="14" data-loop="true"></i>
                @lang('Search/title.title')
            </li>
            <li class="active">@lang('Search/ReportStat/title.title')</li>
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
                               data-hc="white"></i> @lang('Search/ReportStat/title.title')
                        </h3>
                    </div>
                    <div class="panel-body">

                        @yield('reportStatRecord')

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
    <script src="{{ asset('assets/js/reportStat.js') }}"></script>
@stop
