@extends('admin.layouts.default')

{{-- Page title --}}
@section('title')
    {{ trans('Trade/title.title') }}
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/buttons.bootstrap.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/colReorder.bootstrap.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}"/>
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/rowReorder.bootstrap.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/buttons.bootstrap.css') }}">--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/scroller.bootstrap.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/tables.css') }}"/>
    <link href="{{ asset('assets/css/pages/transitions.css') }}" rel="stylesheet"/>
@stop

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <!--section starts-->
        <h1>@lang('Trade/LogQuery/title.title')</h1>

        <ol class="breadcrumb">

            <i class="livicon" data-name="table" data-size="14" data-loop="true"></i>
            <li class="active" >
                @lang('Trade/LogQuery/title.title')
            </li>

        </ol>
    </section>

    <section class="content paddingleft_right15">
        @if($switchPromission)
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="stopwatch" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    @lang('Trade/LogQuery/form.company_switch')
                </h3>
                <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
            </div>
            <div class="panel-body text-center">
                <!--content starts-->
                <div class="warp">
                    <p>
                        <select id="company_selection" name="company_selection" class="js--animations form-control" onchange="companyFilter(this.value);">
                            <optgroup label="@lang('Trade/LogQuery/form.company_please')">
                                    <option value="">@lang('Trade/LogQuery/form.allCompanies')</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" >{{ $company->company_name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </p>
                </div>
                <!--content ends-->
            </div>
        </div>
        @endif

        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('Trade/LogQuery/title.title')
                    </h4>
                </div>
                <br />
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered width100" id="table">
                            <thead>
                            <tr class="filters">
                                <th>{{ trans('Trade/LogQuery/form.pay_summary') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.trade_seq') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.company_name') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.amount') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.currency') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.payment_type') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.fee') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.apply_time') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.pay_start_time') }}</th>
                                <th>{{ trans('Trade/LogQuery/form.pay_end_time') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
    </section>
    <!-- content -->

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

    <script>
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{!! route('admin.authcode.data') !!}",
                "type": "post",
                "data": function ( d ) {
                    @if( $switchPromission )
                        if($('#company_selection').val() !== '')
                            d.company = $('#company_selection').val();
                    @endif
                }
            },
            columns: [
                { data: 'pay_summary', name: 'pay_summary' },
                { data: 'trade_seq', name: 'trade_seq' },
                { data: 'company_name', name: 'company_name' },
                { data: 'amount', name: 'amount' },
                { data: 'currency_name', name: 'currency_name' },
                { data: 'payment_name', name: 'payment_name' },
                { data: 'payment_fee', name: 'payment_fee'},
                { data: 'created_at', name: 'created_at'},
                { data: 'pay_start_time', name: 'pay_start_time'},
                { data: 'pay_end_time', name: 'pay_end_time'}
            ]
        });

        $(document).ready(function () {
            table.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            });
        });

        function companyFilter(){
            table.ajax.reload();
        }

    </script>

    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.buttons.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/buttons.html5.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/buttons.print.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/buttons.bootstrap.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/pdfmake.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/js/pages/table-advanced.js') }}"></script>--}}

    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.colReorder.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.rowReorder.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/jeditable/js/jquery.jeditable.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.responsive.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/buttons.colVis.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/buttons.print.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/vfs_fonts.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.scroller.js') }}"></script>--}}
@stop
