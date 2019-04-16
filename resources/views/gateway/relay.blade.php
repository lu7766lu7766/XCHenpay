@extends('gateway.default')

@section('title', '在线支付 - 网上支付 安全快速！')

@section('header')
    <link rel="stylesheet" href="{{ asset('gateway/we_chat_pay/front-old.css') }}">
    <script src="{{ asset('gateway/alipayjsapi.js') }}"></script>
@stop

@section('content')
    <relay trade_seq="{{ Request::get('trade_seq') }}"></relay>
@stop
