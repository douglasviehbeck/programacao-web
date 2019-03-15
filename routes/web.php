<?php

Route::get('/projetos', 'ProjetosController@projetos');
Route::get('/projetos/usuarios', 'ProjetosController@usuariosPossiveis');
Route::post('/projetos/salvar', 'ProjetosController@salvar');