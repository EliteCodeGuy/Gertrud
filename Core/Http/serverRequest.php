<?php

namespace Core\Http
{
    use Core\lib\Security;

    trait serverRequest
    {
        protected function controllerErrorHandler( $nameOfRequestedController )
        {
            $controllerDir = $this->controllerDir . $nameOfRequestedController;

            if( !file_exists( $controllerDir ) )
            {
                $result = ( class_exists( $controllerDir ) ? $nameOfRequestedController : $this->defaultAppStructure['CONTROLLER_DEFAULT_NAME'] );
            }
            else
            {
                $result = $this->defaultAppStructure['CONTROLLER_DEFAULT_NAME'];
            }

        return $result;
        }

        protected function methodErrorHandler( $controllerObject, $nameOfRequestedMethod )
        {
            if( !method_exists( $controllerObject, $nameOfRequestedMethod ) )
            {
                $result = $this->defaultAppStructure['METHOD_DEFAULT_NAME'];
            }
            else
            {
                $result = $nameOfRequestedMethod;
            }

        return $result;
        }

        protected function paramErrorHandler( $requestedViewName )
        {

            $realDir = $this->viewDir . $this->urlMethodName . SLASH;

            if( !is_dir($realDir) )
            {
                $realDir = $this->viewDir . $this->defaultAppStructure['METHOD_DEFAULT_NAME'] . SLASH;
            }

            $realDirView =  $realDir . $requestedViewName;

            if( !file_exists( $realDirView ) )
            {
                $result = class_exists( $realDirView ) ? $realDirView : $realDir . $this->defaultAppStructure['VIEW_DEFAULT_NAME'];
            }
            else
            {
                $result = $realDir . $this->defaultAppStructure['VIEW_DEFAULT_NAME'];
            }

        return $result;
        }

        protected function conditionExist( $paramString )
        {
            if( substr_count( $paramString, '~' ) > 0 )
            {
                $result = true;
            }
            else
            {
                $result = false;
            }

        return $result;
        }
                
        protected function postDataFilter( $postData )
        {
            $filter = new Security('UTF-8');

            $data = $postData['data'];

                foreach ($data as $key => $value) {
                    $sanitizedData[ $key ] = $filter->xss_clean( $value );
                }
            $postData['data'] = $sanitizedData;
        return $postData;
        }
    }
}