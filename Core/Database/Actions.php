<?php

namespace Core\Database
{
    class Actions extends Database
    {
        public function __contruct()
        {
            parent::__contruct();
        }
        
        public function extractData( $input )
        {
            if( is_array( $input ) )
            {
                $table  = $input[ 'table_name' ];
                $column = $input[ 'column_name' ];
                $where  = $input[ 'where_condition' ];

                $result = $this->database->select($table, $column, $where);

            }
            else
            {
                $result = "Se debe ingresar un Array, para poder realizar la operación";
            }

        return $result;
        }

        public function insertData( $cleanInputArray )
        {
            $result = $this->database->insert( $cleanInputArray['table_name'], $cleanInputArray['data']  );
        }
    }
}