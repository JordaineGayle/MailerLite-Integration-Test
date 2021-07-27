<?php

use App\Repositories\MailerLite\KeyVault;
use App\Repositories\MailerLite\SubscriberRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribersController;


Route::get('/subscribers/subscriber/{id}',SubscribersController::class.'@subscriber');
Route::get('/subscribers/query/{query}',SubscribersController::class.'@query');
Route::post('/subscribers/unsubscribe',SubscribersController::class.'@unsubscribe');
Route::post('/subscribers/createSubscriber',SubscribersController::class.'@createSubscriber');
Route::post('/subscribers/updateSubscriber',SubscribersController::class.'@updateSubscriber');
Route::middleware('mailerauth')->resource('subscribers', SubscribersController::class);

Route::post('/user/auth',function(Request $request) {
    $post = json_decode($request->getContent());
    $user = $post->user;
    $token = $post->token;
    $result = SubscriberRepository::authenticate($user,$token);
    if($result == false){
        return response('Please provide a valid mailer lite key.',401);
    }

    $token = KeyVault::RetrieveSecret($user, $token);

    if($token == NULL || $token == ''){
        Cache::forget($user);
        return response('Unable to save credentials.', 417);
    }

    return $user;
});

