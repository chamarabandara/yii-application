<?php

//data: part of the json responses use following list of classes and structures.

class VendorObj {

    public $description;
    public $fb_url;
    public $phone;
    public $twitter_url;
    public $url;
    public $store_address;

}

class ConcourseObj {

    public $name;
    public $gates;

}

class AdvertisementObj {

    public $id;
    public $loc;
    public $offer_title;
    public $thumb_url;
    public $store_name;
    public $exp_date;

}

class TerminalMapDataObj {

    public $map_url;

}

class LocationDataObj {

    public $locations;

}

class RedeemAdvertisementDataObj {

    public $qr_code_img;
    public $qr_code;

}

class AdvertisementValidateDataObj {

    public $validity;

}

class AdvertisementInitDataObj {

    public $value;

}

class AdvertisementDetailDataObj {

    public $image_url;
    public $terms;
    public $vendor;

}

class AdvertisementListDataObj {

    public $advertisements;
    public $expired;

}

class CategoryObj {

    public $category_id;
    public $category_name;
    public $advertisements;

}

class SubCategoryObj {

    public $advertisements;
    public $sub_category_id;
    public $sub_category_name;

}

//each response is using following two objects by default to generate json response.

class ResponseObj {

    public $data = '';
    public $status = true;
    public $server_time;

}

class ErrorResponseObj {

    public $error = '';
    public $status = false;

}

class ErrorObj {

    public $code = '';
    public $message = '';

}

class OutPutObj {

