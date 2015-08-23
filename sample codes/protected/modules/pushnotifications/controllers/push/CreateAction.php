<?php

/* Peachtree 
 * Push Notification Create action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class CreateAction extends CAction {

    public function run() {

        $controller = $this->getController();
        $push = new PushNotification();
        $countries = Country::model()->getCountries();
        $merchant = Vendor::model()->findAll('status =:status', array(':status' => '1'));
        $offer = Advertisement::model()->findAll('1 != 1');
        $cities = City::model()->findAll();

        if (isset($_POST['Save'])) {
           // print_r($_POST);exit;
            $push->attributes = $_POST['PushNotification'];
            $push->is_offer_title = $_POST['PushNotification']['is_offer_title'];
           // $push->is_logo = $_POST['PushNotification']['is_logo'];
            
            if ($push->is_male == 1 && $push->is_female == 1) {
                $gender = "Both";
            } else if ($push->is_female == 1) {
                $gender = "Female";
            } else if ($push->is_male == 1) {
                $gender = "Male";
            } else {
                $gender = "Both";
            }
            $isFavourite = $_POST['PushNotification']['is_favourite'];
            $cities = City::model()->findAll('country_id = :country_id AND enabled = \'1\'', array(':country_id' => $push->country));
            $advertisement = Advertisement::model()->findAll('vendor_id = :vendor_id AND status = \'Active\'', array(':vendor_id' => $push->merchant));
            $offer = array();
            foreach ($advertisement as $key => $coup) {
                $offer[] = array('id' => $coup->id, 'offer_title' => $coup->id . ' | ' . $coup->offer_title);
            }

            // code to set UTC delivery time
            if (!empty($push->start_date) && !empty($push->start_time)) {
                $usertimeoffset = 0;

                if (isset($_POST['timezoneoffset']))
                    $usertimeoffset = $_POST['timezoneoffset']; // 5.5

                /*
                 * If offset is positive, make it negative
                 * else if it is negative, make it positive
                 * to get the UTC date time in the following date() function.
                 */
                $usertimeoffset = $usertimeoffset * -1;
                $push->utcDeliveryTime = date('m/d/Y H:i', strtotime($push->start_date . ' ' . $push->start_time) +
                        ($usertimeoffset * 3600));
            }
           
            $push->start_date  = $_POST['PushNotification']['start_date'];
            $vendor_id = $_POST['PushNotification']['merchant'];
            $vendors = Vendor::model()->findByPk($vendor_id);

            if ($push->validate()) {
                try {

                    $UTCtime = $push->utcDeliveryTime;

                    if ($push->is_logo == 1 && isset($vendors->thumb_url)) {
                        $merchant_logo = Yii::app()->params['hostname'] . $vendors->thumb_url;
                    } else {
                        $merchant_logo = Yii::app()->params['hostname'] . Yii::app()->params['defaultMerchantLogo'];
                    }

                    $jsonData = array("userID" => Yii::app()->params['push_notification_user'], "key" => Yii::app()->params['push_key'], "approve" => "YES");
                    $json_url = Yii::app()->params['createPushMessage']; // url is defined in main config.
                    $pushMessage = array();
                    $pushMessage['message'] = trim($push->message);

                    $pushMessage['keyValue'] = array(
                        'advertisement' => $push->offer,
                        'merchant_logo_url' => $merchant_logo,
                    );
                    $jsonData['pushMessage'] = $pushMessage;
                    $jsonData['deliveryTime'] = $UTCtime;
                    $jsonData['merchantID'] = Yii::app()->user->getState('loggedUserId');
                    $jsonData['merchantRole'] = UserRole::model()->findByPk(Yii::app()->user->getState('roleId'))->role;
                    $jsonData['devices'] = $push->mobile_type; //
                    $jsonData['tags'] = array("tag1" => "a tag 1", "tag2" => "a tag 2", "tag3" => "a tag 3");

                    $ecardList_gender = array();
                    $ecardList_favourite = array();

                    switch ($push->method) {
                        case 1:
                            $jsonData['filterType'] = 'NONE';
                            break;
                        case 2:
                            $jsonData['filterType'] = 'ECARD';
                            $jsonData['filters'] = explode(",", $push->ecard);
                            break;
                        case 3:

                            $jsonData['filterType'] = 'PLACE';
                            $jsonData['filters'] = array('country' => $push->getCountry($push->country), 'city' => $push->getCity($push->city));

                            if (isset($gender) && $gender != "Both") {
                                $ecardList_gender = $this->getEcardListByGender($gender);
                            }

                            if (isset($isFavourite) && $isFavourite != 0) {

                                $ecardList_favourite = array_unique($this->getEcardListByFavourite($push));
                            }
                            //----------
                            if (!empty($ecardList_favourite) && !empty($ecardList_gender)) {
                                $jsonData['filters']['ecards'] = array_intersect($ecardList_favourite, $ecardList_gender);
                            } else if (!empty($ecardList_favourite)) {
                                $jsonData['filters']['ecards'] = $ecardList_favourite;
                            } else if (!empty($ecardList_gender)) {
                                $jsonData['filters']['ecards'] = $ecardList_gender;
                            } else {
                                $jsonData['filters']['ecards'] = array();
                            }
                            //----------
                            break;
                        //commented by chamara ditence vise
                        case 4:

                            $jsonData['filterType'] = 'DISTANCE';
                            $jsonData['filters'] = array('longitude' => $push->long, 'latitude' => $push->lat, 'distance' => $push->distance);

                            if (isset($gender) && $gender != "Both") {
                                $ecardList_gender = $this->getEcardListByGender($gender);
                            }

                            if (isset($isFavourite) && $isFavourite == 1) {
                                $ecardList_favourite = array_unique($this->getEcardListByFavourite($push));
                            }
                            //----------
                            if (!empty($ecardList_favourite) && !empty($ecardList_gender)) {
                                $jsonData['filters']['ecards'] = array_intersect($ecardList_favourite, $ecardList_gender);
                            } else if (!empty($ecardList_favourite)) {
                                $jsonData['filters']['ecards'] = $ecardList_favourite;
                            } else if (!empty($ecardList_gender)) {
                                $jsonData['filters']['ecards'] = $ecardList_gender;
                            } else {
                                $jsonData['filters']['ecards'] = array();
                            }
                            //----------
                            break;

                        default:
                            break;
                    }

                    $json_string = json_encode($jsonData);

                    $ch = curl_init($json_url);

                    $options = array(
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                        CURLOPT_POSTFIELDS => $json_string
                    );
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                    set_time_limit(0);
                    curl_setopt_array($ch, $options);
                    $response = curl_exec($ch);

                    curl_close($ch);

                    Yii::app()->user->setFlash('success', 'Push Notification Configured Successfully.');
                    $push = new PushNotification();
                    $countries = Country::model()->getCountries();
                    $cities = City::model()->findAll();

                    $merchant = Vendor::model()->findAll('status =:status', array(':status' => '1'));
                    $offer = Advertisement::model()->findAll('1 != 1');
                    $params = array(
                        'push' => $push,
                        'countries' => $countries,
                        'cities' => $cities,
                        'merchant' => $merchant,
                        'offer' => $offer,
                    );
                    $controller->render('create', $params);

                    return;
                } catch (Exception $ex) {
                    Yii::app()->user->setFlash('error', 'Exception: ' . $ex->getMessage());
                }
            }
            
        }
        
        $params = array(
            'push' => $push,
            'countries' => $countries,
            'cities' => $cities,
            'merchant' => $merchant,
            'offer' => $offer,
        );

        $controller->render('create', $params);
    }

    public function getEcardListByGender($gender) {
        $subscribers = MobileSubscription::model()->findAll('gender=:gender AND ecard_id IS NOT NULL', array(':gender' => $gender));
        foreach ($subscribers as $sub) {
            $ecard[] = $sub->ecard_id;
        }
        return $ecard;
    }

    public function getEcardListByFavourite($push) {
        $ecard = array();
        $favUsers = Log::model()->findAll('advertisement_id=:advertisement_id and favorite=:favorite AND ecard_id IS NOT NULL', array(':advertisement_id' => $push->offer, ':favorite' => 1));

        if ($favUsers) {
            foreach ($favUsers as $fav) {
                $ecard[] = $fav->ecard_id;
            }
        }
        return $ecard;
    }

}