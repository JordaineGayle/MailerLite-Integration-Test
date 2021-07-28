<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/home');
});

Route::get('dash', function () {
    return view('dashboard');
});

Route::get('new-subscriber', function () {
    return view('addsubscriber');
});
