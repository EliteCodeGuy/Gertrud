<?php

namespace Core\Http
{
    trait serverResponse
    {
        public function responseGetRequest()
        {
            $firstPosition  = 0;
            $secondPosition = 1;

                if( $this->conditionExist( $this->urlParam ) )
                {
                    $paramArray      = paramSplit( $this->urlParam );
                    $sanitizedParam  = $this->paramErrorHandler( $paramArray[ $firstPosition ] );
                    $sanitizedParam .= '~' . $paramArray[ $secondPosition ];
                }
                else
                {
                    $sanitizedParam = $this->paramErrorHandler( $this->urlParam );
                }

                $this->resolveResoponseObjectDirections();

                $responseController = new $this->responseControllerDir;

                $responseMethodName = $this->responseMethodName;

            $responseController->$responseMethodName( $sanitizedParam );
        }

        public function responsePostRequest()
        {
            $this->resolveResoponseObjectDirections();

                $responseController = new $this->responseControllerDir;

            if( !empty( $this->formData ) )
            { 
                $data = $this->formData;
                $data['url'] = $this->responseControllerDir . SLASH . $this->responseMethodName;
                $responseController->Form( $data ); 
            }
        }

        public function resolveResoponseObjectDirections()
        {
            $this->responseControllerDir = $this->controllerDir. $this->controllerErrorHandler( $this->urlControllerName );

            $responseController = new $this->responseControllerDir;

            $this->responseMethodName = $this->methodErrorHandler( $responseController, $this->urlMethodName );
        }
    }
}
