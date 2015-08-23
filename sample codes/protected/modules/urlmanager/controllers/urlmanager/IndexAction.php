<?php

/* Peachtree 
 * URL Index action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class IndexAction extends CAction {

    public function run() {

        $controller = $this->getController();
        $model = new Url('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Url']))
            $model->attributes = $_GET['Url'];
        $users = User::model()->findAll();

        $controller->render('index', array(
            'model' => $model,
            'users' => $users,
        ));
    }

}
