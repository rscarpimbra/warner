<?php

namespace app\traits;

use app\helpers\Functions;

trait Read{

    private $SQL;
    private $BINDS;
    private $PREFIX;


    /* Returns the Table Prefix based on the Underline Character. */
    private function FReturnTablePrefix(){

        return $PREFIX = Functions::FCountCharacters($this->toTable, '_');
    }
 


    /* Function to Return all the Table Fields. */
    private function FReturnTableFields(){

        /* Getting the Table Prefix, Example: `u`.`usu_id` */
        $this->PREFIX = self::FReturnTablePrefix();

        /* Selecting the Table Columns, Example: `usu_id, ` */
        $this->SQL      = "SELECT DISTINCT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :pTableName";
        
        /* Setting the Variable to the Table Name. */
        $this->BINDS['pTableName'] = $this->toTable;

        /* Executing the Binding. */
        $toSelect       = $this->FExecBind();

        /* Fetching the Data.  */
        $toReturn       = $toSelect->fetchAll();

        /* Creating the Columns String */
        foreach ( $toReturn as $key => $value){

            /* Create a full select string. */
            switch ($value['DATA_TYPE']){

                case 'int':
                case 'varchar':
                case 'char':
                case 'longtext':
                case 'decimal':
                case 'smallint':

                    $toReturnSQL .= "`{$this->PREFIX}`.`{$value['COLUMN_NAME']}`, ";
                    break;
            }    
        }
   
        /* Returns a SQL String, with the Table Prefix, removing the last comma, Example: `u`.`usu_id`, `u`.`usu_name`  */
        return rtrim($toReturnSQL, ", ");
    }




    /**
     * Function to Return all Data from a specic Table from DataBase.
     * @Name        : FQueryAll
     * @Objective   : Return all Data from a specific Table.
     * @Params      :
     * 
     * 
     */
    public function FQueryAll($pTableName = null){

        /* By Default Uses $this->toTable but can be changed according with the @param $pTableName */
        $vTableName = ($pTableName === null) ? $this->toTable : $pTableName;

        $toSQL      = "SELECT * FROM {$vTableName}";

        /* Executing the SQL. */
        $toAll      = $this->connect->query($toSQL);

        $toAll->execute();

        return $toAll->fetchAll();
    }



    /* 
        Function to Return a Object SQL  

        @Name       : FQueryClauseWhere.
        @Objective  : Returns a Data Object with data from Database.
        @Params     :
            $pWhereClause   : Set's the where Clause Example: where u.usu_name = description
            $pFetchMode     : Set's the fetch Mode, Defaul is an Object = 2
            
    */
    public function FQueryClauseWhere($pWhereClause = [], $pFetchMode = 2, $pSelectAll = ''){

        /* Getting the Table Prefix, Example: `u`.`usu_id` */
        $this->PREFIX   = self::FReturnTablePrefix();

        /* Creating the begining of the SQL string, Example: "SELECT DISTINCT `u`.`usu_id`, `u`.`usu_name`, `u`.`usu_password` FROM `tb_users` `u` WHERE" */
        $toSQLReturn    = "SELECT DISTINCT " . self::FReturnTableFields() . " FROM `{$this->toTable}` `{$this->PREFIX}` WHERE ";

        /* Clean all the Existings BINDS  */
        unset($this->BINDS);

        /* Creating the Where Clauses.  */
        foreach($pWhereClause as $key => $value){

            $toSQLReturn        .= " `{$this->PREFIX}`.`{$key}` = :{$key} AND";

            $this->BINDS[$key]  = $value; 
        }


        /* Return a SQL String, Removing the last AND */
        $this->SQL = rtrim( $toSQLReturn, ' AND ');

        /* Executing the Query with all the Bind Values. */
        $toReturn = $this->FExecBind();

        /* Return the Data According with the Parameter $pFetchMode */
        switch($pFetchMode){

            /* Regular Fetching */
            case 0:

                return $toReturn->fetch();
                break;

            /* Fetching All Data */
            case 1:
                
                return $toReturn->fetchAll();
                break;

            /* Fetching an Object */
            case 2:
                
                return $toReturn->fetchObject();
                break;
        }
    }





    /* Bind all the Values to the SQL. */
    private function FExecBind(){
        
        $toSelect = $this->connect->prepare($this->SQL);
        
        $toSelect->execute($this->BINDS);

        return $toSelect;
    }
}