<?php

/**
 * ReviewAction class file
 *
 * @author Saman Priyantha
 * @copyright Copyright&copy; 2011 Devtera
 */
class ReviewAction extends CAction {

   public function run() {
      $controller = $this->getController();
      $advertisement = new Advertisement();

      if (isset($_POST['ApproveSelected'])) {
         if (isset($_POST['Advertisement'])) {
            $advertisement->attributes = $_POST['Advertisement'];
            foreach ($advertisement->selection as $value) {
                Advertisement::model()->updateByPk($value, array('status'=>'Active'));
            }
            Yii::app()->user->setFlash('success', 'Coupon(s) approved successfully');
         } else {
            Yii::app()->user->setFlash('error', 'Please select at least one coupon to approve');
         }
      }

      if (isset($_POST['DeleteSelected'])) {
         $basePath = dirname(__FILE__);
         $basePath = substr($basePath, 0, strripos($basePath, 'protected') - 1);

         if (isset($_POST['Advertisement'])) {
            $advertisement->attributes = $_POST['Advertisement'];
            foreach ($advertisement->selection as $value) {
               $advertisement = Advertisement::model()->findByPk($value);
               //delete from location advertisement
               LocationAdvertisement::model()->deleteAll('advertisement_id =' .$value);
               Advertisement::model()->deleteByPk($value);
               if (!empty($advertisement->image_url) && file_exists($basePath.$advertisement->image_url))
                  unlink($basePath.$advertisement->image_url);
               if (!empty($advertisement->thumb_url) && file_exists($basePath.$advertisement->thumb_url))
                  unlink($basePath.$advertisement->thumb_url);
              
               if (!empty($advertisement->qr_code_image_name) && file_exists($basePath.$advertisement->qr_code_image_name))
                  unlink($basePath.$advertisement->qr_code_image_name);
            }
            Yii::app()->user->setFlash('success', 'Coupon(s) delete successfully');
         } else {
            Yii::app()->user->setFlash('error', 'Please select at least one coupon to delete');
         }
      }

      $params = array(
          'advertisement'=>$advertisement,
      );
      $controller->render('review', $params);
   }
}
