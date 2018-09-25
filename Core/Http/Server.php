<?php

namespace Core\Http
{
    require 'Core/Config/Constants.php';
    require 'Core/lib/Common.php';

    Class Server Extends URL
    {
        protected $appDir;
        protected $viewDir;
        protected $controllerDir;
        protected $viewMethodDir;
        protected $formData;
        protected $httpMethod;

        protected $urlControllerName;
        protected $urlMethodName;
        protected $urlParam;

        protected $responseControllerDir;
        protected $responseMethodName;

        use serverRequest, serverResponse;

        public function __construct()
        {
            $this->defaultServerConfig = getConfigJsonArray();
            
            $this->appDir = 'App'. SLASH . $this->defaultServerConfig['App-Name'] . SLASH;
            
            $this->viewDir = $this->appDir . 'Views' . SLASH;  
            
            $this->controllerDir = $this->appDir . 'Controllers' . SLASH;
        }

        public function Request( $httpMethod )
        {
            $this->httpMethod = $httpMethod;

            $get = @$_GET[ 'url' ];

            $urlActual = $this->urlArrayFormat( $get );

            $this->urlControllerName = $urlActual[ 'Controller' ];
            $this->urlMethodName = $urlActual[ 'Method' ];
            $this->urlParam = $urlActual[ 'View' ];

          if( $httpMethod == 'POST' )
          {
              $this->formData  = $this->postFilter( @$_POST['data'] );
          }
        }

        public function Response()
        {
            $responseName = 'response' . $this->urlParamFormat( $this->httpMethod ) . 'Request';

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