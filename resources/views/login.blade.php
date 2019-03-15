<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/css/login.css">

        {{-- Materialize --}}
        <link rel="stylesheet" href="/css/materialize.min.css">
        <script src="/js/materialize.min.js"></script>

        <title>Login</title>
    </head>
    <body>
        <div class="login-wrapper">
            <div class="card">
                <div class="card-content">
                    <div style="text-align: center">
                        <img src="/img/system.png" height="150px" width="150px" />
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @if($errors->has('loginError'))
                            <div class="card-panel white-text red darken-1">Usuário e/ou senha inválido(s)</div>
                        @endif

                        {!! csrf_field() !!}
                        <div class="input-field">
                            <label for="username">Usuário</label>
                            <input id="username" name="username" type="text" {{ $errors->has('username') ? 'class=invalid' : '' }} />

                            @if($errors->has('username'))
                                <span class="helper-text" data-error="O usuário é obrigatório"></span>
                            @endif
                        </div>
                        <div class="input-field">
                            <label for="password">Senha</label>
                            <input id="password" name="password" type="password" {{ $errors->has('password') ? 'class=invalid' : '' }} />

                            @if($errors->has('password'))
                                <span class="helper-text" data-error="A senha é obrigatória"></span>
                            @endif
                        </div>

                        <button class="btn btn-primary waves-effect waves-light">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>