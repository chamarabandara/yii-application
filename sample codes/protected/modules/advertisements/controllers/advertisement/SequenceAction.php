<?php

/**
 * AdvertisementList Action class file
 *
 * @author Chamara
 * @copyright Copyright&copy; 2014 PTC
 */
class SequenceAction extends CAction {

    public function run() {

        $controller = $this->getController();
        //create models for view
        $category = new Category();

        $catogaries = CHtml::listData(Category::model()->findAll(), 'id', // values
                        'name'    // captions
        );
        $coupon = Advertisement::model()->getAdvertisementSequence(FALSE);
        if (!empty($_GET) && !is_null($_GET)) {
            $catid = $_GET['id'];
            Advertisement::model()->unsetAttributes();
            $coupon = Advertisement::model()->getAdvertisementSequence($catid);
        }
        //save data to array according to post order
        if (isset($_POST['save']) && !is_null($_POST['save'])) {
            if (isset($_POST['thedata']) && !is_null($_POST['thedata'])) {
                $ranking = explode("&", $_POST['thedata']);
                $orderedArray = array();
                foreach ($ranking as $key => $values) {
                    $val = explode("ranking[]=", $values);
                    $orderedArray[$key] = $val[1];
                }
            }
            //update sequence in addvertisement
            if (!is_null($orderedArray)) {
                foreach ($orderedArray as $key => $value) {
                    $key =$key + 1; 
                    $model = Advertisement::model()->findByPk($value);
                    //get lat, long 
                    $modelLocation = LocationAdvertisement::model()->with('location')->findByAttributes(array('advertisement_id' => $value));
                    if ($modelLocation) {
                        if ($model->sequence = $key) {
                            $model->lat = $modelLocation->location->latitude;
                            $model->long = $modelLocation->location->longitude;
                            $model->sequence = $key;
                            $model->updated_date = date('Y-m-d H:i:s');
                            if ($model->save()) {
                                
                            } else {
                                Yii::app()->user->setFlash('error', 'Sequence Update Error');
                            }
                        } else {
                            continue;
                        }
                    }
                }
                Advertisement::model()->unsetAttributes();
                $coupon = Advertisement::model()->getAdvertisementSequence($_GET['id']);
                Yii::app()->user->setFlash('success', 'Sequence Updated successfully');
            }
        }

        $params = array(
            'category' => $catogaries,
            'categoryList' => $coupon,
        );
        $controller->render('sequence', $params);
    }

}
