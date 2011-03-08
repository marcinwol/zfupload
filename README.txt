ABOUT
======

Example application demonstrating usage of Zend_ProgressBar and jquery.progressbar
for monitoring progress of file uploads in Zend Framework 1.11.3.


INSTALATION
===========

The application contains everything that it needs to run,  including full
Zend Framework 1.11.3. 

Since file uploads are done to the folder APPLICATION_PATH/uploads, the application
tries to create this folder if it does not exists. For this reason APPLICATION_PATH
should be writable, or uploads folder created manually with necessary rights.

The application also requires 'uploadprogress' PECL package (http://pecl.php.net/package/uploadprogress/)
since it uses 'uploadprogress_get_info' function for getting the information about
upload progress. 
