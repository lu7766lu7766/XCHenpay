@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('Trade/title.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/jtable/themes/metro/blue/jtable.css') }}"/>
    <link href="{{ asset('assets/css/pages/jtablemetroblue_jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/jtable.css') }}" rel="stylesheet" type="text/css" />

@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>@lang('Trade/title.title')</h1>
        <ol class="breadcrumb">
            <li>
                <i class="livicon" data-name="balance" data-size="14" data-loop="true"></i>
                @lang('Trade/title.title')
            </li>
            <li class="active">@lang('Trade/lendManage/title.title')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <!-- Basic charts strats here-->
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="livicon" data-name="barchart" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            @lang('Trade/lendManage/title.title')
                        </h4>
                        <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span>
                    </div>
                    <br />
                    <div class="panel-body">
                        <div class="filtering">

                            <form class="form-inline" >
                                <div class="form-group">
                                    <label for="fname">@lang('Trade/lendManage/form.trade_service_id'):</label>
                                    <input type="text" name="service_id" id="service_id" placeholder=@lang('Trade/lendManage/form.trade_service_id') class="form-control"/>
                                </div>

                                <button type="submit" class="btn btn-primary" id="LoadRecordsButton">@lang('Trade/lendManage/form.filter')</button>
                                <button type="button" class="btn btn-danger" id="reset-search">@lang('Trade/lendManage/form.reset')</button>
                            </form>
                            <br>
                        </div>

                        <!-- Container for jTable -->
                        <div id="StudentTableContainer">
                        </div>
                        <!-- An area to show selected rows (for demonstration) -->
                        <br>
                        <button id="LendAllButton" class="btn btn-primary">@lang('Trade/lendManage/form.acceptAll')</button>
                        {{--Selected rows (refreshed on <b>selectionChanged</b> event):--}}
                        {{--<div id="SelectedRowList">--}}
                        {{--No row selected! Select rows to see here...--}}
                        {{--</div>--}}

                    </div>
                </div>
            </div>

        </div>

    </section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jtable/js/jquery.jtable.js') }}"></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            //Prepare jtable plugin
            $('#StudentTableContainer').jtable({
                title: '订单列表',
                paging: true, //Enable paging
                pageSize: 10, //Set page size (default: 10)
                sorting: true, //Enable sorting
                defaultSorting: 'id ASC', //Set default sorting
                selecting: true, //Enable selecting
                multiselect: true, //Allow multiple selecting
                selectingCheckboxes: true,
                //selectOnRowClick: false, //Enable this to only select using checkboxes
                ajaxSettings: {
                    type: 'GET',
                    dataType: 'json'
                },
                actions: {
                    listAction:  "{{ url('admin/lendManage/data') }}",
                    manageAction: function (postData) {
                        // console.log("creating from custom lendAction...");
                        return $.Deferred(function ($dfd) {
                            $.ajax({
                                url: "{{ url('admin/lendManage') }}",
                                type: 'POST',
                                dataType: 'json',
                                data: postData,
                                success: function (data) {
                                    console.log('success');
                                    console.log(data);
                                    $dfd.resolve(data);
                                },
                                error: function (data) {
                                    console.log('error');
                                    console.log(data);
                                    $dfd.reject();
                                }
                            });
                        });
                    }
                },
                fields: {
                    id: {
                        key: true,
                        create: false,
                        edit: false,
                        list: false
                    },
                    pay_summary: {
                        title: '交易状态',{{--@lang('Trade/landApply/form.pay_summary')--}}
                        width: '20%',
                        inputClass: 'validate[required], form-control'
                    },
                    trade_service_id: {
                        title: '交易服务编号',
                        width: '20%',
                        inputClass: 'validate[required], form-control'
                    },
                    item_code: {
                        title: '产品编号',
                        width: '20%',
                        inputClass: 'validate[required], form-control'
                    },
                    payment_type: {
                        title: '交易方式',
                        width: '15%',
                        inputClass: 'validate[required], form-control'
                    },
                    amount: {
                        title: '金额',
                        width: '10%',
                        inputClass: 'validate[required], form-control'
                    },
                    currency: {
                        title: '币别',
                        width: '20%',
                        inputClass: 'validate[required,custom[email]], form-control'
                    }

                }
            });

            //Load student list from server
            $('#StudentTableContainer').jtable('load');

            //Delete selected students
            $('#LendAllButton').on('click', function () {
                var $selectedRows = $('#StudentTableContainer').jtable('selectedRows');

                $('#StudentTableContainer').jtable('manageButtonClickedForRows', $selectedRows);
            });

            //Re-load records when user click 'load records' button.
            $('#LoadRecordsButton').on('click', function (e) {
                e.preventDefault();
                $('#StudentTableContainer').jtable('load', {
                    trade_service_id: $('#service_id').val()
                });
            });

            $('#reset-search').on('click', function (e) {
                $('#service_id').val('');
            });

            $('.jtable-left-area select').addClass('form-control');
            // $('button').addClass('btn btn-default');
            // $('#AddRecordDialogSaveButton, #EditDialogSaveButton').removeClass('btn-default').addClass('btn-primary');
            // $('#DeleteDialogButton').removeClass('btn-default').addClass('btn-danger');
            // $('#DeleteAllButton,#LoadRecordsButton').removeClass('btn-default');
        });

    </script>

@stop