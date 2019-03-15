<?php


Route::post('/', ['as' => 'login', 'uses' => 'LoginController@login']);

Route::get('/{any}', 'ApplicationController@app')->where('any', '.*');
