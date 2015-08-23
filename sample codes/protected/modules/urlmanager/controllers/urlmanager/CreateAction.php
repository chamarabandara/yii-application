<?php

/* Peachtree 
 * URL Create action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class CreateAction extends CAction {

    public function run() {
        $controller = $this->getController();
        if (isset($_POST['Cancel'])) {
            $controller->redirect(array('urlManager/index'));
        }
        
        $model = new Url();
        $data = TK::post('Url');
        $urlCount = Url::model()->count("status != 0"); // status 0:deleted, 1:active, 2:inactive
        $displaySave = $urlCount < Url::MAX_RECORDS ? true : false;

        if ($data !== null) {
            $model->attributes = $data;

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Url Saved  Successfully');
                $controller->redirect(array('urlManager/create'));
            }
        }

        $params = array(
            'model' => $model,
            'action' => 'create',
            'displaySave' => $displaySave
        );
        $controller->render('form', $params);
    }

}