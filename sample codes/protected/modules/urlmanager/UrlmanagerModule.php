<?php

/* Peachtree 
 * URL Manager Module
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class UrlmanagerModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'urlmanager.models.*',
            'urlmanager.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }

}