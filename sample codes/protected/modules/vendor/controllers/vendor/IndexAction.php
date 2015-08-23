<?php

/* Peachtree 
 * Vendor Index Controller Action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class IndexAction extends CAction {

    public function run() {
        $controller = $this->getController();

        $model = new Vendor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Vendor']))
            $model->attributes = $_GET['Vendor'];

        $users = User::model()->findAll();
        $controller->render('index', array(
            'model' => $model,
            'users' => $users,
        ));
    }

}
