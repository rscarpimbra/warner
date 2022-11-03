<?php

namespace app\helpers;

class Procedures {




    /**
     *  Name        : PSEtLoggedUserData.
     *  Objective   : Set's the $_SESSION with the User Logged data.
     *  Params      : @pUserData = User Table Data..
     *  
     */
    public static function PSetLoggedUserData($pUserData){

        $_SESSION['usu_is_logged']      = true;
        $_SESSION['usu_id']             = $pUserData->usu_id;
        $_SESSION['usu_name']           = $pUserData->usu_name;
        $_SESSION['usu_name_first']     = $pUserData->usu_name_first;
        $_SESSION['usu_name_last']      = $pUserData->usu_name_last;
        $_SESSION['usu_avatar']         = $pUserData->usu_vatar;
        $_SESSION['usu_gender']         = $pUserData->usu_gender;
    }    
}