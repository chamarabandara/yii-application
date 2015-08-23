<?php

/* Peachtree 
 * URL Delete action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class DeleteAction extends CAction {

    public function run() {
        $id = TK::get('id');

        if ($id === null)
            throw new CHttpException(500, 'The requested Url does not exist.');

        $model = Url::model()->findByPk($id);
        $model->status = 0; // status 0:deleted, 1:active, 2:inactive
       
        if ($model->save()) {
            Yii::app()->user->setFlash('success', 'Url successfully deleted.');
        } else {
            Yii::app()->user->setFlash('error', $model->getLastError());
        }
        $this->getController()->redirect(array('urlManager/create'));
    }

}

