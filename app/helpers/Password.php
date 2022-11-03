<?php

namespace app\helpers;

class Password{

    /* Create the Password */
    public static function make($pPassword){
        $toOptions = [
            'const' => 14,
        ];

        return password_hash($pPassword, PASSWORD_BCRYPT, $toOptions);
    }

    /* Verify a Password. */
    public static function verify($pPassword, $hash){

        return password_verify($pPassword, $hash);
    }
}