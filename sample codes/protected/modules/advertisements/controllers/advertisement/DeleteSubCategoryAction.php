<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class DeleteSubCategoryAction extends CAction {

   public function run() {
    
 
             //delete sub category
            
            $Criteria = new CDbCriteria();
            $Criteria->condition = "sub_category_id = :id";
            $Criteria->params = array(':id' => $_POST['sub_id']);
            $coup_exists = CategoryHasSubCategory::model()->findAll($Criteria);
            if (count($coup_exists) > 0) {
                echo json_encode('exists');
            } else {
                SubCategory::model()->deleteByPk($_POST['sub_id']);
                echo json_encode('saved');
            }
       
      
   }
}

?>
