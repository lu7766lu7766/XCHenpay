@extends('gateway.default')

@section('content')
    <alipay trade_seq="{{ Request::get('trade_seq') }}"></alipay>
@stop
