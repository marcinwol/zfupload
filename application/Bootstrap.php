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

    protected function _initUploadDirAndConstant() {

        $uploadPath = APPLICATION_PATH . '/uploads';

        if (!file_exists($uploadPath)) {
            if (!mkdir($uploadPath)) {
                throw new Exception('Cannot make the following directorry: ' . $uploadPath);
            }
        }

        // if $uploadPath was created than define a constant
        defined('UPLOAD_PATH') || define('UPLOAD_PATH', APPLICATION_PATH . '/uploads');
    }

}

