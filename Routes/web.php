<?php

Route::prefix('companyscalla')->group(function() {

	Route::get('', 'CompanyScallaController@index')->name('companyscalla.index');
	Route::post('', 'CompanyScallaController@file')->name('companyscalla.file');
});

