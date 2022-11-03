<?php

namespace app\models\site;

use Illuminate\Database\Eloquent\Model;

class userForgotPwMD extends Model {

    protected $table = "tb_users_recover_pw";


    /* Setting the Table Fields. */
    protected $fillable = [
        'usu_id',
        'rec_token',
        'rec_expires',
        'rec_expiration_date'
    ];


    /* Setting the Date Format to be showed. */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
     ];
}