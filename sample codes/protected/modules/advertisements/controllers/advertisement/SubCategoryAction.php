<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class SubCategoryAction extends CAction {

   public function run() {
    
     if (SubCategory::model()->exists("name = :val", array(':val' => $_POST['sub_cat']))) {
                echo json_encode('exists');
              } else {
                $sub_category = new SubCategory();
                $sub_category->name = $_POST['sub_cat'];
                $sub_category->category_id = $_POST['cat_id'];
                if($sub_category->save()){
                     echo json_encode('saved');
                }else{
                     echo json_encode('fail');
                }
               
              
            }
      
   }
}

?>
