<?php

Route::prefix('companyscalla')->group(function() {

	Route::get('', 'CompanyScallaController@index')->name('companyscalla.index');
	Route::post('', 'CompanyScallaController@file')->name('companyscalla.file');


	Route::get('report/products', 'ReportController@products')->name('companyscalla.report.products');
    Route::get('txt/orders/scalla', 'ExportController@txtOrders')->name('exports.txt.orders.scalla');

});

