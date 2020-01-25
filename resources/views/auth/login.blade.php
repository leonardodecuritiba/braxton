@extends('auth.app')

@section('title', 'Login')
@section('page_content')

    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"> @yield('title')</a>
            <small>{{ config('app.name', 'Gestão de Obras') }}</small>
        </div>
        <div class="card">
            <div class="body">

                <form id="sign_in" class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="msg">Login</div>
                    <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme">
                            <input type="checkbox" name="remember"
                                   class="chk-col-pink {{ old('remember') ? 'filled-in' : '' }}">
                            <label for="rememberme">Relembrar</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-12 align-right">
                            <a href="{{ route('password.request') }}">Relembrar Senha</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection