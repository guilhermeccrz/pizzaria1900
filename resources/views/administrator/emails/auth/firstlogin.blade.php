@extends('admin.emails.layout.default')

@section('content')
    <p>Olá, {{ $name }}.</p>
    <p>Você foi convidado para participar do CUPOMA</p>
    <p>Clique <a href="{{ $link }}">aqui</a> para definir sua senha.</p>
@stop