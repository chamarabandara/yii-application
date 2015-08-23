<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class EditSubCategoryAction extends CAction {

   public function run() {
    
   
       if (SubCategory::model()->exists("name = :val", array(':val' => $_POST['sub_cat']))) {
                echo json_encode('exists');
              } else {
                   $sub_category = SubCategory::model()->findByPk($_POST['sub_id']);
                $sub_category->name = $_POST['sub_cat'];
                $sub_category->save();
                if($sub_category->save()){
                     echo json_encode('saved');
                }else{
                     echo json_encode('fail');
                }
               
              
            }
      
   }
}

?>
