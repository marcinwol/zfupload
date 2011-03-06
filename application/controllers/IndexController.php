<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $id = $this->getRequest()->getParam('id', null);
        // 4d7361ecd28f7
        if (null !== $id) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $data = uploadprogress_get_info($id);
            
            $out = json_encode(array($id,$data));
            echo $out;
            return;
        }

        $form = new My_Form_Files();        

        $form->setAction($this->view->baseUrl('/index/index'));

        if ($this->getRequest()->isPost()) {
            if ($photosForm->isValid($_POST)) {
                return;
            }
        } else {
            // make unique id for the upload
            $uuid = uniqid();
            $form->getElement('UPLOAD_IDENTIFIER')->setValue($uuid);
        }


        $this->view->form = $form;
        $this->view->uuid = $uuid;
    }

    public function progressAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();


        $id = $this->getRequest()->getParam('id');
        $out = json_encode(uploadprogress_get_info($id));
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        echo $out;
    }

}

