<?php

/* Peachtree 
 * User Controller
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class UserController extends Controller {

    public $layout;

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        if (Yii::app()->user->getState('roleId') != 1) {

            throw new CHttpException('401', "Not authorized");
        }
        if( Yii::app()->user->getState('roleId') == Yii::app()->params['system_user']){
               $arr =array('index', 'create', 'update');   // give all access to admin
          }else if(Yii::app()->user->getState('roleId') == Yii::app()->params['merchant_user']){
               $arr = array(''); 
          }
          else{
            $arr = array('');          //  no access to other user
          }
        return array(
            array('allow',
                'actions' => $arr,
                'users' => array('@')),
            array('deny', 'users' => array('*')),
        );
    }

    public function actions() {
        return array(
            'index' => 'users.controllers.user.IndexAction',
            'create' => 'users.controllers.user.CreateAction',
            'update' => 'users.controllers.user.UpdateAction',
        );
    }

}