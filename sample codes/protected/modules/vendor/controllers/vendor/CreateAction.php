<?php

/* Peachtree 
 * Vendor Create Controller Action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class CreateAction extends CAction {

    public function run() {

        $controller = $this->getController();
        if (isset($_POST['Cancel'])) {
            $controller->redirect(array('vendor/index'));
        }
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        if ($id == 0) {
            $vendors = new Vendor();
        } else {
            $vendors = Vendor::model()->findByPk($id);
            $vendors->vendorName = $vendors->first_name . ' ' . $vendors->last_name;
        }
        if (isset($_POST['Save'])) {
            $vendors->attributes = $_POST['Vendor'];
            $vendors->created_date = date('Y-m-d');
            $vendors->created_by = Yii::app()->user->getState('loggedUserId');

            if ($vendors->save()) {
                if ($id == 0) {
                    Yii::app()->user->setFlash('success', 'Vendor created successfully');
                    $vendors = new Vendor();
                } else {
                    Yii::app()->user->setFlash('success', 'Vendor updated successfully');
                }
            }
        }
        if (isset($_POST['Delete'])) {
            $vendors->attributes = $_POST['Vendor'];

            $Criteria = new CDbCriteria();
            $Criteria->condition = "vendor_id = :id";
            $Criteria->params = array(':id' => $vendors->id);
            $coup_exists = Advertisement::model()->findAll($Criteria);
            if (count($coup_exists) > 0) {
                Yii::app()->user->setFlash('success', 'Can\'t delete. Advertisement Exist for this Vendor');
            } else {
                $vendors->delete();
                Yii::app()->user->setFlash('success', 'Vendor deleted successfully');
                $controller->redirect('index');
            }
        }

        $statusList = array(array('id' => 'Active', 'name' => 'Active'), array('id' => 'Inactive', 'name' => 'Inactive'));

        $params = array(
            'model' => $vendors,
            'statusList' => $statusList
        );

        $controller->render('create', $params);
    }

}