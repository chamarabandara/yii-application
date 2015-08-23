<?php

/* Peachtree 
 * Advertisement Create action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class CreateAction extends CAction {

    public $result;

    public function run() {
        $save = true;
        $basePath = dirname(__FILE__);
        $controller = $this->getController();
        $fileUploadPath = substr($basePath, 0, strripos($basePath, 'protected') - 1);
       

        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        if ($id == 0) {
            $advertisement = new Advertisement();
            $locations = new Location();
            $subCategories = new SubCategory();
        } else {

            //set data to edit advertisement by ID
            $advertisement = Advertisement::model()->with('locationAdvertisement')->findByPk($id);
            //   print_r($advertisement->exp_date);exit;
            $advertisement->category_id = isset($advertisement->category_id) ? $advertisement->category_id : 0;
            //set location
            $locationAdvertisement = LocationAdvertisement::model()->with('location')->find('advertisement_id=:advertisement_id', array('advertisement_id' => $advertisement->id));
            $locations = isset($locationAdvertisement->location->id) ? Location::model()->findByPk($locationAdvertisement->location->id) : new Location();
            //set subcategory by ID
             //set subcategory by ID
             $subId = CategoryHasSubCategory::model()->findByAttributes(array('advertisement_id'=>$id,'category_id'=>$advertisement->category_id));
             
             $advertisement->sub_category_id = $subId->sub_category_id;
            $subCategories = SubCategory::model()->findAll('category_id=:category_id', array(':category_id' => $advertisement->category_id));
            
           
        }

        if (isset($_POST['Save']) || isset($_POST['SavePreview'])) {

            if ($_POST['Advertisement']['is_featured'] != Advertisement::CATEGORY_FEATURED_ADD) {
              
                $result_sub = 0;
                $result = 0;
                // check is sub category fetured addvertisement available under this category
                if ($_POST['Advertisement']['is_featured'] == Advertisement::SUB_CATEGORY_FEATURED_ADD) {

                    $result_sub = CategoryHasSubCategory::model()->with('advertisement')->count(new CDbCriteria(array
                        (
                        'condition' => 't.category_id = :cat_id and t.sub_category_id = :sub_cat_id and advertisement.is_featured = :is_featured and advertisement.exp_date > :exp_date and advertisement.status= :status',
                        'params' => array(':sub_cat_id' => $_POST['Advertisement']['sub_category_id'], ':cat_id' => $_POST['Advertisement']['category_id'][0], ':is_featured' => Advertisement::SUB_CATEGORY_FEATURED_ADD, ':exp_date' => date('Y-m-d'), ':status' => "Active")
                    )));
                }

                if ($result < yii::app()->params['max_category_count'] && $result_sub < yii::app()->params['max_subcategory_count']) {
                    $advertisement->attributes = $_POST['Advertisement'];
                    $advertisement->category_id = $_POST['Advertisement']['category_id'][0];
                    $advertisement->created_date = date('Y-m-d H:i:s');
                    $advertisement->updated_date = date('Y-m-d H:i:s');
                    $advertisement->status = 'Inactive';
                    $advertisement->created_by = Yii::app()->user->getState('loggedUserId');

                    if (!empty($_FILES["thumb_image"]["name"])) {
                        $advertisement->thumb_url = '/images/136x136/' . md5(time()) . '.' . end(explode(".", $_FILES["thumb_image"]["name"]));
                    }

                    if (!empty($_FILES["large_image"]["name"])) {
                        $advertisement->image_url = '/images/260x260/' . md5(time()) . '.' . end(explode(".", $_FILES["large_image"]["name"]));
                    }

                    if (!empty($_FILES["map_image"]["name"])) {
                        $advertisement->map_url = '/images/t_map/' . md5(time()) . '.' . end(explode(".", $_FILES["map_image"]["name"]));
                    }

                    if (!empty($_FILES["QR_image"]["name"])) {
                        $advertisement->qr_code_image_name = '/images/260x260/' . md5(time()) . 'QR.' . end(explode(".", $_FILES["QR_image"]["name"]));
                    }

                    $advertisement->long = $_POST['Location']['longitude'];
                    $advertisement->lat = $_POST['Location']['latitude'];
                    if ($advertisement->validate(null, false)) {
                        if ($_POST['Advertisement']['is_featured'] == Advertisement::CATEGORY_FEATURED_ADD) {


                            if (!empty($_FILES["thumb_image"]["name"])) {
                                $image136 = Yii::app()->image->load($_FILES["thumb_image"]["tmp_name"]);
                                $image136->resize(540, 136, Image::NONE);
                                $image136->save($fileUploadPath . $advertisement->thumb_url);
                            }
                            if (!empty($advertisement->thumb_url)) {
                                $image136 = Yii::app()->image->load($fileUploadPath . $advertisement->thumb_url);
                                if ($image136) {
                                    $image136->resize(540, 136, Image::NONE);
                                    $image136->save($fileUploadPath . $advertisement->thumb_url);
                                }
                            }


                            if (!empty($_FILES["large_image"]["name"])) {
                                $image260 = Yii::app()->image->load($_FILES["large_image"]["tmp_name"]);
                                $image260->resize(600, NULL);
                                $image260->save($fileUploadPath . $advertisement->image_url);
                            }
                            if (!empty($advertisement->image_url)) {
                                $image260 = Yii::app()->image->load($fileUploadPath . $advertisement->image_url);
                                if ($image260) {
                                    $image260->resize(600, NULL);
                                    $image260->save($fileUploadPath . $advertisement->image_url);
                                }
                            }
                        } else {

                            if (!empty($_FILES["thumb_image"]["name"])) {
                                $image136 = Yii::app()->image->load($_FILES["thumb_image"]["tmp_name"]);
                                $image136->resize(136, 136, Image::NONE);
                                $image136->save($fileUploadPath . $advertisement->thumb_url);
                            }
                            if (!empty($advertisement->thumb_url)) {
                                $image136 = Yii::app()->image->load($fileUploadPath . $advertisement->thumb_url);
                                if ($image136) {
                                    $image136->resize(136, 136, Image::NONE);
                                    $image136->save($fileUploadPath . $advertisement->thumb_url);
                                }
                            }
                            if (!empty($_FILES["large_image"]["name"])) {
                                $image260 = Yii::app()->image->load($_FILES["large_image"]["tmp_name"]);
                                $image260->resize(260, 260, Image::NONE);
                                $image260->save($fileUploadPath . $advertisement->image_url);
                            }
                            if (!empty($advertisement->image_url)) {
                                $image260 = Yii::app()->image->load($fileUploadPath . $advertisement->image_url);
                                if ($image260) {
                                    $image260->resize(260, 260, Image::NONE);
                                    $image260->save($fileUploadPath . $advertisement->image_url);
                                }
                            }
                        }

                        if (!empty($_FILES["map_image"]["name"])) {
                            $image_map = Yii::app()->image->load($_FILES["map_image"]["tmp_name"]);
                            $image_map->resize(640, 960);
                            $image_map->save($fileUploadPath . $advertisement->map_url);
                        }

                        if (!empty($_FILES["QR_image"]["name"])) {
                            $imageQR260 = Yii::app()->image->load($_FILES["QR_image"]["tmp_name"]);
                            $imageQR260->resize(260, 260);
                            $imageQR260->save($fileUploadPath . $advertisement->qr_code_image_name);
                        }
                        if ($advertisement->save()) {

                            $advertisementId = $advertisement->id;
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

                            //so delete the existing location if exist.
                            LocationAdvertisement::model()->deleteAll('advertisement_id=:advertisement_id', array(':advertisement_id' => $advertisementId));
                            $locationAdvertisement = new LocationAdvertisement();
                            $locationAdvertisement->location_id = $locations->id;
                            $locationAdvertisement->advertisement_id = $advertisementId;
                            if ($locationAdvertisement->save()) {
                                
                            }

                            //save addvertisement id , sub category id and category id  in table category_has_sub_category
                             $isHaveRecordHasCategory =  CategoryHasSubCategory::model()->findByAttributes(array('advertisement_id'=>$advertisementId));
                            
                             if($isHaveRecordHasCategory){
                                  CategoryHasSubCategory::model()->deleteAll('advertisement_id=:advertisement_id', array(':advertisement_id' => $advertisementId));
                             }
                            $CategoryHasSubCategory = new CategoryHasSubCategory();
                          
                            $CategoryHasSubCategory->advertisement_id = $advertisementId;
                            //  print_r($_POST['Advertisement']['sub_category_id']);exit;
                            $CategoryHasSubCategory->category_id = $_POST['Advertisement']['category_id'][0];
                            $CategoryHasSubCategory->sub_category_id = ($_POST['Advertisement']['sub_category_id']) ? $_POST['Advertisement']['sub_category_id'] : null;
                            if ($CategoryHasSubCategory->save());

                            //$advertisement->subCategory->category->save();

                            if (isset($_POST['Save'])) {
                                if ($id == 0) {
                                    Yii::app()->user->setFlash('success', 'Advertisement created successfully');
                                    $advertisement = new Advertisement();
                                } else {
                                    Yii::app()->user->setFlash('success', 'Advertisement updated successfully');
                                }
                            }
                        }
                    } else {
                        $save = false;
                        if (isset($advertisement->catogary_id) && $advertisement->catogary_id > 0) {
                            $subCategories = SubCategory::model()->findAll('category_id=:category_id', array(':category_id' => $advertisement->catogary_id));
                        }
                        $locations->latitude = $_POST['Location']['latitude'];
                        $locations->longitude = $_POST['Location']['longitude'];
                    }
                }

                if ($result >= yii::app()->params['max_category_count']) {

                    $advertisement = new Advertisement;
                    $advertisement->attributes = $_POST['Advertisement'];

                    Yii::app()->user->setFlash('error', 'Can not Add more than 24 Category Featured Advertisement for seleced category.');
                }
                if ($result_sub >= yii::app()->params['max_subcategory_count']) {
                    $advertisement = new Advertisement;
                    $advertisement->attributes = $_POST['Advertisement'];
                    Yii::app()->user->setFlash('error', 'Can not Add more than 1 sub Category Featured Advertisement for seleced sub category.');
                }
            }
            //category fetured advertisement
            if ($_POST['Advertisement']['is_featured'] == Advertisement::CATEGORY_FEATURED_ADD && !isset($_GET['id'])) {
                foreach ($_POST['Advertisement']['category_id'] as $value) {

                    $_POST['Advertisement']['category_id'] = $value;
                    $result_sub = 0;
                    $result = 0;

                    if ($_POST['Advertisement']['is_featured'] == Advertisement::CATEGORY_FEATURED_ADD) {


                        $result = CategoryHasSubCategory::model()->with('advertisement')->count(new CDbCriteria(array
                            (
                            'condition' => 't.category_id = :cat_id and advertisement.is_featured = :is_featured and advertisement.exp_date > :exp_date and advertisement.status= :status',
                            'params' => array(':cat_id' => $_POST['Advertisement']['catogary_id'], ':is_featured' => Advertisement::CATEGORY_FEATURED_ADD, ':exp_date' => date('Y-m-d'), ':status' => "Active")
                        )));
                    }

                    if ($result < yii::app()->params['max_category_count'] && $result_sub < yii::app()->params['max_subcategory_count']) {
                        $advertisement->attributes = $_POST['Advertisement'];
                        $advertisement->created_date = date('Y-m-d H:i:s');
                        $advertisement->updated_date = date('Y-m-d H:i:s');
                        $advertisement->status = 'Inactive';
                        $advertisement->created_by = Yii::app()->user->getState('loggedUserId');

                        if (!empty($_FILES["thumb_image"]["name"])) {
                            $advertisement->thumb_url = '/images/136x136/' . md5(time() . $value) . '.' . end(explode(".", $_FILES["thumb_image"]["name"]));
                        }

                        if (!empty($_FILES["large_image"]["name"])) {
                            $advertisement->image_url = '/images/260x260/' . md5(time() . $value) . '.' . end(explode(".", $_FILES["large_image"]["name"]));
                        }

                        if (!empty($_FILES["map_image"]["name"])) {
                            $advertisement->map_url = '/images/t_map/' . md5(time() . $value) . '.' . end(explode(".", $_FILES["map_image"]["name"]));
                        }

                        if (!empty($_FILES["QR_image"]["name"])) {
                            $advertisement->qr_code_image_name = '/images/260x260/' . md5(time() . $value) . 'QR.' . end(explode(".", $_FILES["QR_image"]["name"]));
                        }

                        $advertisement->long = $_POST['Location']['longitude'];
                        $advertisement->lat = $_POST['Location']['latitude'];
                        if ($advertisement->validate(null, false)) {
                            if ($_POST['Advertisement']['is_featured'] == Advertisement::CATEGORY_FEATURED_ADD) {


                                if (!empty($_FILES["thumb_image"]["name"])) {
                                    $image136 = Yii::app()->image->load($_FILES["thumb_image"]["tmp_name"]);
                                    $image136->resize(540, 136, Image::NONE);
                                    $image136->save($fileUploadPath . $advertisement->thumb_url);
                                }
                                if (!empty($advertisement->thumb_url)) {
                                    $image136 = Yii::app()->image->load($fileUploadPath . $advertisement->thumb_url);
                                    if ($image136) {
                                        $image136->resize(540, 136, Image::NONE);
                                        $image136->save($fileUploadPath . $advertisement->thumb_url);
                                    }
                                }


                                if (!empty($_FILES["large_image"]["name"])) {
                                    $image260 = Yii::app()->image->load($_FILES["large_image"]["tmp_name"]);
                                    $image260->resize(600, NULL);
                                    $image260->save($fileUploadPath . $advertisement->image_url);
                                }
                                if (!empty($advertisement->image_url)) {
                                    $image260 = Yii::app()->image->load($fileUploadPath . $advertisement->image_url);
                                    if ($image260) {
                                        $image260->resize(600, NULL);
                                        $image260->save($fileUploadPath . $advertisement->image_url);
                                    }
                                }
                            } else {

                                if (!empty($_FILES["thumb_image"]["name"])) {
                                    $image136 = Yii::app()->image->load($_FILES["thumb_image"]["tmp_name"]);
                                    $image136->resize(136, 136, Image::NONE);
                                    $image136->save($fileUploadPath . $advertisement->thumb_url);
                                }
                                if (!empty($advertisement->thumb_url)) {
                                    $image136 = Yii::app()->image->load($fileUploadPath . $advertisement->thumb_url);
                                    if ($image136) {
                                        $image136->resize(136, 136, Image::NONE);
                                        $image136->save($fileUploadPath . $advertisement->thumb_url);
                                    }
                                }
                                if (!empty($_FILES["large_image"]["name"])) {
                                    $image260 = Yii::app()->image->load($_FILES["large_image"]["tmp_name"]);
                                    $image260->resize(260, 260, Image::NONE);
                                    $image260->save($fileUploadPath . $advertisement->image_url);
                                }
                                if (!empty($advertisement->image_url)) {
                                    $image260 = Yii::app()->image->load($fileUploadPath . $advertisement->image_url);
                                    if ($image260) {
                                        $image260->resize(260, 260, Image::NONE);
                                        $image260->save($fileUploadPath . $advertisement->image_url);
                                    }
                                }
                            }

                            if (!empty($_FILES["map_image"]["name"])) {
                                $image_map = Yii::app()->image->load($_FILES["map_image"]["tmp_name"]);
                                $image_map->resize(640, 960);
                                $image_map->save($fileUploadPath . $advertisement->map_url);
                            }

                            if (!empty($_FILES["QR_image"]["name"])) {
                                $imageQR260 = Yii::app()->image->load($_FILES["QR_image"]["tmp_name"]);
                                $imageQR260->resize(260, 260);
                                $imageQR260->save($fileUploadPath . $advertisement->qr_code_image_name);
                            }
                            if ($advertisement->save()) {

                                $advertisementId = $advertisement->id;
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


                                //so delete the existing location if exist.
                                LocationAdvertisement::model()->deleteAll('advertisement_id=:advertisement_id', array(':advertisement_id' => $advertisementId));
                                $locationAdvertisement = new LocationAdvertisement();
                                $locationAdvertisement->location_id = $locations->id;
                                $locationAdvertisement->advertisement_id = $advertisementId;
                                if ($locationAdvertisement->save()) {
                                    
                                }
                                //save addvertisement id , sub category id and category id  in table category_has_sub_category
                                $isHaveRecordHasCategory = CategoryHasSubCategory::model()->findByAttributes(array('advertisement_id' => $advertisementId));
                                if ($isHaveRecordHasCategory) {
                                    $CategoryHasSubCategory = $isHaveRecordHasCategory;
                                } else {
                                    $CategoryHasSubCategory = new CategoryHasSubCategory();
                                }
                               
                                $CategoryHasSubCategory->advertisement_id = $advertisementId;
                                $CategoryHasSubCategory->category_id = $value;

                                if ($CategoryHasSubCategory->save());


                                //  $advertisement->subCategory->category->save();

                                if (isset($_POST['Save'])) {
                                    if ($id == 0) {
                                        Yii::app()->user->setFlash('success', 'Advertisement created successfully');
                                        $advertisement = new Advertisement();
                                    } else {
                                        Yii::app()->user->setFlash('success', 'Advertisement updated successfully');
                                    }
                                }
                            }
                        } else {
                            $save = false;
                            if (isset($advertisement->catogary_id) && $advertisement->catogary_id > 0) {
                                $subCategories = SubCategory::model()->findAll('category_id=:category_id', array(':category_id' => $advertisement->catogary_id));
                            }
                            $locations->latitude = $_POST['Location']['latitude'];
                            $locations->longitude = $_POST['Location']['longitude'];
                        }
                    }

                    if ($result >= yii::app()->params['max_category_count']) {

                        $advertisement = new Advertisement;
                        $advertisement->attributes = $_POST['Advertisement'];

                        Yii::app()->user->setFlash('error', 'Can not Add more than 24 Category Featured Advertisement for seleced category.');
                    }
                    if ($result_sub >= yii::app()->params['max_subcategory_count']) {
                        $advertisement = new Advertisement;
                        $advertisement->attributes = $_POST['Advertisement'];
                        Yii::app()->user->setFlash('error', 'Can not Add more than 1 sub Category Featured Advertisement for seleced sub category.');
                    }
                }
            }
            //category featured advertisement edit
            if ($_POST['Advertisement']['is_featured'] == Advertisement::CATEGORY_FEATURED_ADD && isset($_GET['id'])) {

               
                $result_sub = 0;
                $result = 0;

                if ($_POST['Advertisement']['is_featured'] == Advertisement::CATEGORY_FEATURED_ADD) {


                    $result = CategoryHasSubCategory::model()->with('advertisement')->count(new CDbCriteria(array
                        (
                        'condition' => 't.category_id = :cat_id and advertisement.is_featured = :is_featured and advertisement.exp_date > :exp_date and advertisement.status= :status',
                        'params' => array(':cat_id' => $_POST['Advertisement']['catogary_id'], ':is_featured' => Advertisement::CATEGORY_FEATURED_ADD, ':exp_date' => date('Y-m-d'), ':status' => "Active")
                    )));
                }

                if ($result < yii::app()->params['max_category_count'] && $result_sub < yii::app()->params['max_subcategory_count']) {
                    $advertisement->attributes = $_POST['Advertisement'];
                    $advertisement->category_id = $_POST['Advertisement']['category_id'][0];
                    $advertisement->created_date = date('Y-m-d H:i:s');
                    $advertisement->updated_date = date('Y-m-d H:i:s');
                    $advertisement->status = 'Inactive';
                    $advertisement->created_by = Yii::app()->user->getState('loggedUserId');

                    if (!empty($_FILES["thumb_image"]["name"])) {
                        $advertisement->thumb_url = '/images/136x136/' . md5(time()) . '.' . end(explode(".", $_FILES["thumb_image"]["name"]));
                    }

                    if (!empty($_FILES["large_image"]["name"])) {
                        $advertisement->image_url = '/images/260x260/' . md5(time()) . '.' . end(explode(".", $_FILES["large_image"]["name"]));
                    }

                    if (!empty($_FILES["map_image"]["name"])) {
                        $advertisement->map_url = '/images/t_map/' . md5(time()) . '.' . end(explode(".", $_FILES["map_image"]["name"]));
                    }

                    if (!empty($_FILES["QR_image"]["name"])) {
                        $advertisement->qr_code_image_name = '/images/260x260/' . md5(time()) . 'QR.' . end(explode(".", $_FILES["QR_image"]["name"]));
                    }

                    $advertisement->long = $_POST['Location']['longitude'];
                    $advertisement->lat = $_POST['Location']['latitude'];
                    if ($advertisement->validate(null, false)) {
                        if ($_POST['Advertisement']['is_featured'] == Advertisement::CATEGORY_FEATURED_ADD) {


                            if (!empty($_FILES["thumb_image"]["name"])) {
                                $image136 = Yii::app()->image->load($_FILES["thumb_image"]["tmp_name"]);
                                $image136->resize(540, 136, Image::NONE);
                                $image136->save($fileUploadPath . $advertisement->thumb_url);
                            }
                            if (!empty($advertisement->thumb_url)) {
                                $image136 = Yii::app()->image->load($fileUploadPath . $advertisement->thumb_url);
                                if ($image136) {
                                    $image136->resize(540, 136, Image::NONE);
                                    $image136->save($fileUploadPath . $advertisement->thumb_url);
                                }
                            }


                            if (!empty($_FILES["large_image"]["name"])) {
                                $image260 = Yii::app()->image->load($_FILES["large_image"]["tmp_name"]);
                                $image260->resize(600, NULL);
                                $image260->save($fileUploadPath . $advertisement->image_url);
                            }
                            if (!empty($advertisement->image_url)) {
                                $image260 = Yii::app()->image->load($fileUploadPath . $advertisement->image_url);
                                if ($image260) {
                                    $image260->resize(600, NULL);
                                    $image260->save($fileUploadPath . $advertisement->image_url);
                                }
                            }
                        } else {

                            if (!empty($_FILES["thumb_image"]["name"])) {
                                $image136 = Yii::app()->image->load($_FILES["thumb_image"]["tmp_name"]);
                                $image136->resize(136, 136, Image::NONE);
                                $image136->save($fileUploadPath . $advertisement->thumb_url);
                            }
                            if (!empty($advertisement->thumb_url)) {
                                $image136 = Yii::app()->image->load($fileUploadPath . $advertisement->thumb_url);
                                if ($image136) {
                                    $image136->resize(136, 136, Image::NONE);
                                    $image136->save($fileUploadPath . $advertisement->thumb_url);
                                }
                            }
                            if (!empty($_FILES["large_image"]["name"])) {
                                $image260 = Yii::app()->image->load($_FILES["large_image"]["tmp_name"]);
                                $image260->resize(260, 260, Image::NONE);
                                $image260->save($fileUploadPath . $advertisement->image_url);
                            }
                            if (!empty($advertisement->image_url)) {
                                $image260 = Yii::app()->image->load($fileUploadPath . $advertisement->image_url);
                                if ($image260) {
                                    $image260->resize(260, 260, Image::NONE);
                                    $image260->save($fileUploadPath . $advertisement->image_url);
                                }
                            }
                        }

                        if (!empty($_FILES["map_image"]["name"])) {
                            $image_map = Yii::app()->image->load($_FILES["map_image"]["tmp_name"]);
                            $image_map->resize(640, 960);
                            $image_map->save($fileUploadPath . $advertisement->map_url);
                        }

                        if (!empty($_FILES["QR_image"]["name"])) {
                            $imageQR260 = Yii::app()->image->load($_FILES["QR_image"]["tmp_name"]);
                            $imageQR260->resize(260, 260);
                            $imageQR260->save($fileUploadPath . $advertisement->qr_code_image_name);
                        }
                        if ($advertisement->save()) {

                            $advertisementId = $advertisement->id;
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

                            //so delete the existing location if exist.
                            LocationAdvertisement::model()->deleteAll('advertisement_id=:advertisement_id', array(':advertisement_id' => $advertisementId));
                            $locationAdvertisement = new LocationAdvertisement();
                            $locationAdvertisement->location_id = $locations->id;
                            $locationAdvertisement->advertisement_id = $advertisementId;
                            if ($locationAdvertisement->save()) {
                                
                            }

                            //save addvertisement id , sub category id and category id  in table category_has_sub_category
                             $isHaveRecordHasCategory =  CategoryHasSubCategory::model()->findByAttributes(array('advertisement_id'=>$advertisementId));
                            
                             if($isHaveRecordHasCategory){
                                  CategoryHasSubCategory::model()->deleteAll('advertisement_id=:advertisement_id', array(':advertisement_id' => $advertisementId));
                             }
                            $CategoryHasSubCategory = new CategoryHasSubCategory();
                          
                            $CategoryHasSubCategory->advertisement_id = $advertisementId;
                            //  print_r($_POST['Advertisement']['sub_category_id']);exit;
                            $CategoryHasSubCategory->category_id = $_POST['Advertisement']['category_id'][0];
                          //  $CategoryHasSubCategory->sub_category_id = ($_POST['Advertisement']['sub_category_id']) ? $_POST['Advertisement']['sub_category_id'] : null;
                            if ($CategoryHasSubCategory->save());

                            //$advertisement->subCategory->category->save();

                            if (isset($_POST['Save'])) {
                                if ($id == 0) {
                                    Yii::app()->user->setFlash('success', 'Advertisement created successfully');
                                    $advertisement = new Advertisement();
                                } else {
                                    Yii::app()->user->setFlash('success', 'Advertisement updated successfully');
                                }
                            }
                        }
                    } else {
                        $save = false;
                        if (isset($advertisement->catogary_id) && $advertisement->catogary_id > 0) {
                            $subCategories = SubCategory::model()->findAll('category_id=:category_id', array(':category_id' => $advertisement->catogary_id));
                        }
                        $locations->latitude = $_POST['Location']['latitude'];
                        $locations->longitude = $_POST['Location']['longitude'];
                    }
                }

                if ($result >= yii::app()->params['max_category_count']) {

                    $advertisement = new Advertisement;
                    $advertisement->attributes = $_POST['Advertisement'];

                    Yii::app()->user->setFlash('error', 'Can not Add more than 24 Category Featured Advertisement for seleced category.');
                }
                if ($result_sub >= yii::app()->params['max_subcategory_count']) {
                    $advertisement = new Advertisement;
                    $advertisement->attributes = $_POST['Advertisement'];
                    Yii::app()->user->setFlash('error', 'Can not Add more than 1 sub Category Featured Advertisement for seleced sub category.');
                }
            }
            //end category featured advertisement edit
        }


        if (isset($_POST['Deactivate'])) {

            if (isset($_POST['hdnCouponId'])) {
                $advertisementId = $_POST['hdnCouponId'];

                $deactiveAdvertisement = new DeactivateAdvertisement();
                $deactiveAdvertisement->advertisement_id = $advertisementId;
                $deactiveAdvertisement->updated_date = date('Y-m-d H:i:s');
               
                $advertisement = Advertisement::model()->findByPk($advertisementId);
                $subId = CategoryHasSubCategory::model()->findByAttributes(array('advertisement_id'=>$advertisementId,'category_id'=>$advertisement->category_id));
                $advertisement->sub_category_id = $subId->sub_category_id;
                $advertisement->status = 'Inactive';
                $advertisement->status = 'Inactive';
                $advertisement->updated_date = date('Y-m-d H:i:s');
                $advertisement->updated_date = date('Y-m-d H:i:s');
                $advertisement->save(false);
                $deactiveAdvertisement->save();

                Yii::app()->user->setFlash('success', 'Advertisement Deactivated');
            }
        }

        if (isset($_POST['Activate'])) {

            if (isset($_POST['hdnCouponId'])) {
                $advertisementId = $_POST['hdnCouponId'];
                $advertisement = Advertisement::model()->findByPk($advertisementId);
                $subId = CategoryHasSubCategory::model()->findByAttributes(array('advertisement_id'=>$advertisementId,'category_id'=>$advertisement->category_id));
                $advertisement->sub_category_id = $subId->sub_category_id;
                $advertisement->status = 'Active';
                $advertisement->status = 'Active';
                $advertisement->updated_date = date('Y-m-d H:i:s');
                $advertisement->updated_date = date('Y-m-d H:i:s');
                $advertisement->save(false);
                DeactivateAdvertisement::model()->deleteAll('advertisement_id=' . $advertisementId);
                Yii::app()->user->setFlash('success', 'Advertisement Activated');
            }
        }

        $vendors = Vendor::model()->findAll();
        $categories = Category::model()->findAll();
       // $advertisement->fb_url = '';
        //$advertisement->twitter = '';

        $params = array(
            'advertisement' => $advertisement,
            'locations' => $locations,
            'venders' => $vendors,
            'categories' => $categories,
            'subCategories' => $subCategories
        );

        if ((isset($_GET['preview']) && $_GET['preview'] == 'yes')) {
            $controller->render('preview', $params);
            return;
        }
        if ((isset($_GET['redeem']) && $_GET['redeem'] == 'yes')) {
            $controller->render('redeem', $params);
            return;
        }
        if ((isset($_GET['catlist']) && $_GET['catlist'] == 'yes')) {
            $controller->render('catlist', $params);
            return;
        }
        if ((isset($_GET['mapview']) && $_GET['mapview'] == 'yes')) {
            $controller->render('mapview', $params);
            return;
        }

        if ((isset($_POST['SavePreview']) || isset($_POST['Preview'])) && $save) {
            $controller->render('preview', $params);
        } else {
            $controller->render('create', $params);
        }
    }

}