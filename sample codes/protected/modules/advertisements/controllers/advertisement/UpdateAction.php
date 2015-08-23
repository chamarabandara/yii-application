<?php

/**
 * Used to create a coupon
 *
 * @package qr.admin.Coupon
 */
class UpdateAction extends CAction {

    public function run() {
        $save = true;
        $basePath = dirname(__FILE__);
        $fileUploadPath = substr($basePath, 0, strripos($basePath, 'protected') - 1); //Yii::app()->params['uploadPath'];
        //updating sub categories
        if (isset($_GET['cat_id']) && !empty($_GET['add_name'])) {
            if (SubCategory::model()->exists("name = :val", array(':val' => $_GET['add_name']))) {
                Yii::app()->user->setFlash('success', 'Sub category already exists');
            } else {
                $sub_category = new SubCategory();
                $sub_category->name = $_GET['add_name'];
                $sub_category->category_id = $_GET['cat_id'];
                $sub_category->save();
                Yii::app()->user->setFlash('success', 'Sub category added successfully');
            }
        }
        if (isset($_GET['cat_id']) && !empty($_GET['new_name'])) {
            if (SubCategory::model()->exists("name = :val", array(':val' => $_GET['new_name']))) {
                Yii::app()->user->setFlash('success', 'Sub category already exists');
            } else {
                $sub_category = SubCategory::model()->findByPk($_GET['cat_id']);
                $sub_category->name = $_GET['new_name'];
                $sub_category->save();
                Yii::app()->user->setFlash('success', 'Sub category updated successfully');
            }
        }
        if (isset($_GET['cat_id']) && !empty($_GET['del_name'])) {
            $Criteria = new CDbCriteria();
            $Criteria->condition = "sub_category_id = :id";
            $Criteria->params = array(':id' => $_GET['cat_id']);
            $coup_exists = Coupon::model()->findAll($Criteria);
            if (count($coup_exists) > 0) {
                Yii::app()->user->setFlash('success', 'Can\'t delete. Coupons Exist for this sub category');
            } else {
                SubCategory::model()->deleteByPk($_GET['cat_id']);
                Yii::app()->user->setFlash('success', 'Sub category deleted successfully');
            }
        }

        $controller = $this->getController();

        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        if ($id == 0) {
            $coupons = new Coupon();
            $coupons->in_airport = 0;
            $coupons->catogary_id = 0;
            $locations = new Location();
            $subCategories = new SubCategory();
        } else {
            $coupons = Coupon::model()->with('locationCoupons')->findByPk($id);

            $coupons->catogary_id = isset($coupons->subCategory->category_id) ? $coupons->subCategory->category_id : 0;
            $locationCoupon = LocationCoupon::model()->with('location')->find('coupon_id=:coupon_id', array('coupon_id' => $coupons->id));

            $locations = isset($locationCoupon->location->id) ? Location::model()->findByPk($locationCoupon->location->id) : new Location();
            $subCategories = SubCategory::model()->findAll('category_id=:category_id', array(':category_id' => $coupons->catogary_id));
            //set the is_featured value to populate checkbox on page loading.
            if (($coupons->in_airport == "1") && ($coupons->id == $coupons->subCategory->category->featured_coupon)) {

                $coupons->is_featured = 1;
            }
            if (($coupons->in_airport == "0") && $coupons->id == ($coupons->subCategory->category->featured_coupon_nearby)) {
                $coupons->is_featured = 1;
            }
            // print_r($coupons);exit;
        }
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {

            echo CActiveForm::validate(array($model));

            Yii::app()->end();
        }

         if (isset($_POST['Save']) || isset($_POST['SavePreview'])) {
            $result_sub = 0;
                    $result = 0;
                //category fetured add  started
                //print_r($_POST);exit;
                foreach ($_POST['Coupon']['catogary_id'] as $value) {
                    // print_r($_FILES["thumb_image"]["tmp_name"]);exit;   
                    $_POST['Coupon']['catogary_id'] = $value;
                  
                    $subCategory1 = SubCategory::model()->findByAttributes(array('category_id' => $value, 'name' => 'main sponser'));
                    $_POST['Coupon']['sub_category_id'] = $subCategory1['id'];
                    //print_r($_POST['Coupon']['sub_category_id']);exit; 
                    

                    if ($_POST['Coupon']['is_featured'] == Coupon::CATEGORY_FEATURED_ADD) {

                        $result = Coupon::model()->with('subCategory')->count(new CDbCriteria(array
                            (
                            'condition' => 'subCategory.category_id = :cat_id and is_featured = :is_featured and exp_date > :exp_date and status= :status',
                            'params' => array(':cat_id' => $_POST['Coupon']['catogary_id'], ':is_featured' => Coupon::CATEGORY_FEATURED_ADD, ':exp_date' => date('Y-m-d'), ':status' => "Active")
                        )));
                        //  var_dump($result);exit;
                    } elseif ($_POST['Coupon']['is_featured'] == Coupon::SUB_CATEGORY_FEATURED_ADD) {

                        $result_sub = Coupon::model()->with('subCategory')->count(new CDbCriteria(array
                            (
                            'condition' => 'subCategory.id = :sub_cat_id and subCategory.category_id = :cat_id and is_featured = :is_featured and exp_date > :exp_date and status= :status',
                            'params' => array(':sub_cat_id' => $_POST['Coupon']['sub_category_id'], ':cat_id' => $_POST['Coupon']['catogary_id'], ':is_featured' => Coupon::SUB_CATEGORY_FEATURED_ADD, ':exp_date' => date('Y-m-d'), ':status' => "Active")
                        )));
                    }

                    if ($result < yii::app()->params['max_category_count'] && $result_sub < yii::app()->params['max_subcategory_count']) {
                        $coupons->attributes = $_POST['Coupon'];
                        $coupons->created_date = date('Y-m-d H:i:s');
                        $coupons->updated_date = date('Y-m-d H:i:s');
                        $coupons->status = 'Inactive';
                        $coupons->in_airport = 0;
                        $coupons->created_by = Yii::app()->user->getState('loggedUserId');
                        //$coupons->map_url = Yii::app()->params['hd_coded_map_url'];

                        if (!empty($_FILES["thumb_image"]["name"])) {
                            $coupons->thumb_url = '/images/136x136/' . md5(time().$value) . '.' . end(explode(".", $_FILES["thumb_image"]["name"]));
                        }

                        if (!empty($_FILES["large_image"]["name"])) {
                            $coupons->image_url = '/images/260x260/' . md5(time().$value) . '.' . end(explode(".", $_FILES["large_image"]["name"]));
                        }

                        if (!empty($_FILES["map_image"]["name"])) {
                            $coupons->map_url = '/images/t_map/' . md5(time().$value) . '.' . end(explode(".", $_FILES["map_image"]["name"]));
                        }

                        if (!empty($_FILES["QR_image"]["name"])) {
                            $coupons->qr_code_image_name = '/images/260x260/' . md5(time().$value) . 'QR.' . end(explode(".", $_FILES["QR_image"]["name"]));
                        }

                        $coupons->long = $_POST['Location']['longitude'];
                        $coupons->lat = $_POST['Location']['latitude'];
                        if ($coupons->validate(null, false)) {
                            if ($_POST['Coupon']['is_featured'] == Coupon::CATEGORY_FEATURED_ADD) {


                                if (!empty($_FILES["thumb_image"]["name"])) {
                                    $image136 = Yii::app()->image->load($_FILES["thumb_image"]["tmp_name"]);
                                    $image136->resize(540, 136, Image::NONE);
                                    $image136->save($fileUploadPath . $coupons->thumb_url);
                                }
                                if (!empty($coupons->thumb_url)) {
                                    $image136 = Yii::app()->image->load($fileUploadPath . $coupons->thumb_url);
                                    if ($image136) {
                                        $image136->resize(540, 136, Image::NONE);
                                        $image136->save($fileUploadPath . $coupons->thumb_url);
                                    }
                                }


                                if (!empty($_FILES["large_image"]["name"])) {
                                    $image260 = Yii::app()->image->load($_FILES["large_image"]["tmp_name"]);
                                    $image260->resize(600, NULL);
                                    $image260->save($fileUploadPath . $coupons->image_url);
                                }
                                if (!empty($coupons->image_url)) {
                                    $image260 = Yii::app()->image->load($fileUploadPath . $coupons->image_url);
                                    if ($image260) {
                                        $image260->resize(600, NULL);
                                        $image260->save($fileUploadPath . $coupons->image_url);
                                    }
                                }
                            } else {

                                if (!empty($_FILES["thumb_image"]["name"])) {
                                    $image136 = Yii::app()->image->load($_FILES["thumb_image"]["tmp_name"]);
                                    $image136->resize(136, 136, Image::NONE);
                                    $image136->save($fileUploadPath . $coupons->thumb_url);
                                }
                                if (!empty($coupons->thumb_url)) {
                                    $image136 = Yii::app()->image->load($fileUploadPath . $coupons->thumb_url);
                                    if ($image136) {
                                        $image136->resize(136, 136, Image::NONE);
                                        $image136->save($fileUploadPath . $coupons->thumb_url);
                                    }
                                }
                                if (!empty($_FILES["large_image"]["name"])) {
                                    $image260 = Yii::app()->image->load($_FILES["large_image"]["tmp_name"]);
                                    $image260->resize(260, 260, Image::NONE);
                                    $image260->save($fileUploadPath . $coupons->image_url);
                                }
                                if (!empty($coupons->image_url)) {
                                    $image260 = Yii::app()->image->load($fileUploadPath . $coupons->image_url);
                                    if ($image260) {
                                        $image260->resize(260, 260, Image::NONE);
                                        $image260->save($fileUploadPath . $coupons->image_url);
                                    }
                                }
                            }

                            if (!empty($_FILES["map_image"]["name"])) {
                                $image_map = Yii::app()->image->load($_FILES["map_image"]["tmp_name"]);
                                $image_map->resize(640, 960);
                                $image_map->save($fileUploadPath . $coupons->map_url);
                            }

                            if (!empty($_FILES["QR_image"]["name"])) {
                                $imageQR260 = Yii::app()->image->load($_FILES["QR_image"]["tmp_name"]);
                                $imageQR260->resize(260, 260);
                                $imageQR260->save($fileUploadPath . $coupons->qr_code_image_name);
                            }
                            if ($coupons->save()) {

                                $couponId = $coupons->id;
                                $locationCriteria = new CDbCriteria();
                                $locationCriteria->condition = 'longitude=:long and latitude=:lat';
                                $locationCriteria->params = array(':long' => $_POST['Location']['longitude'], ':lat' => $_POST['Location']['latitude']);
                                $locations = Location::model()->find($locationCriteria);
                                if ($locations == NULL) {
                                    $locations = new Location();
                                    $locations->attributes = $_POST['Location'];
                                    if ($locations->save()) {
                                        
                                    }
                                }

                                //as per requirement from client coupon has single location - confirmed by chandimda
                                //so delete the existing location if exist.
                                LocationCoupon::model()->deleteAll('coupon_id=:coupon_id', array(':coupon_id' => $couponId));
                                $locationCoupon = new LocationCoupon();
                                $locationCoupon->location_id = $locations->id;
                                $locationCoupon->coupon_id = $couponId;
                                if ($locationCoupon->save()) {
                                    
                                }

                                //save the is_featured value of coupon to right column in caterogy table.
                                $oldFeauredZCouponId = null;

                                if ($coupons->is_featured == "1" || $coupons->is_featured == "2") {
                                    // print_r($coupons->in_airport);exit;
                                    if ($coupons->in_airport == "1") {

                                        $oldFeauredZCouponId = $coupons->subCategory->category->featured_coupon;
                                        if ($coupons->subCategory->category->featured_coupon != $coupons->id) {
                                            $coupons->subCategory->category->featured_coupon = $couponId;
                                        }
                                    } else if ($coupons->in_airport == "0") {
                                        if ($coupons->subCategory->category->featured_coupon != $coupons->id) {
                                            $oldFeauredZCouponId = $coupons->subCategory->category->featured_coupon_nearby;
                                        }
                                        $coupons->subCategory->category->featured_coupon_nearby = $couponId;
                                    }
                                }
                                if ($coupons->is_featured == "2") {
                                    if ($coupons->in_airport == "1" && $coupons->subCategory->category->featured_coupon == $coupons->id) {
                                        $coupons->subCategory->category->featured_coupon = null;
                                    } else if ($coupons->in_airport == "0" && $coupons->subCategory->category->featured_coupon_nearby == $coupons->id) {
                                        $coupons->subCategory->category->featured_coupon_nearby = null;
                                    }
                                }
                                if ($coupons->is_featured == "0") {
                                    if ($coupons->in_airport == "1" && $coupons->subCategory->category->featured_coupon == $coupons->id) {
                                        $coupons->subCategory->category->featured_coupon = null;
                                    } else if ($coupons->in_airport == "0" && $coupons->subCategory->category->featured_coupon_nearby == $coupons->id) {
                                        $coupons->subCategory->category->featured_coupon_nearby = null;
                                    }
                                }
                                // print_r($oldFeauredZCouponId);exit;
//                                if ($oldFeauredZCouponId != null) {
//                                    $oldFeauredCoupon = Coupon::model()->findByPk($oldFeauredZCouponId);
//                                    $oldFeauredCoupon->updated_date = date('Y-m-d H:i:s');
//                                    $oldFeauredCoupon->save(false);
//                                }

                                $coupons->subCategory->category->save();

                                if (isset($_POST['Save'])) {
                                    if ($id == 0) {
                                        Yii::app()->user->setFlash('success', 'Coupon created successfully');
                                        $coupons = new Coupon();
                                    } else {
                                        Yii::app()->user->setFlash('success', 'Coupon updated successfully');
                                    }
                                }
                            }
                        } else {
                            $save = false;
                            if (isset($coupons->catogary_id) && $coupons->catogary_id > 0) {
                                $subCategories = SubCategory::model()->findAll('category_id=:category_id', array(':category_id' => $coupons->catogary_id));
                            }
                            $locations->latitude = $_POST['Location']['latitude'];
                            $locations->longitude = $_POST['Location']['longitude'];
                        }
                    }

                    if ($result >= yii::app()->params['max_category_count']) {
                        //$coupon->unsetAttributes();
                        $coupon = new Coupon;
                        $coupon->attributes = $_POST['Coupon'];

                        Yii::app()->user->setFlash('error', 'Can not Add more than 24 Category Featured Advertisement for seleced category.');
                    }
                    if ($result_sub >= yii::app()->params['max_subcategory_count']) {
                        $coupon = new Coupon;
                        $coupon->attributes = $_POST['Coupon'];
                        Yii::app()->user->setFlash('error', 'Can not Add more than 1 sub Category Featured Advertisement for seleced sub category.');
                    }
                }
                //category fetured add  end
            
            //end
        }



        if ($result >= yii::app()->params['max_category_count']) {
            //$coupon->unsetAttributes();
            $coupon = new Coupon;
            $coupon->attributes = $_POST['Coupon'];

            Yii::app()->user->setFlash('error', 'Can not Add more than 24 Category Featured Advertisement for seleced category.');
        }
        if ($result_sub >= yii::app()->params['max_subcategory_count']) {
            $coupon = new Coupon;
            $coupon->attributes = $_POST['Coupon'];
            Yii::app()->user->setFlash('error', 'Can not Add more than 1 sub Category Featured Advertisement for seleced sub category.');
        }
        if (isset($_POST['Deactivate'])) {

            if (isset($_POST['hdnCouponId'])) {
                $couponId = $_POST['hdnCouponId'];

                $deactiveCoupon = new DeactivateCoupon();
                $deactiveCoupon->coupon_id = $couponId;
                $deactiveCoupon->updated_date = date('Y-m-d H:i:s');

                $coupon = Coupon::model()->findByPk($couponId);
                $coupon->status = 'Inactive';
                $coupons->status = 'Inactive';
                $coupons->updated_date = date('Y-m-d H:i:s');
                $coupon->updated_date = date('Y-m-d H:i:s');
                $coupon->save(false);
                $deactiveCoupon->save();

                Yii::app()->user->setFlash('success', 'Coupon Deactivated');
            }
        }
        $vendors = Vendor::model()->findAll();
        $categories = Category::model()->findAll();
        $imageUrl = yii::app()->params['hostname'] . '/images/260x260/' . '00029df48cb2537ab3586c69e1c3617b.jpg';
        $params = array(
            'coupons' => $coupons,
            'locations' => $locations,
            'venders' => $vendors,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'imageUrl' => $imageUrl,
        );


        if ((isset($_POST['SavePreview']) || isset($_POST['Preview'])) && $save) {
            $controller->render('preview', $params);
        } else {
            $controller->render('update', $params);
        }
    }

    public function actionFormUpload() {
        $this->render('upload');
    }

    public function actionCropImg() {
        Yii::app()->clientScript->scriptMap = array(
            (YII_DEBUG ? 'jquery.js' : 'jquery.min.js') => false,
        );
        $imageUrl = Yii::app()->request->baseUrl . '/upload/' . $_GET['fileName'];
        $this->renderPartial('cropImg', array('imageUrl' => $imageUrl), false, true);
    }

    public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder = 'upload/'; // folder for uploaded files
        $allowedExtensions = array("jpg"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);

        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME
        $result = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result; // it's array
    }

}