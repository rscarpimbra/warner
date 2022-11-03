<?php

namespace app\models\site;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class users extends Model {

    protected $table = "tb_users";


    /* Setting the Table Fields. */
    protected $fillable = [
        'uuid',
        'usu_name',
        'usu_password',
        'usu_name_first',
        'usu_name_last',
        'usu_date_birth',
        'usu_avatar',
        'usu_gender',
        'id_profession',
        'usu_email'
    ];

    /* Auto Saving the Uuid. */
    public static function boot()
    {
        parent::boot();

        static::creating(function($tbUsers){

            $tbUsers->uuid  = Uuid::uuid4();
        });
    }


    /* Setting the Date Format to be showed. */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
     ];
}