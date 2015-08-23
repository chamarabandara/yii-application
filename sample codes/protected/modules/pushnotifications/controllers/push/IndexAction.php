<?php

/* Peachtree 
 * Push Notification Index 
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class IndexAction extends CAction {

    public function run() {
        $controller = $this->getController();
        $jsonData = array("userID" => Yii::app()->params['push_notification_user'], "key" => Yii::app()->params['push_key']);
        $json_url = Yii::app()->params['getAllPushDetails']; // url is defined in main config.

        $push = new PushNotification();
        if (Yii::app()->user->checkAccess('super_admin', Yii::app()->user->getId())) {
            $jsonData['merchantID'] = Yii::app()->user->getState('loggedUserId');
            $jsonData['merchantRole'] = UserRole::model()->findByPk(Yii::app()->user->getState('roleId'))->role;
        }
        if (isset($_POST['yt1'])) {
            unset($_POST);
        }       

        if (isset($_POST['yt0'])) {
            $push->attributes = $_POST['PushNotification'];
            $push->created_date = $_POST['PushNotification']['created_date'];
            if (!empty($push->mobile_type)) {
                $jsonData['devices'] = $push->mobile_type;
            }
            if (!empty($push->created_date)) {
                $jsonData['startDate'] = date('m/d/Y', strtotime($push->created_date)) . ' 00:00'; //date('m/d/Y', strtotime($push->created_date));
                $jsonData['endDate'] = date('m/d/Y', strtotime($push->created_date)) . ' 23:59';
            }
        }
        $batches = PushNotification::getNotificationData($jsonData, $json_url);
        $params = array(
            'batches' => $batches,
            'push' => $push
        );
        $controller->render('index', $params);
    }

}

