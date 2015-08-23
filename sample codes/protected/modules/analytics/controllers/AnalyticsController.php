<?php

class AnalyticsController extends Controller
{
   public $layout;

   public function filters() {
      return array(
          'accessControl',
      );
   }

   public function accessRules() {
    if( Yii::app()->user->getState('roleId') == Yii::app()->params['system_user']){
               $arr =array('index', 'create','addanalytics','filterAnalytics');   // give all access to admin
          }else if(Yii::app()->user->getState('roleId') == Yii::app()->params['merchant_user']){
               $arr = array(''); 
          }
          else{
            $arr = array('');          //  no access to other user
          }
      return array(
          array('allow',
              'actions'=>$arr,
              'users'=>array('@')),
          array('deny', 'users'=>array('*')),
      );
   }

   public function actions() {
      return array(
          'index'=>'analytics.controllers.analytics.IndexAction',
          'addanalytics'=>'analytics.controllers.analytics.AdvertisementAnalyticAction',
          'filterAnalytics'=>'analytics.controllers.analytics.FilterAnalyticsAction',
          
      );
   }
}
