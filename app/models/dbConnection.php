<?php

namespace app\models;

use PDO;
use Dotenv\Dotenv;

class dbConnection {
    
    public static function GetConnection() {

        $pdo = null;

        try{
            
            /* Getting the .env File. */
            $env = (new Dotenv(__DIR__ . '/../../'))->load();
            
            /* Populating Variables.  */
            $DB_HOST    = $_ENV['DB_HOST'];
            $DB_PORT    = $_ENV['DB_PORT'];
            $DB_NAME    = $_ENV['DB_NAME'];
            $DB_USER    = $_ENV["DB_USER"];
            $DB_PASS    = $_ENV["DB_PASS"];

            $pdo = new PDO("mysql:host=" . $DB_HOST . ";port=" . $DB_PORT . ";dbname=" . $DB_NAME . ";", "" . $DB_USER . "", "" . $DB_PASS . "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
           

        }catch (\PDOException $e){
            dump($e);
        }
    }
}