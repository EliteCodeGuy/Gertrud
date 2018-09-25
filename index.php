<?php

chdir( __DIR__ );

require 'Core/lib/Autoload.php';

$http = new Core\Http\Server();

if( !empty( $_POST ) )
{
    $http->Request( 'POST' );
}
else
{
    $http->Request( 'GET' );
}

$http->Response();
