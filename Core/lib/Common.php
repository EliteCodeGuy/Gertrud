<?php
function paramSplit( $urlString )
{
    $conditionExist = substr_count( $urlString, '~');

        if( $conditionExist > 0 )
        {
            $arrayParamUrl = explode( '~', $urlString);
        }
        else
        {
            $arrayParamUrl = array( $urlString );
        }

return $arrayParamUrl;
}

function getConfigJsonArray()
{
    return json_decode( file_get_contents( 'App/Config.json' ), true );
}