<?php

spl_autoload_register(
    function($className)
    {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $className) . ".php";

            if( is_file( $file ) )
            {
                require $file;
            }
    }
);
