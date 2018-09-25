<?php

namespace Core\Database
{
    use Core\Database\ORM\Medoo;

    class Database extends Medoo
    {

        public $database;

        public function __construct()
        {
            $this->database = new Medoo( CONNECTION );
        }

        public function db_error()
        {
            $data = $this->database->error();

            echo $this->database->last() . " ";

            foreach ($data as $key => $value)
            {
                    echo $value . " ";
            }
            echo "<br/>";
        }

        public function getName( $type, $string )
        {
            switch( $type )
            {
                case 'Method':
                    $positionValue = 2;
                break;
                
                case 'Param':
                    $positionValue = 1;
                break;
            }

            $stringCut = explode( '\\', $string );
            $lastPosition = count( $stringCut ) - $positionValue;

        return $stringCut[ $lastPosition ];
        }
    }
}
