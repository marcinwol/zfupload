<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $form = new My_Form_Files();
        $form->setAction($this->view->baseUrl('/index/index'));

        if ($this->getRequest()->isPost()) {
            if ($photosForm->isValid($_POST)) {
                // recive uploaded files
                
                if (!$form->files->receive()) {
                    throw new Zend_Form_Element_Exception('Reciving files');
                }
                
                return;
            }
        }
        $this->view->form = $form;
    }

    public function progressAction() {

        // check if a request is an AJAX request
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new Zend_Controller_Request_Exception('Not an AJAX request detected');
        }

        $uploadId = $this->getRequest()->getParam('id');

        // this is the function that actually reads the status of uploading
        $data = uploadprogress_get_info($uploadId);
        
        $bytesTotal = $bytesUploaded = 0;
        
        if (null !== $data) {
            $bytesTotal    = $data['bytes_total'];
            $bytesUploaded = $data['bytes_uploaded'];
        }        
        
        $adapter = new Zend_ProgressBar_Adapter_JsPull();
        $progressBar = new Zend_ProgressBar($adapter, 0, $bytesTotal, 'uploadProgress');

        if ($bytesTotal === $bytesUploaded) {
            $progressBar->finish();
        } else {
            $progressBar->update($bytesUploaded);
        }
    }
    
    public function successAction() {
        
    }

}

