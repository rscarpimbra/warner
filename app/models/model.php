<?php

namespace app\models;

use app\models\dbConnection;
use app\traits\Read;
use app\traits\Create;

class model{

    use Read, Create;
    
    protected $connect;

    public function __construct()
    {
        $this->connect = dbConnection::GetConnection();
    }
}
