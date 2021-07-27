<?php

namespace App\Http\Middleware;

use App\Repositories\MailerLite\KeyVault;
use App\Repositories\MailerLite\SubscriberRepository;
use Closure;
use Illuminate\Http\Request;

class MailerLiteAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->header('user');
        $token = $request->header('token');

        $token = KeyVault::RetrieveSecret($user, $token);

        if($token == NULL || $token == ''){
            return response('Unauthorized.', 401);
        }

        $isAutehnticated = SubscriberRepository::authenticate($user, $token);

        if($isAutehnticated == true)
        {
            return $next($request);
        }else{
            return response('Unauthorized.', 401);
        }


    }
}
