<?php

namespace App\Repositories\MailerLite;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeyVault extends Model
{
    public $token;
    public $user;

    private const TABLE_NAME = 'secrets';
    public $timestamps = false;
    public $primaryKey = 'id';
    protected $table = self::TABLE_NAME;
    protected $appends = array('user','token');
    protected $fillable = array('user','token');

    public static function CreateDB() : void {
        if(Schema::hasTable(self::TABLE_NAME)){
            return;
        }

        Schema::create(self::TABLE_NAME, function(Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('token', 100);
            $table->string('user',100);
        });

    }

    public static function RetrieveSecret($user, $key) : ?string {
        if(Cache::has($user)){
            return Cache::get($user);
        }else{
            self::CreateDB();
            $value = DB::table('secrets')->where('user', $user)->value('token');

            if($key != NULL){
                $value = $key;
                $vault = new KeyVault();
                $vault->user = $user;
                $vault->token = $key;
                $vault->save();
            }
            Cache::add($user, $value);
            return $value;
        }
    }

    public function getUserAttribute($value)
    {
        return $this->attributes['user'];
    }

    public function getTokenAttribute(){
        return $this->attributes['token'];
    }
}
