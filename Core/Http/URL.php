<?php

namespace Core\Http
{
    class URL
    {
        protected $appDir;
        protected $viewDir;
        protected $controllerDir;
        protected $viewMethodDir;
        protected $urlControllerName;
        protected $urlMethodName;
        protected $urlParam;

        protected function urlAppDirections( $urlArray )
        {
            $this->urlControllerName = $urlArray[ 'Controller' ];
            $this->urlMethodName = $urlArray[ 'Method' ];
            $this->urlParam = $urlArray[ 'View' ];
        }

        protected function urlArrayFormat( $url )
        { 
            $defaultUrlArray = array( 'Controller' => $this->defaultAppStructure[ 'CONTROLLER_DEFAULT_NAME' ], 
                                         'Method'  => $this->defaultAppStructure[ 'METHOD_DEFAULT_NAME' ], 
                                           'View'  => $this->defaultAppStructure[ 'VIEW_DEFAULT_NAME' ] );

            if(!empty($url))
            {
                $urlArray = $this->urlSplit( $url );

                $numberOfComponents = $this->countComponents( $urlArray );

                $structure = $this->urlStructure( $numberOfComponents );

                    foreach ($urlArray as $componentPosition => $componentName)
                    {
                        $defaultUrlArray[ $structure[ $componentPosition ] ] = $this->urlParamFormat( $componentName );
                    }
            }

        return $defaultUrlArray;
        }

        protected function urlParamFormat( $urlString )
        {
            $conditionExist = substr_count( $urlString, '~' );

            if($conditionExist == 1)
            {
                $urlParamFormat = $this->urlConditionFormat( $urlString );
            }
            else
            {
                $urlParamFormat = $this->urlSegmentFormat( $urlString );
            }
        return $urlParamFormat;
        }

        protected function urlConditionFormat( $urlString )
        {
            $firstPosition = 0;
            $secondPosition = 1;

            /* 
            *   Ejemplo de URL:
            *      + http://ares.x/admin/Edit/view-xxx-xx~ParamY
            *   
            *         split url in 2 parts 
            *         fist part: admin/Edit/view-xxx-xx
            *         second part: '~ParamY'
            */
                $urlViewParamArray = explode( '~', $urlString );

            /*          and save the string '~ParamY'              */

                $condition = '~' . $urlViewParamArray[ $secondPosition ];
            
            /*           join this 2 parts again
            *            admin/Edit/View~ParamY
            */

        return ucfirst( strtolower( $urlViewParamArray[ $firstPosition ] ) ) . $condition;
        }

        protected function urlSegmentFormat( $urlString )
        {
            $firstPosition = 0;
            
            $conditionExist = substr_count( $urlString, '-' );

            if($conditionExist == 1)
            {
                $urlViewParamArray = explode( '-', $urlString );
                $viewName = $urlViewParamArray[ $firstPosition ];
                $urlSegmentFormat = ucfirst( strtolower( $viewName ) );
            }
            else
            {
                $urlSegmentFormat = ucfirst( strtolower( $urlString ) );
            }
            
        return $urlSegmentFormat;
        }

        private function urlStructure( $numberOfComponents )
        {
            switch ( $numberOfComponents )
            {
                case 2:
                    /* 
                    *    Ejemplo de URL:
                    *       + http://ares.x/Blog/Entrada
                    *
                    *        array("Controller"=>"Site", "Method"=>"Blog", "View"=>"Entrada");
                    */
                        $structure = array('Method', 'View');
                break;
                
                case 3:
                    /* 
                    *    Ejemplo de URL:
                    *        + http://ares.x/admin/Edit/EntradaX
                    *
                    *        array("Controller"=>"admin", "Method"=>"Edit", "View"=>"EntradaX");
                    */
                        $structure = array('Controller', 'Method', 'View');
                break;
                
                default:
                    /* 
                    *    Ejemplo de URL:
                    *        + http://ares.x/Home
                    *
                    *        array("Controller"=>"Site", "Method"=>"Page", "View"=>"Home");
                    */
                        $structure = array( 'View' );
                break;
            }

        return $structure;
        }

        protected function urlSplit( $url )
        {
            $slashNumber = substr_count( $url, '/' );

            if( $slashNumber >= 1 )
            {
                $urlArray = explode( '/', $url );
            }
            else
            {
                $urlArray = array( $url );
            }

        return $urlArray;
        }

        private function countComponents( $urlArray )
        {
        return count( $urlArray );
        }

    }
}