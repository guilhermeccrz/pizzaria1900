@extends('administrator.emails.layout.default')

@section('content')
    <p>Olá, {{ $name }}.</p>
    <p>Clique <a href="{{ $link }}">aqui</a> para redefinir sua senha.</p>
@stop
