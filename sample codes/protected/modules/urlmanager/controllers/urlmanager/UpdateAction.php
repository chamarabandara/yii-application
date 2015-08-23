<?php

/* Peachtree 
 * URL Index action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class UpdateAction extends CAction {

    public function run() {
        $controller = $this->getController();
        if (isset($_POST['Cancel'])) {
            $controller->redirect(array('urlManager/index'));
        }

        $id = TK::get('id');
        if ($id !== null) {
            $model = Url::model()->findByPk($id);
        } else {
            throw new CHttpException(500, 'The requested Url does not exist.');
        }

        if (isset($_POST['Delete'])) {
            $model->status = 0; // status 0:deleted, 1:active, 2:inactive
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Url deleted successfully.');
                $controller->redirect(array('urlManager/create'));
            }
        }

        $data = TK::post('Url');
        $displaySave = true;
        $statusList = array(
            array('id' => '1', 'name' => 'Active'),
            array('id' => '2', 'name' => 'Inactive')
        );

        if ($data !== null) {
            $model->attributes = $data;

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Url Updated  Successfully.');
                $controller->redirect(array('urlManager/update/id/' . $id));
            }
        }

        $params = array(
            'model' => $model,
            'action' => 'update',
            'displaySave' => $displaySave,
            'statusList' => $statusList
        );

        $controller->render('form', $params);
    }

}
