<?php

Route::get('/projetos', 'ProjetosController@projetos');
Route::get('/projetos/dados/{projeto?}', 'ProjetosController@dados');
Route::post('/projetos/salvar', 'ProjetosController@salvar');
Route::post('/projetos/deletar/{projeto}', 'ProjetosController@deletar');