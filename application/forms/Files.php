<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Form for uploading files.
 *
 * @author marcin
 */
class My_Form_Files extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        
        // set form attributes
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('target',  'progressFrame');                
        $this->setAttrib('id', 'files-upload-form');       
        
        // create multiple file element
        $files = new Zend_Form_Element_File('files');                      
        $files->setDestination(UPLOAD_PATH);     
        $files->setMultiFile(3);
        
        // set this flag for manual reception of uploaded files
        $files->setValueDisabled(true);
        
        $this->addElements(array($files));       

        // add submit button        
        $this->addElement('submit', 'Upload');        
    }

    
}

?>