    public $response;

}

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $renderFooter = false;

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->layout = 'blank';
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;
        $this->redirect(Yii::app()->params['hostname'] . '/admin/login');
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionInit() {

        $timecoder = new Timecoder();
        $timecoder->datecreated = date("Y-m-d");
        $timecoder->save();

        $token = $timecoder->getPrimaryKey();
        $advertisementD = new OutPutObj();
        $advertisementD->response = new ResponseObj();
        $AdvertisementInitDataObj = new CouponInitDataObj();
        //populate object hierarchy
        if ($token != null) {
            $AdvertisementInitDataObj->value = $token;
            $advertisementD->response->data = $AdvertisementInitDataObj;
            echo json_encode($advertisementD);
        } else {
            $advertisementD = new OutPutObj();
            $errorObj = new ErrorObj();
            $errorObj->code = 505;
            $errorObj->message = "Tocken is not available";
            $errorrespobj = new ErrorResponseObj();
            $errorrespobj->error = $errorObj;
            $advertisementD->response = $errorrespobj;
            echo json_encode($advertisementD);
        }
    }

    public function actionValidate() {
        $exception = 0;
        // renders the json output for the action
        //get the coupon id fro the request url

        /* Return true
         * $token = $_GET['token'];
         */
        //initialize basic response object set
        $advertisementD = new OutPutObj();
        $advertisementD->response = new ResponseObj();
        $CAdvertisementValidateDataObj = new CouponValidateDataObj();
        //populate object hierarchy

        $CAdvertisementValidateDataObj->validity = true;
        /* Return true

         * 
         */
        //output the json string in required format
        if ($exception == 0) {
            $advertisementD->response->data = $CAdvertisementValidateDataObj;
            //output the json string in required format
            echo json_encode($advertisementD);
        } else {
            $advertisementD = new OutPutObj();
            $errorObj = new ErrorObj();
            $errorObj->code = $exceptioncode;
            $errorObj->message = $exceptionmsg;
            $errorrespobj = new ErrorResponseObj();
            $errorrespobj->error = $errorObj;
            $advertisementD->response = $errorrespobj;
            echo json_encode($advertisementD);
        }
    }

    function checkNum($number) {

        if (is_numeric($number)) {
            return doubleval($number);
        } else {
            throw new Exception("Value must be a number");
        }
    }

    function is_date($str) {

        list($y, $m, $d) = explode('-', $str);
        if (checkdate($m, $d, $y)) {
            return strtotime($str);
        } else {
            throw new Exception("Value must be a valid date");
        }
    }

    /**
     * This is the GetCouponList action that is invoked
     * when request comes
     */
    public function actionGetAdvertisementList() {
        //renders the json output for the action
        //get the coupon id fro the request url
        $dateTime = date("Y-m-d H:i:s");
        $date = date("Y-m-d");
        $exception = 0;
        $exceptioncode = 101;
        $exceptionmsg = 'error';
        $_GET['longitude'] = 0;
        $_GET['latitude'] = 0;
        try {
            //validate locaion parameters
            $longitudeval = $this->checkNum($_GET['longitude']);
            $latitudeval = $this->checkNum($_GET['latitude']);
            $last_update_date = $_GET['lastupdate']; //         
            //initialize basic response object set
            $advertisementD = new OutPutObj();
            $advertisementD->response = new ResponseObj();
            $AdvertisementListDataObj = new AdvertisementListDataObj();
            //populate object hierarchy in advetisement
            $categories = Category::model()->findAll();

            $categoryarray = array();
            $arrexpired = array();
            // Manual count for category featured advertisements
            $catFeaAdvCount = 0;
            foreach ($categories as $cat) {
                $catins = new CategoryObj();
                $catins->category_id = $cat->id;
                $catins->category_name = $cat->name;
                //load sub category by category from join table(categoryhassubcategory)
                $subCategoryList = CategoryHasSubCategory::model()->with('subCategory', 'advertisement')->findall(
                        array(
                            'select' => '*',
                            'condition' => 't.category_id=:cat_id AND advertisement.status="Active" AND advertisement.exp_date > :exp_date',
                            'group' => 't.sub_category_id',
                            'params' => array(':cat_id' => $cat->id, ':exp_date' => date('Y-m-d')),
                        )
                );

                //get subcategory details
                $subcategoryarray = array();
                foreach ($subCategoryList as $value) {
                    $subcatins = new SubCategoryObj();
                    $subcatins->sub_category_id = (is_null($value->subCategory->id)) ? '-1' : $value->subCategory->id;
                    $subcatins->sub_category_name = (is_null($value->subCategory->id)) ? 'Main Sponsor' : $value->subCategory->name;

                    $advertisementarray = array();

                    //for category fetured advertisement
                    if ($subcatins->sub_category_id == '-1') {
                        $advertisementList = CategoryHasSubCategory::model()->with('advertisement')->findall(
                                array(
                                    'select' => '*',
                                    'condition' => 't.category_id=:cat_id AND advertisement.status="Active" AND advertisement.exp_date > :exp_date AND advertisement.is_featured=:fetured',
                                    'params' => array(':cat_id' => $cat->id, ':exp_date' => date('Y-m-d'), ':fetured' => Advertisement::CATEGORY_FEATURED_ADD),
                                )
                        );
                    } else {
                        //sub category fetured advertisement

                        $subFeaturedList = CategoryHasSubCategory::model()->with('advertisement')->findAll(array(
                            'select' => '*',
                            'condition' => 't.sub_category_id=:scat_id AND t.category_id=:cat_id AND advertisement.status="Active" AND advertisement.exp_date > :exp_date AND advertisement.is_featured=:fetured',
                            'params' => array(':cat_id' => $cat->id, ':exp_date' => date('Y-m-d'), ':scat_id' => $value->subCategory->id, ':fetured' => Advertisement::SUB_CATEGORY_FEATURED_ADD),
                        ));
                        $arraySub = array();
                        $cat_i = 0;
                        foreach ($subFeaturedList as $sValue) {

                            $arraySub[$cat_i] = $sValue->advertisement->id;
                            $cat_i++;
                        }
                        $subcatins->sub_category_featured_advertisements = $arraySub;
                        //load advertisement
                        $advertisementList = CategoryHasSubCategory::model()->with('advertisement')->findall(
                                array(
                                    'select' => '*',
                                    'condition' => 't.category_id=:cat_id AND t.sub_category_id=:sub_id AND advertisement.status="Active" AND advertisement.exp_date > :exp_date',
                                    'params' => array(':cat_id' => $cat->id, ':exp_date' => date('Y-m-d'), ':sub_id' => $value->subCategory->id),
                                )
                        );
                    }

                    foreach ($advertisementList as $addValue) {
                        $objadvertisement = new AdvertisementObj();
                        $objadvertisement->id = $addValue->advertisement->id;


                        //finding out the nearest location for the advertisement from the users location
                        $locadvertisements = LocationAdvertisement::model()->findAll('advertisement_id=:advertisement_id', array(':advertisement_id' => $addValue->advertisement->id));

                        //initialize to out of range values.
                        $nearestlat = -1000.00;
                        $nearestlong = -1000.00;
                        $squareofdiffs = -1000.00;

                        foreach ($locadvertisements as $locadvert) {
                            $latdiff = ($locadvert->location->latitude) - (float) $latitudeval;
                            $longdiff = ($locadvert->location->longitude) - (float) $longitudeval;
                            $square = ($latdiff * $latdiff) + ($longdiff * $longdiff);
                            if (($squareofdiffs < 0.00) || ( $square < $squareofdiffs )) {
                                $squareofdiffs = $square;
                                $nearestlat = $locadvert->location->latitude;
                                $nearestlong = $locadvert->location->longitude;
                            }
                        }

                        if ($nearestlat >= -90.00 && $nearestlat <= 90.00 && $nearestlong >= -180.00 && $nearestlong <= 180.00) {
                            $exactnlocation = array();
                            $exactnlocation[] = $nearestlat;
                            $exactnlocation[] = $nearestlong;
                            $objadvertisement->loc = $exactnlocation;
                        } else {
                            $objadvertisement->loc = null;
                        }

                        $objadvertisement->tag_line = $addValue->advertisement->tag_line;
                        $objadvertisement->offer_title = $addValue->advertisement->offer_title;
                        $objadvertisement->thumb_url = Yii::app()->params['hostname'] . $addValue->advertisement->thumb_url;
                        $objadvertisement->store_name = $addValue->advertisement->store_name;
                        $objadvertisement->exp_date = $addValue->advertisement->exp_date;
                        $advertisementarray[] = $objadvertisement;
                    }





                    $subcatins->advertisements = $advertisementarray;
                    //only add the subcategory if it contains any coupons
                    if (count($advertisementarray) > 0) {
                        $subcategoryarray[] = $subcatins;
                    }
                }
                $catins->advertisements = $subcategoryarray;
                $catogoryList = Advertisement::model()->with('categoryHasSubCategories')->findAll(array(
                    'select' => '*',
                    'condition' => 't.category_id=:cat_id AND t.status="Active" AND t.exp_date > :exp_date AND t.is_featured=:fetured',
                    'params' => array(':cat_id' => $cat->id, ':exp_date' => date('Y-m-d'), ':fetured' => Advertisement::CATEGORY_FEATURED_ADD),
                ));
                $array = array();
                $cat_i = 0;
                foreach ($catogoryList as $value) {

                    $array[$cat_i] = $value->id;
                    $cat_i++;
                }
                $catins->category_featured_advertisements = $array;
                if (count($subCategoryList) > 0) {
                    $categoryarray[] = $catins;
                }
            }
            $expireList = Advertisement::model()->findAll('exp_date>=:updated_date AND exp_date<:exp_date AND status=:status', array(':updated_date' => substr($last_update_date, 0, 10), ':exp_date' => $date, ':status' => 'Active'));
            foreach ($expireList as $expCoup) {
                $arrexpired[] = $expCoup->id;
            }
            $deactiveList = DeactivateAdvertisement::model()->findAll('updated_date>=:updated_date', array(':updated_date' => $last_update_date));
            foreach ($deactiveList as $deactiveCoup) {
                $arrexpired[] = $deactiveCoup->advertisement_id;
            }

            $AdvertisementListDataObj->expired = $arrexpired;
            $AdvertisementListDataObj->advertisements = $categoryarray;
            $advertisementD->response->data = $AdvertisementListDataObj;
            $advertisementD->response->server_time = $dateTime;
        } catch (Exception $ex) {
            $exception = 1;
            $exceptionmsg = $ex->getMessage();
        }
        // Output the JSON string in required format	  
        if ($exception == 0) {

            echo json_encode($advertisementD);
        } else {
            $advertisementD = new OutPutObj();
            $errorObj = new ErrorObj();
            $errorObj->code = $exceptioncode;
            $errorObj->message = $exceptionmsg;
            $errorrespobj = new ErrorResponseObj();
            $errorrespobj->error = $errorObj;
            $advertisementD->response = $errorrespobj;

            echo json_encode($advertisementD);
        }
    }

    /**
     * This is the GetCouponDetail action that is invoked
     * when request comes
     */
    public function actionGetAdvertisementDetail() {
        $exceptioncode = 108;
        $exceptionmsg = 'Error-Advetisement does not exist!';
        // renders the json output for the action
        //get the coupon id fro the request url
        $advert_id = $_GET['id'];
        //  initialize basic response object set
        $advertisementD = new OutPutObj();
        $advertisementD->response = new ResponseObj();
        $advertisementD->response->server_time = date('Y-m-d H:i:s');
        $AdvertisementDetailDataObj = new AdvertisementDetailDataObj();
        //populate object hierarchy
        $advertisement = Advertisement::model()->findByPk($advert_id);
        if ($advertisement != null) {
            //image urls are relative in the database. so make the full url by adding current hostname configuration details
            $AdvertisementDetailDataObj->image_url = Yii::app()->params['hostname'] . $advertisement->image_url;
            $AdvertisementDetailDataObj->terms = $advertisement->terms;
            $AdvertisementDetailDataObj->offer_description = $advertisement->offer_desc;
            //if category featued add order
            if ($advertisement->is_featured == Advertisement::CATEGORY_FEATURED_ADD) {
                $AdvertisementDetailDataObj->order = $advertisement->sequence;
            }
            if ($advertisement->vendor_id != null) {
                $vendorofAdvertisement = Vendor::model()->findByPk($advertisement->vendor_id);
                if ($vendorofAdvertisement != null) {
                    $vendorobj = new VendorObj();
                    $vendorobj->description = $vendorofAdvertisement->description;
                    $vendorobj->fb_url = $advertisement->fb_url;
                    $vendorobj->phone = $advertisement->store_phone;
                    $vendorobj->twitter_url = $advertisement->twitter;
                    $vendorobj->url = $advertisement->url;
                    $storeAddress = $advertisement->store_address;
                    $storeAddress1 = (empty($advertisement->address2) ? '' : ', ' . $advertisement->address2);
                    $storeAddress2 = (empty($advertisement->city) ? '' : ', ' . $advertisement->city);
                    $storeAddress3 = (empty($advertisement->state) ? '' : ', ' . $advertisement->state);
                    $storeAddress4 = (empty($advertisement->zip) ? '' : ', ' . $advertisement->zip);

                    $vendorobj->store_address = $storeAddress . $storeAddress1 . $storeAddress2 . $storeAddress3 . $storeAddress4;
                    $AdvertisementDetailDataObj->vendor = $vendorobj;
                }
            }
            $advertisementD->response->data = $AdvertisementDetailDataObj;
            //output the json string in required format
            echo json_encode($advertisementD);
        } else {
            $exceptioncode = 108;
            $exceptionmsg = 'Error-Advertisement does not exist!';
            $errorObj = new ErrorObj();
            $errorObj->code = $exceptioncode;
            $errorObj->message = $exceptionmsg;
            $errorrespobj = new ErrorResponseObj();
            $errorrespobj->error = $errorObj;
            $advertisementD->response = $errorrespobj;
            echo json_encode($advertisementD);
        }
    }

    /**
     * This is the GetCouponLocations action that is invoked
     * when request comes
     */
    public function actionGetAdvertisementLocations() {
        // renders the json output for the action
        //get the coupon id fro the request url
        $advertisement_id = $_GET['id'];

        //initialize basic response object set
        $advertisementD = new OutPutObj();
        $advertisementD->response = new ResponseObj();
        $LocationDataObj = new LocationDataObj();
        $advertisementD->response->server_time = date('Y-m-d H:i:s');
        //populate object hierarchy
        $advertisement = Advertisement::model()->findByPk($advertisement_id);
        if ($advertisement != null) {
            $locationAdvertisements = LocationAdvertisement::model()->findAll('advertisement_id=:advert_id', array(':advert_id' => $advertisement_id));
            $arr = array();
            foreach ($locationAdvertisements as $locadvert) {
                $sub_arr = array();
                $sub_arr[] = $locadvert->location->latitude;
                $sub_arr[] = $locadvert->location->longitude;
                $arr[] = $sub_arr;
            }
            $LocationDataObj->locations = $arr;
        }
        $advertisementD->response->data = $LocationDataObj;

        //output the json string in required format
        echo json_encode($advertisementD);
    }

    /**
     * This is the actionGetWeatherPages action that is invoked
     * to get a list of Url's
     */
    public function actionGetWeatherPages() {
        //initialize basic response object set
        $advertisementD = new OutPutObj();
        $advertisementD->response = new ResponseObj();
        $advertisementD->response->server_time = date('Y-m-d H:i:s');

        //get all updated and active list by date
        $criteria = new CDbCriteria();
        $criteria->condition = "status = 1";
        // $criteria->params = array(':updated_date' => $lastUpdateDate,);
        $wether_url = Url::model()->findAll($criteria);

        $wetherArray = array();
        $i = 0;
        foreach ($wether_url as $value) {
            $wetherArray[$i]['id'] = $value->id;
            $wetherArray[$i]['url'] = $value->url;
            $i++;
        }
        $advertisementD->response->data->weather_pages = $wetherArray;

        //output the json string in required format
        echo json_encode($advertisementD);
    }

    // Returns all the details related to particular coupon
    public function actionGetAdvertisementAllDetail() {
        $addvertisement_id = $_GET['id'];
        //initialize basic response object set
        $advetisementD = new OutPutObj();
        $advetisementD->response = new ResponseObj();
        $advetisementD->response->server_time = date('Y-m-d H:i:s');

        $addvertisment = CategoryHasSubCategory::model()->with('subCategory', 'category', 'advertisement')->findAll(array(
            'select' => '*',
            'condition' => 'advertisement.id =:ad_id',
            'params' => array(':ad_id' => $addvertisement_id),
        ));

        foreach ($addvertisment as $addvertisment) {
            $arr = array();
            $arr['id'] = $addvertisment->id;
            $arr['category_id'] = $addvertisment->category_id;
            $arr['category_name'] = $addvertisment->category->name;
            if ($addvertisment->advertisement->is_featured == Advertisement::CATEGORY_FEATURED_ADD) {
                $arr['category_featured_advertisement'] = TRUE;
            } else {
                $arr['category_featured_advertisement'] = FALSE;
            }
            if ($addvertisment->advertisement->is_featured == Advertisement::SUB_CATEGORY_FEATURED_ADD) {
                $arr['sub_category_featured_advertisement'] = TRUE;
            } else {
                $arr['sub_category_featured_advertisement'] = FALSE;
            }
            $arr['sub_category_id'] = (is_null($addvertisment->subCategory->id)) ? '-1' : $addvertisment->subCategory->id;
            $arr['sub_category_name'] = $addvertisment->subCategory->name;

            //get latitude longitude values
            $location = LocationAdvertisement::model()->with('location')->findByAttributes(array('advertisement_id' => $addvertisement_id));
            $arr['loc'] = array(($location->location->longitude) ? $location->location->longitude : '', ($location->location->latitude) ? $location->location->latitude : '');
            $arr['tag_line'] = $addvertisment->advertisement->tag_line;
            $arr['offer_description'] = $addvertisment->advertisement->offer_desc;
            $arr['offer_title'] = $addvertisment->advertisement->offer_title;
            $arr['thumb_url'] = yii::app()->params['hostname'] . $addvertisment->advertisement->thumb_url;
            $arr['exp_date'] = $addvertisment->advertisement->exp_date;
            $arr['image_url'] = yii::app()->params['hostname'] . $addvertisment->advertisement->image_url;
            $arr['terms'] = $addvertisment->advertisement->terms;
            $arr['vendor'] = array(
                'description' => $addvertisment->advertisement->description,
                'fb_url' => $addvertisment->advertisement->fb_url,
                'phone' => $addvertisment->advertisement->store_phone,
                'twitter_url' => $addvertisment->advertisement->twitter,
                'url' => $addvertisment->advertisement->url,
                'store_name' => $addvertisment->advertisement->store_name,
                'store_address' => $addvertisment->advertisement->address2 . ',' . $addvertisment->advertisement->store_address . ',' . $addvertisment->advertisement->city . ',' . $addvertisment->advertisement->state . ',' . $addvertisment->advertisement->zip,
            );
        }
        $advetisementD->response->data = $arr;
        //output the json string in required format
        echo json_encode($advetisementD);
    }

}