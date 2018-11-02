<?php

namespace Core\Http
{
    require 'Core/Config/Constants.php';
    require 'Core/lib/Common.php';

    Class Server Extends URL
    {
        protected $formData;
        protected $httpMethod;
        protected $defaultAppStructure;
        protected $responseControllerDir;
        protected $responseMethodName;

        use serverRequest, serverResponse;

        public function __construct()
        {
            $this->saveConfigServerDirections();
        }

        protected function saveConfigServerDirections()
        {
            $defaultServerConfig = getConfigJsonArray('defaultApp');
            $this->defaultAppStructure = getConfigJsonArray( 'defaultApp', 'AppStructure' );

            $this->appDir = 'App'. SLASH . $defaultServerConfig[ 'Name' ] . SLASH;
            $this->viewDir = $this->appDir . 'Views' . SLASH;  
            $this->controllerDir = $this->appDir . 'Controllers' . SLASH;
        }

        public function Request( $httpMethod )
        {
            $this->httpMethod = $httpMethod;

            $get = @$_GET[ 'url' ];

            $urlActual = $this->urlArrayFormat( $get );

            $this->urlAppDirections( $urlActual );

                if( $httpMethod == 'POST' )
                {
                    $this->formData  = $this->postDataFilter( @$_POST['package'] );
                }
        }

        public function Response()
        {
            $responseName = 'response' . $this->urlSegmentFormat( $this->httpMethod ) . 'Request';

            if( $this->httpMethod == 'POST' )
            {
                $this->$responseName( $this->formData );
            }
            else
            {
                $this->$responseName();
            }
        }
    }
}