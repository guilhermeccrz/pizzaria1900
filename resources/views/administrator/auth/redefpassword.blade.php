@extends('administrator.layout.login')

@section('content')
    {{ Form::open(array('url' => route('administrator.auth.doredefpassword'), 'class' => 'form-signin')) }}

        <h2 class="form-signin-heading"></h2>
        <div class="login-wrap">
            <div class="user-login-info">
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Senha', 'required' => true)) }}
                {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirmação de Senha', 'required' => true)) }}
                {{ Form::hidden('user_id', $user->id) }}
                {{ Form::hidden('remember_token', $token) }}
            </div>
            <label class="checkbox">
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Alterar</button>
            @foreach (['danger', 'warning', 'success', 'info'] as $key)
                @if(Session::has($key))
                    <div class="alert alert-{{ $key }}" style="margin-bottom: 0px;">{{ Session::get($key) }}</div>
                @endif
            @endforeach
        </div>

    {{ Form::close() }}




    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url({{ asset('adminbite/assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo">
                    <span class="db"><img src="{{ asset('adminbite//assets/images/logo-icon.png') }}" alt="logo" /></span>
                    <h5 class="font-medium m-b-20">Sign In to Admin</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        {{ Form::open(array('url' => route('administrator.auth.dologin'), 'method' => 'POST', 'class' => 'form-horizontal m-t-20')) }}

                        <div class="input-group mb-3">
                            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Senha', 'required' => true)) }}
                            {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirmação de Senha', 'required' => true)) }}
                            {{ Form::hidden('user_id', $user->id) }}
                            {{ Form::hidden('remember_token', $token) }}
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                            </div>
                            {{ Form::password('password', array('class' => 'form-control form-control-lg', 'placeholder' => 'Senha')) }}
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <a href="javascript:void(0)" id="to-recover" class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> Esqueceu a senha?</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                {{ Form::submit('Log In', array('class' => 'btn btn-block btn-lg btn-info')) }}
                            </div>
                        </div>

                        @if(isset($errors) && count($errors))
                            <div class="alert alert-danger">
                                @foreach($errors as $error)
                                    @foreach($error as $e)
                                        - {{ $e }}<br/>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div id="recoverform">
                <div class="logo">
                    <span class="db"><img src="{{ asset('adminbite/assets/images/logo-icon.png') }}" alt="logo" /></span>
                    <h5 class="font-medium m-b-20">Recover Password</h5>
                    <span>Enter your Email and instructions will be sent to you!</span>
                </div>
                <div class="row m-t-20">
                    <!-- Form -->
                {{ Form::open(array('url' => route('administrator.auth.resetpassword'), 'method' => 'POST', 'class' => 'col-12 form-ajax')) }}
                <!-- email -->
                    <div class="form-group row">
                        <div class="col-12">
                            {{ Form::text('email_reset', null, array('class' => 'form-control form-control-lg', 'placeholder' => 'E-mail')) }}
                        </div>
                    </div>
                    <!-- pwd -->
                    <div class="row m-t-20">
                        <div class="col-12">
                            {{ Form::submit('Redefinir', array('class' => 'btn btn-block btn-lg btn-danger')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop
