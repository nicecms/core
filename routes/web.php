<?php

$prefix = config('nice.route_prefix');
$name = config('nice.route_name');

Route::get("$prefix/item/create/{entity}", "Nice\\Core\\Controllers\\ItemController@create")->name("$name.item.create");
Route::post("$prefix/item/store", "Nice\\Core\\Controllers\\ItemController@store")->name("$name.item.store");
Route::get("$prefix/item/edit/{entity}/{id?}", "Nice\\Core\\Controllers\\ItemController@edit")->name("$name.item.edit");
Route::post("$prefix/item/update/{id}", "Nice\\Core\\Controllers\\ItemController@update")->name("$name.item.update");
Route::get("/items/{entity}", "Nice\\Core\\Controllers\\ItemController@index")->name("$name.item.index");
Route::get("$prefix/item/destroy/{id}", "Nice\\Core\\Controllers\\ItemController@destroy")->name("$name.item.destroy");
Route::post("$prefix/items/assign-positions", "Nice\\Core\\Controllers\\ItemController@assignPositions")->name("$name.item.assign_positions");
