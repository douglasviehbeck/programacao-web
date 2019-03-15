<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Materialize --}}
        <link rel="stylesheet" href="/css/materialize.min.css">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <script src="/js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <title>App</title>
    </head>
    <body>
        <div id="app"></div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>