<?php

use Illuminate\Support\Facades\Route;
use App\Repositories\MailerLite\SubscriberRepository;
use App\Models\KeyVault;

Route::get('/', function () {
    return view('/home');
});
