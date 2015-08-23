
<?php

/**
 * LoadCitiesAction class file
 *
 * @author Malith
 * @copyright Copyright&copy; 2012 Devterra
 */
class LoadCitiesAction extends CAction {

   public function run() {
      $countryId = TK::post('country_id');
      $cities = City::model()->findAll('country_id = :country_id AND enabled = \'1\'', array(':country_id'=>$countryId));
      $cityArray = array();
      foreach ($cities as $key=>$city) {
         $cityArray[] = array('id'=>$city->id, 'name'=>$city->name);
      }
      echo CJSON::encode($cityArray);
   }
}
