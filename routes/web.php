<?php

use App\Http\Controllers\EmpruntController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
