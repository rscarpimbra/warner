<?php

namespace app\helpers;


use DateTime;
use DatePeriod;
use DateInterval;

class Functions {

    private  $toSanitize = [];

    public static function FCountCharacters($pWord, $pCharacter){
        
        return substr($pWord, strripos($pWord, $pCharacter) +1, 1);
    }


    public static function FSanitizeData(...$indexes){
        
        /* Iterating throught all the Fields to be Sanitized. */
        foreach($indexes as $value){

            

            list($toValidade, $typeValidate) = explode(':', $value);
            
            dump($toValidade);
            dump($typeValidate);
         

                switch($typeValidate){

                    /* String Validation */
                    case 's':
                        dump($key);
                        $toSanitize[]= filter_var($toValidade, FILTER_SANITIZE_STRING);
                        break;
    
                }
            

        }
      
        return $toSanitize;
    }



    /**
     *  Name        : FAddDays
     *  Objective   : Add a number of Days and Return the new date.
     *  Params      : @pDaysToAdd = Number of Days to Add.
     *  
     */
    public static function FAddDays($pDaysToAdd){

        /* Today's Date. */
        $date   = new DateTime();

        /* Format String to Date Format */
        $vToday = $date->format('Y-m-d H:i:s');

        /* Adding the Number of Days to the Date. */
        $vToday = strtotime("+".$pDaysToAdd." days", strtotime($vToday));
        
        return  date("Y-m-d", $vToday);
    }


}