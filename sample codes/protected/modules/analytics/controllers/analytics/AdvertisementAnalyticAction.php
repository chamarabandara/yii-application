<?php

/**
 * LoginAction class file
 *
 * @author Gayan
 * @copyright Copyright&copy; 2011 SoNET Systems
 */

/**
 * Used to hanle login functinality
 *
 * @package am.admin.Dashboard
 */
class AdvertisementAnalyticAction extends CAction {

   public function run() {
   //echo date('Y-m-d', 1350300955);
      $controller = $this->getController();
      $analytic = new Analytic();
      $couponId = (!empty($_GET['id'])&& isset($_GET['id']))?$_GET['id']:0;
     // print_r($couponId);exit;  
	  //$analytic->startDate = date('Y-m-d');
      $params = array(
          'analytic'=>$analytic,
      );
	  
      $controller->render('addanalytics', $params);
   }
}
