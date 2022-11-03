<?php

namespace app\traits;

trait TableFields {


    private $SQL;

    public function FReturnTableFields (){

        $this->SQL = "field, field, field";

        return $this->SQL;
    }
}