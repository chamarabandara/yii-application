<?php

/**
 * LoadCouponAction class file
 *
 * @author Azraar
 * @copyright Copyright&copy; 2012 Devterra
 */
class GetAdvertisementDescriptionAction extends CAction {

   public function run() {
      $advertisementId = TK::post('coupon_id');
      $advertisement = Advertisement::model()->findAll('id = :adver_id', array(':adver_id'=>$advertisementId));
      $couponArray = array();
      foreach ($advertisement as $key=> $advert) {
         $advertArray[] = array('id'=>$advert->id, 'name'=>$advert->offer_desc);
      }
      echo CJSON::encode($advertArray);
   }
}
