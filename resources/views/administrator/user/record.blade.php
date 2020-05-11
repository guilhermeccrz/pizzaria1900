@extends('administrator.layout.default')
@section('breadcrumb-title', 'Editar Usuário')

@section('content')
    <div class="card border-0">
        <div class="row justify-content-center align-items-center">
            <div class="col col-sm-8 col-md-8 col-lg-8 col-xl-6">

                {{ Form::open(array(
                    'url' => (isset($mainModel))?route('administrator.user.update', $mainModel->id):route('administrator.user.store'),
                    'method' => (isset($mainModel))?'PUT':'POST',
                    'class'=>'form-ajax')
                ) }}

                <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('Nome') }}
                        {{ Form::text('name', isset($mainModel)?$mainModel->name:null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('E-mail') }}
                        {{ Form::text('email', isset($mainModel)?$mainModel->email:null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Status') }}
                        {{ Form::select('active', array('1' => 'Ativo', '0' => 'Inativo'), isset($mainModel)?$mainModel->active:null, array('class' => 'form-control')) }}
                    </div>

                    @if(!isset($mainModel))
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    {{ Form::label('Senha') }}
                                    {{ Form::password('password', array('class' => 'form-control')) }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    {{ Form::label('Confirmação de Senha') }}
                                    {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer text-right bg-white">
                    {{ Form::submit('Salvar', array('class' => 'btn btn-primary')) }}
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
@stop
