<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * DForm for uploading files.
 *
 * @author marcin
 */
class My_Form_Files extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('target',  'progressFrame');
        $this->setAttrib('onsubmit', 'beginUpload();');
        
        
        $files = new Zend_Form_Element_File('photo');        
        $files->setLabel('Upload files: ');
        $files->setDestination(APPLICATION_PATH . '/uploads');
        $files->setMultiFile(3);

        // files will be reveived manualy
      //  $files->setValueDisabled(true);

        $this->addElements(array($files));
        
        $this->addElement('submit', 'Submit');        
    }

    
}

?>
