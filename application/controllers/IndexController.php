<?php

class IndexController extends Zend_Controller_Action {

   

    /**
     * After submision of My_Form_Files, the output of this action 
     * (its view and layout) will go to the  progressFrame iframe defined
     * in index.phtml (this frame is needed for minitoring upload progress). This 
     * causes a lot of troubles as for example any exceptions or form validations
     * errors will be shown in the iframe rather than in the 'normal' window.
     * 
     * So this must be considered when doing AJAX file uploads.
     * 
     */
    public function indexAction() {
                
        $form = new My_Form_Files();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                
                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
                                
                
                if (!$form->files->receive()) {
                    throw new Zend_File_Transfer_Exception('Reciving files failed');
                }               
                
                $uploadedFilesPaths = $form->files->getFileName();
                
                if(empty($uploadedFilesPaths)) {
                     $this->view->message = "No files uploaded";
                     return $this->render('finish');
                }
                
                // single uploaded file will not be an array. So make it to array.
                if (!is_array($uploadedFilesPaths)) {                    
                    $uploadedFilesPaths = (array) $uploadedFilesPaths;
                }
                
                
                // because this is only a demo so immidiately remove the files
                foreach ($uploadedFilesPaths as $file) {
                    if (!unlink($file)) {
                        throw new Exception('Cannot remove file: ' . $file);
                    }                    
                }      
                 
                
                // everything went fine so go to success action  
                // this script is executed inside the iframe.
                echo '<script>window.top.location.href = "'.$this->view->baseUrl().'/index/success'.'";</script>';               
                exit;
                
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

