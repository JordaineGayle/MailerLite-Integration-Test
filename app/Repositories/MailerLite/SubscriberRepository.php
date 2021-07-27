<?php


namespace App\Repositories\MailerLite;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class SubscriberRepository implements ISubscriberRepository
{
    private const INTERNAL_ERROR_CODE = -500;

    private const BASE_URL = 'https://api.mailerlite.com/api/v2/subscribers';

    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public static function authenticate(string $userId, string $apiKey = NULL): bool
    {
        $response = Http::withoutVerifying()
            ->withHeaders(['X-MailerLite-ApiKey' => $apiKey])
            ->get('https://api.mailerlite.com/api/v2/stats');

        return !($response->status() != 200);
    }

    public function get($id) : SubscriberResponse
    {
        $response = Http::withoutVerifying()
            ->withHeaders(['X-MailerLite-ApiKey' => $this->apiKey])
            ->get(SubscriberRepository::BASE_URL.'/'.$id);
        return $this->handleResponse($response);
    }

    public function query(string $query): SubscriberResponse
    {
        $response = Http::withoutVerifying()
            ->withHeaders(['X-MailerLite-ApiKey' => $this->apiKey])
            ->get(self::BASE_URL.'/search?query='.$query);

        return $this->handleResponse($response);
    }

    public function getAll(): SubscriberResponse
    {
        $response = Http::withoutVerifying()
            ->withHeaders(['X-MailerLite-ApiKey' => $this->apiKey])
            ->get(SubscriberRepository::BASE_URL);
        return $this->handleResponse($response);
    }

    public function delete(Subscriber $subscriber): SubscriberResponse
    {
        $response = Http::withoutVerifying()
            ->withHeaders(['X-MailerLite-ApiKey' => $this->apiKey])
            ->put(SubscriberRepository::BASE_URL.'/'.$subscriber->id,['type' => $subscriber->type]);

        return $this->handleResponse($response);
    }

    public function create(SubscriberRequestModel $rq): SubscriberResponse
    {
        $exist = self::get($rq->email);

        if($exist->responseCode == 200){
            return new SubscriberResponse(NULL,NULL,"Already subscribed", 417);
        }

        $response = Http::withoutVerifying()
            ->withHeaders(['X-MailerLite-ApiKey' => $this->apiKey])
            ->post(SubscriberRepository::BASE_URL,$rq->toArray());

        return $this->handleResponse($response);
    }

    public function update(SubscriberRequestModel $rq): SubscriberResponse
    {
        $response = Http::withoutVerifying()
            ->withHeaders(['X-MailerLite-ApiKey' => $this->apiKey])
            ->put(SubscriberRepository::BASE_URL.'/'.$rq->email,$rq->toArray());

        return $this->handleResponse($response);
    }

    public function handleResponse(Response $response): SubscriberResponse
    {
        if(!$response->successful()){
            return new SubscriberResponse(NULL,NULL,json_decode($response->body())->error->message, $response->status());
        }

        $result = $response->json();
        $subscriber = NULL;
        $sub = NULL;

        try{
            $subscriber = new Subscriber($result);
        }catch (\Exception $e){}

        try{
            foreach ($result as $res){
                $sub[] = new Subscriber($res);
            }
        }catch (\Exception $e){}

        return new SubscriberResponse($subscriber,new Collection($sub));
    }

    public function paginator(Request $request, Collection $collection, int $itemsPerPage = 10): LengthAwarePaginator
    {
        $items = $collection->toArray();
        $currentPage = $request->input('page',1);
        $offset = ($currentPage * $itemsPerPage) - $itemsPerPage;
        $pagination = new LengthAwarePaginator(array_slice($items, $offset, $itemsPerPage, true),
            count($items), $itemsPerPage, $currentPage, ['path' => $request->url(), 'query' => $request->query()]);
        return $pagination;
    }
}
