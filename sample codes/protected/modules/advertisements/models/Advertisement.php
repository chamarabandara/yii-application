<?php

/**
 * This is the model class for table "advertisement".
 *
 * The followings are the available columns in table 'advertisement':
 * @property string $id
 * @property string $created_date
 * @property string $exp_date
 * @property string $offer_title
 * @property string $offer_desc
 * @property string $terms
 * @property string $image_url
 * @property string $thumb_url
 * @property integer $in_airport
 * @property string $n_loc
 * @property string $gate
 * @property string $vendor_id
 * @property string $sub_category_id
 * @property string $qr_code
 * @property string $map_url
 * @property string $atrium
 * @property integer $created_by
 * @property string $status
 * @property string $store_name
 * @property string $tag_line
 * @property string $qr_code_image_name
 * @property string $store_phone
 * @property string $terminal_map
 * @property string $store_address
 * @property string $concourse
 * @property string $updated_date
 * @property string $fb_url
 * @property string $twitter
 * @property string $url
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $is_featured
 * @property integer $sequence
 * @property string $promo_text
 *
 * The followings are the available model relations:
 * @property Concourse[] $concourses
 * @property ConcourseCoupon[] $concourseCoupons
 * @property SubCategory $subCategory
 * @property Vendor $vendor
 * @property LocationCoupon[] $locationCoupons
 */
