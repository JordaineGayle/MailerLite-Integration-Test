<?php

namespace App\Repositories\MailerLite;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeyVault extends Model
{
    private const TABLE_NAME = 'secrets';
    public $timestamps = false;
    public $primaryKey = 'id';
    protected $table = self::TABLE_NAME;
    protected $guarded = ['id'];

    public static function CreateDB() : void {
        if(Schema::hasTable(self::TABLE_NAME)){
            return;
        }

        Schema::create(self::TABLE_NAME, function(Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('user',100);
            $table->string('token', 100);
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
                $vault->token = $key;
                $vault->user = $user;
                $vault->save();
            }
            Cache::add($user, $value);
            return $value;
        }
    }
}
