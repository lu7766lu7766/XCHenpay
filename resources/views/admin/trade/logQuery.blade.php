@extends('admin.layouts.default')

@section('header_styles')
    {{--放置 css--}}
@stop

@section('breadcrumb')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-flex">
                <h4 class="page-title">订单查询</h4>
                <ol class="breadcrumb ml-auto">
                    <li class="breadcrumb-item active"><a href="{{ URL::to('admin/logQuery') }}">首页</a></li>
                    <li class="breadcrumb-item"><a>查询功能</a></li>
                    <li class="breadcrumb-item active">订单查询</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <order-search/>
@stop

@section('modal')
    {{--放置 modal--}}
@stop

@section('footer_scripts')
    {{--放置 js--}}
@stop
