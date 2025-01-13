<?php

use Illuminate\Support\Facades\Route;
use App\Models\Text;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/showDB', function () {
    return dd(Text::get());
});
