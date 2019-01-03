@extends('admin.layouts.default')

@section('breadcrumb')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-flex">
                <h4 class="page-title">帐号管理</h4>
                <ol class="breadcrumb ml-auto">
                    <li class="breadcrumb-item"><a href="../../index.html">首页</a></li>
                    <li class="breadcrumb-item"><a>系统设置</a></li>
                    <li class="breadcrumb-item active">帐号管理</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <account-manage/>
@stop
