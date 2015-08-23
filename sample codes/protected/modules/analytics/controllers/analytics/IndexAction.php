<?php
Yii::import('application.models.Category');
Yii::import('application.models.SubCategory');
Yii::import('application.modules.advertisements.models.Advertisement');
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
class IndexAction extends CAction {

   public function run() {
   //echo date('Y-m-d', 1350300955);
      $controller = $this->getController();
      $analytic = new Analytic();

      if(isset($_POST['Clear'])){
         unset ($_POST);
         Yii::app()->user->setState('searchFields','');
      }

	 // print_r($_POST);
	  
      if (isset($_POST['Analytic'])){
         
         $analytic->attributes = $_POST['Analytic'];
        
      }
	$myValue = '';  
	  //$analytic->startDate = date('Y-m-d');
      $params = array(
          'analytic'=>$analytic,
          'myValue'=>$myValue,
      );
	  
      $controller->render('index', $params);
   }
}
