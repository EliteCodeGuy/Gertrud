<?php

namespace Core\Http
{
    trait serverResponse
    {
        public function responseGetRequest()
        {

                $this->resolveResoponseObjectDirections();

                $responseController = new $this->responseControllerDir;
                $responseMethodName = $this->responseMethodName;

        $responseController->$responseMethodName( $this->viewDirSanitized() );
        }

        public function responsePostRequest()
        {
            $this->resolveResoponseObjectDirections();

                $responseController = new $this->responseControllerDir;

            if( !empty( $this->formData ) )
            {
                $this->formData['view'] = $this->viewDirSanitized();
                $responseController->Form( $this->formData ); 
            }
        }

        private function resolveResoponseObjectDirections()
        {
            $this->responseControllerDir = $this->controllerDir. $this->controllerErrorHandler( $this->urlControllerName );

            $responseController = new $this->responseControllerDir;

        $this->responseMethodName = $this->methodErrorHandler( $responseController, $this->urlMethodName );
        }

        private function viewDirSanitized()
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
        return $sanitizedParam;
        }
    }
}
