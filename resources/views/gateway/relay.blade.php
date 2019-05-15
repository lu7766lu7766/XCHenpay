@extends('gateway.default')

@section('header')
    <script src="{{ asset('gateway/alipayjsapi.js') }}"></script>
@stop

@section('content')
    <relay/>
@stop
