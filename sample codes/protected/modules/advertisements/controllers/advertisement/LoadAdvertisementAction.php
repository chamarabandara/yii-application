<?php

/**
 * LoadCouponAction class file
 *
 * @author Azraar
 * @copyright Copyright&copy; 2014 Allion Technologies
 */
class LoadAdvertisementAction extends CAction {

   public function run() {
      $vendorId = TK::post('vendor_id');
      $coupon = Advertisement::model()->findAll('vendor_id = :vendor_id AND status = \'Active\'', array(':vendor_id'=>$vendorId));
      $couponArray = array();
      foreach ($coupon as $key=> $coup) {
         $couponArray[] = array('id'=>$coup->id, 'name'=>$coup->id.' | '.$coup->offer_title);
      }
      echo CJSON::encode($couponArray);
   }
}
