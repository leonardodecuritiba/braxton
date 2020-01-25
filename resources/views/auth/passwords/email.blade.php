@extends('auth.app')

@section('title', 'Esqueci a senha')
@section('page_content')
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"> @yield('title')</a>
            <small>{{ config('app.name', 'Gestão de Obras') }}</small>
        </div>
        <div class="card">
            <div class="body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="msg">
                        Entre com seu email. Enviaremos um email com seu registro e um link para atualizar sua senha.
                    </div>
                    <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="Email"
                                   value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">ENVIAR O LINK</button>

                    <div class="row m-t-20 m-b--5 align-center">
                        <a href="{{route('index')}}">Login!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
