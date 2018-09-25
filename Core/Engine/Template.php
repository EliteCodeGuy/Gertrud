<?php

 namespace Core\Engine
{
    class Template
    {
        public $templateDir;
        public $templateURL;
        public $arrayDataToPrint;

        public function __construct( $templateName )
        {
            $this->setTemplateDir( $templateName );
            $this->setTemplateURL( $templateName );
            
                $this->getHeader();
        }

        private function setTemplateDir( $templateName )
        {
            $this->templateDir = 'Templates' . DIRECTORY_SEPARATOR . $templateName . DIRECTORY_SEPARATOR;   
        }

        private function setTemplateURL( $templateName )
        {
            $this->templateURL = SERVER_NAME . '/Templates/' . $templateName;
        }

        public function getComponent( $componentName )
        {   
            if( is_array( $componentName ) )
            {
                foreach ( $componentName as $arrayKey => $arrayValue )
                {
                    if( is_int( $arrayKey ) )
                    {
                        $componentDir = $this->templateDir . $arrayValue.'.php';
                    }
                    else
                    {
                        $this->arrayDataToPrint = json_encode( $arrayValue );
                        $componentDir = $this->templateDir . $arrayKey.'.php';
                    }
                    
                    require $componentDir;
                }
            }
            else
            {
                require $this->templateDir . $componentName.'.php';
            }
        }

        /* Powerful Sugar Syntax */
        
        public function getHeader()
        {
            $headerDir = $this->templateDir . 'Header.php';

            if( file_exists( $headerDir ) )
            {
                require $headerDir;
            }
        }

        public function getNavigation()
        {
            $navigationDir = $this->templateDir . 'Navigation.php';

            if( file_exists( $navigationDir ) )
            {
                require $navigationDir;
            }
        }

        public function getFooter()
        {
            $footerDir = $this->templateDir . 'Footer.php';

            if( @file_exists( $footerDir ) )
            {
                require $footerDir;
            }
        }

        public function viewDisplay( $arrayKey )
        {
            $arrayData = json_decode( $this->arrayDataToPrint, 1 );

            if( @array_key_exists( $arrayKey, $arrayData ) )
            {
                    echo $arrayData[ $arrayKey ];
            }
        }
    }
}
