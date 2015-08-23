<?php


class LoadSubCatsAction extends CAction {

   public function run() {
      
       $categoryId = TK::post('cat_id');
        $coupon_id = TK::post('coupon_id');
         $controller = $this->getController();
       
        if ($categoryId != NULL) {
            $subCategories = SubCategory::model()->findAll('category_id=:category_id', array(':category_id' => $categoryId));
            if (isset($coupon_id) && $coupon_id > 0) {
                $coupons = Advertisement::model()->findByPk($coupon_id);
            } else {
                $coupons = new Advertisement();
            }
            
            $noneAttr = SubCategory::model()->findByAttributes(array('category_id' => $categoryId,'name'=>'main sponser'));
            //print_r($noneAttr);exit;
            echo $controller->renderPartial('subcategory', array('subCategories' => $subCategories, 'coupons' => $coupons,'noneAttr'=>$noneAttr), true);
            }
   }
}
