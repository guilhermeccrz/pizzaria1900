@extends('administrator.layout.default')
@section('breadcrumb-title', 'Usuários')

@section('content')
    <div class="row">
        <div class="col-12">

            <table id="data-table" class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th style="width:150px"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($mainModel as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ ($row->active==1)?'Ativo':'Inativo' }}</td>
                            <td class="text-center">
                                <a class="btn btn-primary btn-xs" href="{{ route('administrator.user.edit', $row->id) }}">editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@stop
