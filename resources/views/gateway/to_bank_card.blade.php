@extends('gateway.default')

@section('title', '在线支付 - 支付宝 - 网上支付 安全快速！')

@section('header')
    <link rel="stylesheet" href="{{ asset('gateway/alipay/front-old.css') }}">
@stop

@section('content')
    <to-bank-card trade_seq="{{ Request::get('trade_seq') }}"></to-bank-card>
@stop
