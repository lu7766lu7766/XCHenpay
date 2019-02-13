@extends('admin.layouts.default')

@section('breadcrumb')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-flex">
                <h4 class="page-title">公司帐户</h4>
                <ol class="breadcrumb ml-auto">
                    <li class="breadcrumb-item"><a href="{{ URL::to('admin/logQuery') }}">首页</a></li>
                    <li class="breadcrumb-item"><a>收款管理</a></li>
                    <li class="breadcrumb-item active">公司帐户</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <company-account/>
@stop
