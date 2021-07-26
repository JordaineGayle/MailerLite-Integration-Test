<?php

namespace App\Repositories\MailerLite;
use Illuminate\Database\Eloquent\Collection;

class SubscriberResponse
{
    public $subscriber;
    public $collection;
    public $responseMessage;
    public $responseCode;

    public function __construct(Subscriber $subscriber = NULL, Collection $collection = NULL, string $responseMessage = 'OK', int $responseCode = 200)
    {
        $this->subscriber = $subscriber;
        $this->collection = $collection;
        $this->responseMessage = $responseMessage;
        $this->responseCode = $responseCode;
    }
}
