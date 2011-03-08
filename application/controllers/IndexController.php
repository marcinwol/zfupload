<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    /**
     * After submision of My_Form_Files, the output of this action 
     * (its view and layout) will go to the invisible progressFrame iframe defined
     * in index.php (this frame is needed for minitoring upload progress). This
     * means that any exceptions or errors thrown here wont be visible. So
     *  
     * 
     */
    public function indexAction() {
                
        $form = new My_Form_Files();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {

                if (!$form->files->receive()) {
                    throw new Zend_File_Transfer_Exception('Reciving files failed');
                }
                
                $uploadedFilesPaths = $form->files->getFileName();
                
                // because this is only a demo so immidiately remove the files
                foreach ($uploadedFilesPaths as $file) {
                    if (!unlink($file)) {
                        throw new Exception('Cannot remove file: ' . $file);
                    }                    
                }
                
                throw new Exception('Cannot remove file: ' . $file);
                
                // everything whent fine so go to success action
                $this->_redirect('index/success');
                
            }
        }
        $form->setAction($this->view->baseUrl('/index/index'));
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
            $bytesTotal = $data['bytes_total'];
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

