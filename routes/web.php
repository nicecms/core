<?php

Route::prefix(config('nice.route_prefix'))->name(config('nice.route_name'))->middleware(config('nice.dashboard_middleware'))->group(function () {

    Route::get("/item/create/{entity}", "Nice\\Core\\Controllers\\ItemController@create")->name("item.create");
    Route::post("/item/store/{entity}", "Nice\\Core\\Controllers\\ItemController@store")->name("item.store");
    Route::get("/item/edit/{entity}/{id}", "Nice\\Core\\Controllers\\ItemController@edit")->name("item.edit");
    Route::post("/item/update/{entity}/{id}", "Nice\\Core\\Controllers\\ItemController@update")->name("item.update");
    Route::get("/items/{entity}", "Nice\\Core\\Controllers\\ItemController@index")->name("item.index");
    Route::get("/item/destroy/{entity}/{id}", "Nice\\Core\\Controllers\\ItemController@destroy")->name("item.destroy");
    Route::post("/items/assign-positions", "Nice\\Core\\Controllers\\ItemController@assignPositions")->name("item.assign_positions");

});

