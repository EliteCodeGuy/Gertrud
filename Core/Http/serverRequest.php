<?php

namespace Core\Http
{
    trait serverRequest
    {
        protected function controllerErrorHandler( $nameOfRequestedController )
        {
            $controllerDir = $this->controllerDir . $nameOfRequestedController;

            if( !file_exists( $controllerDir ) )
            {
                $result = ( class_exists( $controllerDir ) ? $nameOfRequestedController : $this->defaultServerConfig['CONTROLLER_NAME'] );
            }
            else
            {
                $result = $this->defaultServerConfig['CONTROLLER_NAME'];
            }

        return $result;
        }

        protected function methodErrorHandler( $controllerObject, $nameOfRequestedMethod )
        {
            if( !method_exists( $controllerObject, $nameOfRequestedMethod ) )
            {  
                $result = $this->defaultServerConfig['METHOD_NAME'];
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
            $realDirView =  $realDir . $requestedViewName;

            if( !file_exists( $realDirView ) )
            {
                $result = class_exists( $realDirView ) ? $realDirView : $realDir . $this->defaultServerConfig['VIEW_NAME'];
            }
            else
            {
                $result = $realDir . $this->defaultServerConfig['VIEW_NAME'];
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
                
        protected function postfilter( $postData )
        {
            return $postData;
        }
    }
}