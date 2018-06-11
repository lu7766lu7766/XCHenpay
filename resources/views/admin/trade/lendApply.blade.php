@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    JTable
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
        <h1>JTable </h1>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Datatables</li>
            <li class="active">JTable</li>
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
                            JTable
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
                                    <label for="fname">First Name:</label>
                                    <input type="text" name="name" id="fname" placeholder="First Name" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label for="lname">Last Name:</label>
                                    <input type="text" name="lname" id="lname" placeholder="Last Name" class="form-control"/>
                                </div>

                                <button type="submit" class="btn btn-primary" id="LoadRecordsButton">Filter</button>
                            </form>
                            <br>
                        </div>

                        <!-- Container for jTable -->
                        <div id="StudentTableContainer">
                        </div>
                        <!-- An area to show selected rows (for demonstration) -->
                        <br>
                        <button id="DeleteAllButton" class="btn btn-primary">Delete all selected records</button>
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
                title: 'Employee List',
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
                    listAction:  "{{ url('admin/lendApply/data') }}",
                    deleteAction: function (postData) {
                        return $.Deferred(function ($dfd) {
                            $.ajax({
                                url: "{{ url('admin/lendApply/delete') }}",
                                type: 'POST',
                                dataType: 'json',
                                data: postData,
                                success: function (data) {
                                    $dfd.resolve(data);
                                },
                                error: function () {
                                    $dfd.reject();
                                }
                            });
                        });
                    },
                    {{--updateAction: function (postData) {--}}
                        {{--return $.Deferred(function ($dfd) {--}}
                            {{--$.ajax({--}}
                                {{--url: "{{ url('admin/lendApply/update') }}",--}}
                                {{--type: 'POST',--}}
                                {{--dataType: 'json',--}}
                                {{--data: postData,--}}
                                {{--success: function (data) {--}}
                                    {{--console.log('success');--}}
                                    {{--$dfd.resolve(data);--}}
                                {{--},--}}
                                {{--error: function (data) {--}}
                                    {{--console.log('error');--}}
                                    {{--console.log(data);--}}
                                    {{--$dfd.reject();--}}
                                {{--}--}}
                            {{--});--}}
                        {{--});--}}
                    {{--},--}}
                    {{--createAction: function (postData) {--}}
                        {{--console.log("creating from custom function...");--}}
                        {{--return $.Deferred(function ($dfd) {--}}
                            {{--$.ajax({--}}
                                {{--url: "{{ url('admin/lendApply/store') }}",--}}
                                {{--type: 'POST',--}}
                                {{--dataType: 'json',--}}
                                {{--data: postData,--}}
                                {{--success: function (data) {--}}
                                    {{--console.log('success');--}}
                                    {{--$dfd.resolve(data);--}}
                                {{--},--}}
                                {{--error: function (data) {--}}
                                    {{--console.log('error');--}}
                                    {{--console.log(data);--}}
                                    {{--$dfd.reject();--}}
                                {{--}--}}
                            {{--});--}}
                        {{--});--}}
                    {{--}--}}
                    lendAction: function (postData) {
                        console.log("creating from custom function...");
                        return $.Deferred(function ($dfd) {
                            $.ajax({
                                url: "{{ url('admin/lendApply/store') }}",
                                type: 'POST',
                                dataType: 'json',
                                data: postData,
                                success: function (data) {
                                    console.log('success');
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
                    trade_service_id: {
                        title: '交易服务编号',
                        width: '23%',
                        inputClass: 'validate[required], form-control'
                    },
                    item_code: {
                        title: '产品编号',
                        width: '23%',
                        inputClass: 'validate[required], form-control'
                    },
                    payment_type: {
                        title: '交易方式',
                        width: '15%',
                        inputClass: 'validate[required], form-control'
                    },
                    amount: {
                        title: '金额',
                        width: '15%',
                        inputClass: 'validate[required], form-control'
                    },
                    currency: {
                        title: '币别',
                        width: '15%',
                        inputClass: 'validate[required,custom[email]], form-control'
                    }

                }
            });

            //Load student list from server
            $('#StudentTableContainer').jtable('load');

            //Delete selected students
            $('#DeleteAllButton').button().click(function () {
                var $selectedRows = $('#StudentTableContainer').jtable('selectedRows');

                $('#StudentTableContainer').jtable('deleteRows', $selectedRows);
            });

            //Re-load records when user click 'load records' button.
            $('#LoadRecordsButton').click(function (e) {
                e.preventDefault();
                $('#StudentTableContainer').jtable('load', {
                    firstname: $('#name').val(),
                    lastname: $('#lname').val()
                });
            });

            //Load all records when page is first shown
            $('#LoadRecordsButton').click();

            $('.jtable-left-area select').addClass('form-control');
            // $('button').addClass('btn btn-default');
            // $('#AddRecordDialogSaveButton, #EditDialogSaveButton').removeClass('btn-default').addClass('btn-primary');
            // $('#DeleteDialogButton').removeClass('btn-default').addClass('btn-danger');
            // $('#DeleteAllButton,#LoadRecordsButton').removeClass('btn-default');
        });

    </script>

@stop