class Advertisement extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Advertisement the static model class
     */
    public $selection;
    public $is_featured = 0;
    public $location = '';
    public $description;
    public $long;
    public $lat;
    public static $rowCount;
    public $venderDescription;
    public $thumb_image;
    public $previous_add_type;
    public $thumb_image_url;
    public $large_image_url;
    public $lag_text;
    public $tumb_text;
    public $category_id;
    public $sub_category_id;
    public $validate_category;

    const CATEGORY_FEATURED_ADD = 1;
    const SUB_CATEGORY_FEATURED_ADD = 2;
    const NORMAL_FEATURED_ADD = 0;

    private $_vendorName = null;

    public function getVendorName() {
        if ($this->_vendorName === null && $this->vendor !== null) {
            $this->_vendorName = $this->vendor->first_name;
        }
    }

    public function setVendorName($value) {
        $this->_vendorName = $value;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'advertisement';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('vendor_id, store_name, store_phone, offer_title, offer_desc,exp_date, image_url,thumb_url, is_featured', 'required'),
            array('thumb_url', 'validateThumbUrl'),
            array('image_url', 'validateImageUrl'),
            array('map_url', 'validateMapUrl'),
            array('thumb_url', 'validateThumbImageSize'),
            array('image_url', 'validateLargeImageSize'),
            //  array('is_featured', 'validateCategory'),
            array('qr_code_image_name', 'validateQrCodeImageName'),
            array('offer_title, qr_code', 'length', 'max' => 50),
        	array('promo_text', 'length', 'max'=>9),
            array('offer_desc, terms', 'length', 'max' => 1024),
            array('atrium, fb_url, twitter, url', 'length', 'max' => 128),
            array('image_url, thumb_url, map_url, qr_code_image_name', 'length', 'max' => 160),
            array('n_loc, vendor_id, sub_category_id', 'length', 'max' => 20),
            array('gate', 'length', 'max' => 64),
            array('store_name, store_address, concourse', 'length', 'max' => 256),
            array('fb_url, twitter, url', 'url'),
            array('store_phone', 'match', 'pattern' => '/^[0-9]{1}-[0-9]{3}-[0-9]{3}-[0-9]{4}$/'),
            array('address2', 'length', 'max' => 400),
            array('city, state', 'length', 'max' => 30),
            array('zip', 'length', 'max' => 50),
            array('validate_category', 'validateCategory'),
            array('longitude', 'validateLong'),
            array('latitude', 'validateLat'),
            array('created_date, exp_date, status, created_by, updated_date, fb_url, twitter, url, store_phone, tag_line, selection, category_id, is_featured, lag_text, tumb_text, sequence, promo_text', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, created_date, vendorName, exp_date, offer_title, offer_desc, terms, image_url, thumb_url, in_airport, n_loc, gate, vendor_id, sub_category_id, qr_code, map_url, atrium, store_name, store_address, concourse, updated_date, fb_url, twitter, url, address2, city, state, zip, store_phone, tag_line, status, selection, category_id, user, sequence, promo_text', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    //custom validation
    public function validateCategory() {
        if ($this->is_featured == Advertisement::CATEGORY_FEATURED_ADD) {
            $this->validate_category = TRUE;
        } else {
            $this->validate_category = FALSE;
        }
    }

    public function validateThumbImageSize() {
        if (!empty($_FILES["thumb_image"]["name"])) {
            if ($this->is_featured == Advertisement::CATEGORY_FEATURED_ADD) {
                list($width, $height) = getimagesize($_FILES["thumb_image"]["tmp_name"]);
                if ($width !== 630 && $height !== 160) {
                    $this->addError('thumb_image', 'Invalid Size Error for Thumbnail Image of Category Fetured Advertisement');
                }
            } else if ($this->is_featured == Advertisement::SUB_CATEGORY_FEATURED_ADD) {
                list($width, $height) = getimagesize($_FILES["thumb_image"]["tmp_name"]);
                if ($width !== 630 && $height !== 160) {
                    $this->addError('thumb_image', 'Invalid Size Error for Thumbnail Image of Sub Category Fetured Advertisement');
                }
            } else {
                list($width, $height) = getimagesize($_FILES["thumb_image"]["tmp_name"]);
                if ($width !== 160 && $height !== 160) {
                    $this->addError('thumb_image', 'Invalid Size Error for Thumbnail Image of Normal Advertisement');
                }
            }
        }
    }

    public function validateLargeImageSize() {
        if (!empty($_FILES["large_image"]["name"])) {
            if ($this->is_featured == Advertisement::CATEGORY_FEATURED_ADD) {
                list($width, $height) = getimagesize($_FILES["large_image"]["tmp_name"]);
              
            if (!(($width < yii::app()->params['max_width_large_image']) && ($width > yii::app()->params['min_width_large_image'])) && !($height < (($width / 100) * 60) && $height > (($width / 100) * 20)))
                {                   // yii::app()->params['max_width_large_image'];
                   $this->addError('large_image', 'Invalid Size Error for Large Image of Category Fetured Advertisement');
               }
            } else if ($this->is_featured == Advertisement::SUB_CATEGORY_FEATURED_ADD) {
                list($width, $height) = getimagesize($_FILES["large_image"]["tmp_name"]);
            if (!(($width < yii::app()->params['max_width_large_image']) && ($width > yii::app()->params['min_width_large_image'])) && !($height < (($width / 100) * 60) && $height > (($width / 100) * 20)))
                {
               /* if ($width !== 260 && $height !== 260) {*/
                    $this->addError('large_image', 'Invalid Size Error for Large Image of Sub Category Fetured Advertisement');
                }
            } else {
                list($width, $height) = getimagesize($_FILES["large_image"]["tmp_name"]);
                  echo 'width';
                var_dump(($width < yii::app()->params['max_width_large_image']));
                var_dump(($width > yii::app()->params['min_width_large_image']));
                
                  var_dump(!(($width < yii::app()->params['max_width_large_image']) && ($width > yii::app()->params['min_width_large_image'])));
                  echo "string";
// //$widthPre = 0;
                  $heightMin = ($width / 100)* 20;
                  $heightMax = ($width / 100)* 60;

                ///  var_dump($heightMin);
                 ///  var_dump($heightMax);
                  var_dump($height);
                  var_dump($width);
                  var_dump(!($height < $heightMax && $height > $heightMin));
                
//                  exit;


               if (!(($width < yii::app()->params['max_width_large_image']) && ($width > yii::app()->params['min_width_large_image'])) || !($height < $heightMax && $height > $heightMin))
                {

               // if ($width !== 260 && $height !== 260) {
                    $this->addError('large_image', 'Invalid Size Error for Large Image of Normal Advertisement');
                }
            }
        }
    }

     public function validateLong() {
        $lg = preg_match("/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}$/", trim($this->long));
        if (empty($this->long)) {

            $this->addError('longitude', 'Longitude: cannot be blank.');
        } elseif (count(explode('.', $this->long)) >= 3) {

            $this->addError('longitude', 'Invalid Longitude format.');
        } elseif (empty ($lg)) {
            $this->addError('longitude', 'Invalid Longitude format.');
        }
    }

    public function validateLat() {
        $lt= preg_match("/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/", trim($this->lat));
        if (empty($this->lat)) {
            $this->addError('latitude', 'Latitude: cannot be blank.');
        } elseif (count(explode('.', $this->lat)) >= 3) {
            $this->addError('longitude', 'Invalid Latitude format.');
        } elseif (empty ($lt)) {
            $this->addError('longitude', 'Invalid Latitude format.');
        }

    }

    public function validateThumbUrl() {
        if (!empty($this->thumb_url)) {
            $ext = strtoupper(end(explode(".", $this->thumb_url)));
            if ($ext != 'JPG' && $ext != 'PNG') {
                $this->addError('thumb_url', 'Please add jpg or png image for Thumbnail Image.');
            }
        }
    }

    public function validateImageUrl() {
        if (!empty($this->image_url)) {
            $ext = strtoupper(end(explode(".", $this->image_url)));
            if ($ext != 'JPG' && $ext != 'PNG') {
                $this->addError('image_url', 'Please add jpg or png image for Large Image.');
            }
        }
    }

    public function validateMapUrl() {
        if ($this->in_airport == 1) {
            if (empty($this->map_url)) {
                $this->addError('map_url', 'Terminal map cannot be blank.');
            } else {
                $ext = strtoupper(end(explode(".", $this->map_url)));
                if ($ext != 'JPG' && $ext != 'PNG') {
                    $this->addError('map_url', 'Please add jpg or png image for Terminal map.');
                }
            }
        }
    }

    public function validateQrCodeImageName() {
        if (!empty($this->qr_code_image_name)) {
            $ext = strtoupper(end(explode(".", $this->qr_code_image_name)));
            if ($ext != 'JPG' && $ext != 'PNG') {
                $this->addError('qr_code_image_name', 'Please add jpg or png image for QR Image.');
            }
        }
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'concourses' => array(self::HAS_MANY, 'Concourse', 'advertisement_id'),
            'concourseAdvertisement' => array(self::HAS_MANY, 'ConcourseAdvertisement', 'advertisement_id'),
            'subCategory' => array(self::BELONGS_TO, 'SubCategory', 'sub_category_id'),
            'categoryHasSubCategories' => array(self::HAS_MANY, 'CategoryHasSubCategory', 'advertisement_id'),
            'vendor' => array(self::BELONGS_TO, 'Vendor', 'vendor_id'),
            'locationAdvertisement' => array(self::HAS_MANY, 'LocationAdvertisement', 'advertisement_id'),
            'user' => array(self::BELONGS_TO, 'User', 'created_by'),
            'analytics' => array(self::HAS_MANY, 'Analytic', 'advertisement_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'created_date' => 'Created Date',
            'exp_date' => 'Expiration Date:',
            'offer_title' => 'Offer Title:',
            'offer_desc' => 'Offer Description:',
            'terms' => 'Terms',
            'image_url' => 'Large Image Url:',
            'thumb_url' => 'Thumbnail Image Url:',
            'in_airport' => 'In Airport',
            'n_loc' => 'N Loc',
            'gate' => 'Gate',
            'vendor_id' => 'Vendor Name:',
            'sub_category_id' => 'Sub Category',
            'qr_code' => 'Qr Code',
            'map_url' => 'Map Url',
            'atrium' => 'Atrium',
            'created_by' => 'Created By:',
            'status' => 'Status:',
            'store_name' => 'Store Name:',
            'tag_line' => 'Tag Line:',
            'qr_code_image_name' => 'Qr Code Image Name',
            'store_phone' => 'Store Phone:',
            'terminal_map' => 'Terminal Map',
            'store_address' => 'Store Address',
            'concourse' => 'Concourse',
            'updated_date' => 'Updated Date',
            'fb_url' => 'Fb URL:',
            'twitter' => 'Twitter URL:',
            'url' => 'Website URL:',
            'address2' => 'Address2',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'is_featured' => 'Advertisement Type:',
            'sequence' => 'Sequence',
        	'promo_text' => 'Promo Text',
            'category_id' => 'Category:'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $sort = new CSort();
        $sort->attributes = array('id' => array('asc' => 't.id', 'desc' => 't.id desc',), 'AdvertisementName' => array('asc' => 'offer_title', 'desc' => 'offer_title desc',),
            'store_name' => array('asc' => 'store_name', 'desc' => 'store_name desc',),
            'exp_date' => array('asc' => 'exp_date', 'desc' => 'exp_date desc',),
            'status' => array('asc' => 't.status', 'desc' => 't.status desc',),
            'CreatedBy' => array('asc' => 'user.name', 'desc' => 'user.name desc',),
            'Vendor' => array('asc' => 'vendor.description', 'desc' => 'vendor.description desc',),
        );

        $criteria = new CDbCriteria;
        $criteria->with = array('vendor', 'user');
        if (!empty($this->subCategoryIdsAr) && is_array($this->subCategoryIdsAr)) {
            foreach ($this->subCategoryIdsAr as $subcategoryId) {

                $criteria->compare('sub_category_id', $subcategoryId->id, true, 'OR');
            }
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.created_date', $this->created_date, true);
        $criteria->compare('t.offer_title', $this->offer_title, true);
        $criteria->compare('t.is_featured', $this->is_featured, true);
        $criteria->compare('t.category_id', $this->category_id, true);
        $criteria->compare('user.id', $this->created_by, true);
        $criteria->compare('t.status', $this->status, FALSE);
        $criteria->compare('t.store_name', $this->store_name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    //all vendors list
    public function getVendorList() {

        $models = Vendor::model()->findAll(
                array('order' => 'description'));

        $list = CHtml::listData($models, 'id', 'description');
        return $list;
    }

    public function getFeatuedList() {
        $featured = array(Advertisement::NORMAL_FEATURED_ADD => 'Normal', Advertisement::CATEGORY_FEATURED_ADD => 'Category Featured', Advertisement::SUB_CATEGORY_FEATURED_ADD => 'Sub Category Featured');
        return $featured;
    }

    public function getAdvertisementName($add_id = null) {
        $addName = Advertisement::model()->findByPk($add_id);
        return $addName->offer_title;
    }

    public function getAdvertisementByCategory($categoryId = 'NULL') {
        $sort = new CSort();
        $sort->attributes = array('id' => array('asc' => 't.id', 'desc' => 't.id desc',), 'AdvertisementName' => array('asc' => 'offer_title', 'desc' => 'offer_title desc',),
            'store_name' => array('asc' => 'store_name', 'desc' => 'store_name desc',),
            'exp_date' => array('asc' => 'exp_date', 'desc' => 'exp_date desc',),
            'status' => array('asc' => 't.status', 'desc' => 't.status desc',),
            'CreatedBy' => array('asc' => 'user.name', 'desc' => 'user.name desc',),
//            'Vendor' => array('asc' => 'vendor.description', 'desc' => 'vendor.description desc',),
        );
        $dataProvider = new CActiveDataProvider('Advertisement', array(
            'criteria' => array(
                //   'with' => array('categoryHasSubCategories'),
                'condition' => 'category_id=:id and t.is_featured = 1 and t.status=:st and t.exp_date >= :ex_date',
                'params' => array(":id" => $categoryId, ":st" => 'Active', ":ex_date" => date('Y-m-d'))
            ),
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => 24,
            ),
        ));

        return $dataProvider;
    }

    public static function getRowNumber() {

        return Advertisement::$rowCount += 1;
    }

    public function getAdvertisementSequence($categoryId = 'NULL') {
        // print_r(date('Y-m-d'));exit;
        $criteria = new CDbCriteria;
        $criteria->condition = 'category_id=:id and is_featured = 1 and status=:st and exp_date >= :ex_date';
        $criteria->params = array(":id" => $categoryId, ":st" => 'Active', ":ex_date" => date('Y-m-d'));

        $criteria->order = 'sequence';
        $couponSquence = $this->findAll($criteria);
        return $couponSquence;
    }

    public function searchInactive() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $sort = new CSort();
        $sort->attributes = array('AdvertisementName' => array('asc' => 'offer_title', 'desc' => 'offer_title desc',),
            'location' => array('asc' => 'location', 'desc' => 'location desc',),
            'exp_date' => array('asc' => 'exp_date', 'desc' => 'exp_date desc',),
            'city' => array('asc' => 'city', 'desc' => 'city desc',),
            'updated_date' => array('asc' => 'updated_date', 'desc' => 'updated_date desc',),
            'Vendor' => array('asc' => 'v.description', 'desc' => 'v.description desc',),
        );

        $criteria = new CDbCriteria;
        //$criteria->with = array('vendor');
        $criteria->select = "t.id, v.description,offer_title, exp_date, t.city, (CASE (in_airport) WHEN 1 THEN CONCAT(concourse, ' ',gate) ELSE store_address END) AS location, updated_date";
        $criteria->join = "INNER JOIN vendor v ON v.id = t.vendor_id";
        $criteria->order = "updated_date desc";
        $criteria->compare('t.status', 'Inactive', true);
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

}
