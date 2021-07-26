<?php


namespace App\Repositories\MailerLite;


use Illuminate\Database\Eloquent\Model;

class SubscriberRequestModel extends Model
{
    public $name = '';
    public $email = '';
    public $country = '';
    public $isNew = false;

    /**
     * SubscriberRequestModel constructor.
     * @param string|null $name
     * @param string|null $email
     * @param string|null $country
     * @param bool $isNew
     */
    public function __construct(string $name = NULL, string $email = NULL, string $country = NULL, bool $isNew = false)
    {
        $this->name = $name;
        $this->email = $email;
        $this->country = $country;
        $this->isNew = $isNew;
    }


    public function toArray()
    {
        if($this->isNew)
        {
            return [
              'name' => $this->name,
              'email' => $this->email,
              'fields' => [
                  'country' => $this->country,
                  'email' => $this->email,
                  'name' => $this->name,
              ]
            ];
        }
        else
        {
            if($this->name != NULL && $this->country != NULL){
                return [
                    'name' => $this->name,
                    'fields' => [
                        'country' => $this->country,
                        'name' => $this->name,
                    ]
                ];
            }
            else if($this->name != NULL)
            {
                return [
                    'name' => $this->name,
                    'fields' => [
                        'name' => $this->name,
                    ]
                ];
            }
            else if($this->country != NULL)
            {
                return [
                    'fields' => [
                        'country' => $this->country,
                    ]
                ];
            }
        }
    }


}
