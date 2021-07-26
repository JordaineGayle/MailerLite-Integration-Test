<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribersController;
use App\Http\Middleware\MailerLiteAuthMiddleware;


Route::get('/subscribers/subscriber/{id}',SubscribersController::class.'@subscriber');
Route::get('/subscribers/query/{query}',SubscribersController::class.'@query');
Route::post('/subscribers/unsubscribe',SubscribersController::class.'@unsubscribe');
Route::post('/subscribers/createSubscriber',SubscribersController::class.'@createSubscriber');
Route::post('/subscribers/updateSubscriber',SubscribersController::class.'@updateSubscriber');
Route::middleware('mailerauth')->resource('subscribers', SubscribersController::class);

