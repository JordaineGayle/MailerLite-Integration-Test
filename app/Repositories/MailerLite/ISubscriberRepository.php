<?php


namespace App\Repositories\MailerLite;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ISubscriberRepository
{
    public static function authenticate(string $userId, string $apiKey = NULL) : bool;
    public function get($id) : SubscriberResponse;
    public function getAll() : SubscriberResponse;
    public function query(string $query) : SubscriberResponse;
    public function delete(Subscriber $subscriber) : SubscriberResponse;
    public function create(SubscriberRequestModel $rq) : SubscriberResponse;
    public function update(SubscriberRequestModel $rq) : SubscriberResponse;
    public function handleResponse(Response $response) : SubscriberResponse;
    public function paginator(Request $request, Collection $collection, int $itemsPerPage = 10);
}
