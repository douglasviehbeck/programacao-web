<?php

Route::group(['prefix' => '/projetos'], function () {
    Route::get('', 'ProjetoController@index');
    Route::get('/{projeto}', 'ProjetoController@mostrar');
    Route::post('/salvar', 'ProjetoController@salvar');
    Route::post('/deletar/{projeto}', 'ProjetoController@deletar');
});
