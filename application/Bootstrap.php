<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

     protected function _initDoctype() {
        $view = $this->bootstrap('view')->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
    protected function _initAutoload() {

        $autoLoader = Zend_Loader_Autoloader::getInstance();

        $resourceLoader = new Zend_Loader_Autoloader_Resource(
                        array(
                            'basePath' => APPLICATION_PATH,
                            'namespace' => '',
                            'resourceTypes' => array(
                                'form' => array(
                                    'path' => 'forms/',
                                    'namespace' => 'My_Form_'
                                )
                            )
                        )
        );

        $autoLoader->pushAutoloader($resourceLoader);
    }

}

