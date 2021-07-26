<?php


namespace App\Repositories\MailerLite;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{

    public $id;
    public $email;
    public $country;
    public $name;
    public $type;
    public $date_subscribed;
    public $time_subscribed;

    protected $dateFormat = 'd/m/y';

    /**
     * Subscriber constructor.
     * @param $rawData
     */
    public function __construct($data)
    {
        if(isset($data['fields'])){
            foreach ($data['fields'] as $field){
                if($field['key'] == 'country'){
                    $this->country = $field['value'];
                    break;
                }
            }
        }

        $this->id = $data['id']??'';
        $this->email = $data['email']??'';
        $this->name = $data['name']??'';
        $this->type = $data['type']??'';
        $this->date_subscribed = date('d/m/Y',strtotime($data['date_subscribe']??$data['date_created']??''));
        $this->time_subscribed = date('G:i:s',strtotime($data['date_subscribe']??$data['date_created']??''));
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'type' => $this->type,
            'country' => $this->country,
            'date_subscribed' => $this->date_subscribed,
            'time_subscribed' => $this->time_subscribed,
        ];
    }

}
