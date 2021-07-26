<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MailerLiteAuthMiddleware;
use App\Repositories\MailerLite\KeyVault;
use App\Repositories\MailerLite\Subscriber;
use App\Repositories\MailerLite\SubscriberRequestModel;
use App\Repositories\MailerLite\SubscriberRepository;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{

    private $request;
    private $mlite;
    private $orderBy;
    private $itemsPerPage;
    private $sortOrder;

    /**
     * SubscribersController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $token = KeyVault::RetrieveSecret($request->header('user'),NULL);

        if($token != NULL){
            $this->mlite = new SubscriberRepository($token);
            $this->request = $request;
            $this->itemsPerPage = $request->input('ipp', 10);
            $this->sortOrder = $request->input('sortOrder', 'asc');
            $this->orderBy = $request->input('orderBy');
        }
    }

    public function index(){

        $items = $this->mlite->getAll()->collection;

        if($this->orderBy != NULL){

            $desc = true;

            if($this->sortOrder == 'asc'){
                $desc = false;
            }

            $items = $items->sortBy($this->orderBy,SORT_REGULAR, $desc);
        }

        return $this->mlite->paginator($this->request,$items,$this->itemsPerPage);
    }

    public function query($query){

        $items = $this->mlite->query($query)->collection;

        if($this->orderBy != NULL){

            $desc = true;

            if($this->sortOrder == 'asc'){
                $desc = false;
            }

            $items = $items->sortBy($this->orderBy,SORT_REGULAR, $desc);
        }

        return $this->mlite->paginator($this->request,$items,$this->itemsPerPage);
    }

    public function subscriber($id){

        $item = $this->mlite->get($id);

        if($item->subscriber == null){
            return response($item->responseMessage,$item->responseCode);
        }

        return $item->subscriber;
    }

    public function unsubscribe(){
        $item = new Subscriber($this->request->post());
        $res = $this->mlite->delete($item);
        if($res->subscriber == null){
            return response($res->responseMessage,$res->responseCode);
        }
        return $res->subscriber;
    }

    public function updateSubscriber(){
        $p = $this->request;
        $item = new SubscriberRequestModel($p->post('name',NULL),$p->post('email',NULL),$p->post('country',NULL));
        $res = $this->mlite->update($item);
        if($res->subscriber == null){
            return response($res->responseMessage,$res->responseCode);
        }
        return $res->subscriber;
    }

    public function createSubscriber(){
        $p = $this->request;
        $item = new SubscriberRequestModel($p->post('name',NULL),$p->post('email',NULL),$p->post('country',NULL),true);
        $res = $this->mlite->create($item);
        if($res->subscriber == null){
            return response($res->responseMessage,$res->responseCode);
        }
        return $res->subscriber;
    }
}
