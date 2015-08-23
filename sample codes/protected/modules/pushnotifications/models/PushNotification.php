<?php

class PushNotification extends CFormModel {

    public $mobile_type;
    public $message;
//   public $sound;
//   public $badge;
    public $gender;
    public $ecard;
    public $long;
    public $lat;
    public $distance;
    public $key;
    public $value;
    public $country;
    public $city;
    public $method;
    public $start_date;
    public $start_time;
    public $merchant;
    public $offer;
    public $is_offer_title;
    public $is_logo;
    public $hidden_logo;
    public $is_male;
    public $is_female;
    public $is_favourite;
    public $created_by;
    public $created_date;
    public $utcDeliveryTime; // Used to set delivery time in UTC
    public $start_time1;
    /**
     * @return array validation rules for model attributes.
     */

    public function rules() {
        // NOTE: you should only define rules for those attributes that will receive user inputs.


        return array(
            array('method,mobile_type, merchant, offer, message, start_date, start_time', 'required'),
            array('method', 'validateRequiredFields'),
            array('message', 'validateMessage'),
            array('start_date', 'checkStartDate', 'skipOnError' => true),
            array('long, lat', 'match', 'pattern' => '/^[-+]?[0-9]*\.?[0-9]+$/', 'message' => '{attribute} should be a valid number.'),
          //  array('distance', 'type', 'type' => 'float', 'message' => '{attribute} should be a valid number.'),
            array('mobile_type, message, ecard, long, lat, distance, country, city, method, is_male ,is_female', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'mobile_type' => 'Mobile Platform(s):',
            'message' => 'Message:',
            'sound' => 'Sound:',
            'merchant'=>'Merchant:',
            'offer'=>'Offer:',
            'badge' => 'Badge:',
            'ecard' => 'e-card Number:',
            'country' => 'Country:',
            'city' => 'City:',
            'method' => 'Sending Method:',
            'start_date' => 'Delivery Date:',
            'BatchID'=>'Batch ID',
            'start_time' => 'Delivery Time:',
            'long' => 'Longitude:',
            'lat' => 'Latitude:'
        );
    }

    /**
     * validate Check Required Fields
     * @return bool
     */
    public function validateRequiredFields($attr, $params) {
        $errors = false;
        switch ($this->method) {
            case 2:
                if (empty($this->ecard)) {
                    $this->addError('ecard', 'e-card: cannot be blank.');
                    $errors = true;
                }
                break;
            case 3:
                if (empty($this->country)) {
                    $this->addError('country', 'Country: cannot be blank.');
                    $errors = true;
                }
                if (empty($this->city)) {
                    $this->addError('city', 'City: cannot be blank.');
                    $errors = true;
                }
                break;
            case 4:
                if (empty($this->long)) {
                    $this->addError('long', 'Longitude: cannot be blank.');
                    $errors = true;
                }
                if (empty($this->lat)) {
                    $this->addError('lat', 'Latitude: cannot be blank.');
                    $errors = true;
                }
//                if (empty($this->distance)) {
//                    $this->addError('distance', 'Distance: cannot be blank.');
//                    $errors = true;
//                }
                break;

            default:
                break;
        }
        if ($errors) {
            return false;
        }
    }

    /**
     * check to see if the start date is past or equal to the current date
     */
     public function checkStartDate() {
        $serverTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $currentUTCtime = date('Y-m-d H:i');
        date_default_timezone_set($serverTimeZone);
          if ((strtotime($currentUTCtime) - strtotime($this->utcDeliveryTime)) > 0) {
            $this->addError('start_date', 'Delivery Date and time should be a future date and time.');
            $this->addError('start_time', ''); // to highlight start_time input field
            return false;
        }
    }
    public function validateMessage(){
        if($this->mobile_type == 1 || $this->mobile_type == 3){
            if(strlen($this->message) >= 200){
                 $this->addError('message', 'Maximum length should be 200.');
                 return false;
            }
        }
    }

    public function getCountry($id) {
        return Country::model()->findByPk($id)->name;
    }

    public function getCity($id) {
        return City::model()->findByPk($id)->name;
    }

    public static function getMobileType($id) {
        $type = null;
        switch ($id) {
            case 1:
                $type = 'iPhone';
                break;
            case 2:
                $type = 'Android';
                break;
            case 3:
                $type = 'Both';
                break;
            default :
                break;
        }
        return $type;
    }
    
    public static function getNotificationData($jsonData ,$json_url ){
       
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
        $batches = curl_exec($ch);
        curl_close($ch);
        return $batches;
    }

}