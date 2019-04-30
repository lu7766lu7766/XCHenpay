@extends('gateway.default')

@section('content')
    <to-bank-card trade_seq="{{ Request::get('trade_seq') }}"></to-bank-card>
@stop
