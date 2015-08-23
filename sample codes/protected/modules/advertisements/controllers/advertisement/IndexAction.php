<?php
/* Peachtree 
 * Advertisement Index action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class IndexAction extends CAction {

    public function run() {
        $controller = $this->getController();

        $model = new Advertisement('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Advertisement']))
            $model->attributes = $_GET['Advertisement'];

        $users = User::model()->findAll();
        $controller->render('index', array(
            'model' => $model,
            'users' => $users,
        ));
    }

}
