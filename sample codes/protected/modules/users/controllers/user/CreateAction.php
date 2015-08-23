<?php

/* Peachtree 
 * User Create Action 
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class CreateAction extends CAction {

    public function run() {

        $controller = $this->getController();
        if (isset($_POST['Cancel'])) {
            $controller->redirect(array('index'));
        }
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $roles = new UserRole();
        $roles = UserRole::model()->findAll();
        if ($id == 0) {
            $users = new User();
        } else {
            $users = User::model()->findByPk($id);
            $users->password = '';
        }
        if (isset($_POST['Save'])) {
            $users->attributes = $_POST['User'];
            if ($id == 0) {
                $users->save();
            } else {
                if ($users->password == null && $users->confPassword == null) {
                    if ($_POST['username'] == $users->username) {
                        $users->save(true, array('name', 'email', 'role_id'));
                    } else {
                        $users->save(true, array('name', 'username', 'email', 'role_id'));
                    }
                } else {
                    $users->save();
                }
            }
            if (!$users->errors) {
                if ($id == 0) {
                    Yii::app()->user->setFlash('success', 'User created successfully');
                    $users = new User();
                } else {
                    Yii::app()->user->setFlash('success', 'User updated successfully');
                }
                $users->password = '';
                $users->confPassword = '';
            }
        }
        if (isset($_POST['Delete'])) {
            $users->attributes = $_POST['User'];

            $Criteria = new CDbCriteria();
            $Criteria->condition = "user_id = :id";
            $Criteria->params = array(':id' => $users->id);

            $users->delete();
            Yii::app()->user->setFlash('success', 'User deleted successfully');
            $controller->redirect('manageuser/index');
        }


        $params = array(
            'users' => $users,
            'roles' => $roles
        );

        $controller->render('create', $params);
    }

}