<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('api',[\App\Http\Controllers\ApiDataController::class,'apiData']);
