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
                return;
            }
        } 

        $this->view->form = $form;
    
    }

    public function progressAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $id = $this->getRequest()->getParam('id');
        $out = json_encode(uploadprogress_get_info($id));
        echo $out;
    }

}

