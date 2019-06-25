<?php

Route::group(['prefix' => '/projetos'], function () {
    Route::get('', 'ProjetoController@getProjetos');
    Route::get('/{projeto}', 'ProjetoController@getProjeto');
    Route::post('/salvar', 'ProjetoController@postProjeto');
    Route::post('/deletar/{projeto}', 'ProjetoController@deleteProjeto');

    Route::group(['prefix' => '{projeto}/usuarios'], function () {
        Route::get('', 'UsuarioProjetoController@getUsuariosProjetos');
        Route::get('/lookup', 'UsuarioProjetoController@getUsuariosProjetoLookup');
        Route::post('/salvar', 'UsuarioProjetoController@postUsuarioProjeto');
        Route::post('/deletar/{usuario}', 'UsuarioProjetoController@deleteUsuarioProjeto');
    });

    Route::group(['prefix' => '{projeto}/tarefas'], function () {
        Route::get('', 'TarefaController@getTarefas');
        Route::get('/dados', 'TarefaController@getDados');
        Route::get('/{tarefa}', 'TarefaController@getTarefa');
        Route::get('/{tarefa}/historico', 'TarefaController@getHistorico');
        Route::post('/salvar', 'TarefaController@postTarefa');
    });
});
