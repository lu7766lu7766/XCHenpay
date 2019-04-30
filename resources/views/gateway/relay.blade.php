@extends('gateway.default')

@section('header')
    <script src="{{ asset('gateway/alipayjsapi.js') }}"></script>
@stop

@section('content')
    <relay trade_seq="{{ Request::get('trade_seq') }}"></relay>
@stop
