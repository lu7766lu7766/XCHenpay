@extends('admin.layouts.default')

@section('breadcrumb')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-flex">
                <h4 class="page-title">信息管理</h4>
                <ol class="breadcrumb ml-auto">
                    <li class="breadcrumb-item"><a href="{{ URL::to('admin/logQuery') }}">首页</a></li>
                    <li class="breadcrumb-item"><a>信息通知</a></li>
                    <li class="breadcrumb-item active">信息管理</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <message-manage/>
@endsection
