<?php

Yii::import('application.modules.advertisements.models.Advertisement');

/**
 * This is the model class for table "analytic".
 *
 * The followings are the available columns in table 'analytic':
 * @property integer $id
 * @property string $timestamp
 * @property string $page
 * @property string $category_id
 * @property string $subcategory_id
 * @property string $coupon_id
 * @property integer $favorite
 * @property string $device_id
 * @property string $client_timestamp
 * @property string $client_id
 * @property string $version
 * @property string $banner_id
 * @property string $ecard_id
 * @property integer $redeemed
 */
class Analytic extends CActiveRecord {

    public $startDate = '';
    public $endDate = '';
    public $advertisementTitle = '';
    public $advertisement_id;
    /**
     * Returns the static model of the specified AR class.
     * @return Analytic the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'analytic';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('favorite, redeemed', 'numerical', 'integerOnly' => true),
            array('page', 'length', 'max' => 100),
            array('category_id, subcategory_id, advertisement_id, device_id, client_id, version, banner_id, ecard_id', 'length', 'max' => 45),
            array('timestamp, client_timestamp, startDate, endDate, advertisement_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, timestamp, page, category_id, subcategory_id, advertisement_id, favorite, device_id, client_timestamp, client_id, version, banner_id, ecard_id, redeemed', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'subcategory' => array(self::BELONGS_TO, 'SubCategory', 'subcategory_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'advertisement' => array(self::BELONGS_TO, 'Advertisement', 'advertisement_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'timestamp' => 'Timestamp',
            'page' => 'Page',
            'category_id' => 'Category',
            'subcategory_id' => 'Subcategory',
            'advertisement_id' => 'Advertisement ID:',
            'favorite' => 'Favorite',
            'device_id' => 'Device',
            'client_timestamp' => 'Client Timestamp',
            'client_id' => 'Client',
            'version' => 'Version',
            'banner_id' => 'Banner',
            'ecard_id' => 'Ecard',
            'redeemed' => 'Redeemed',
            'advertisementTitle' => 'Advertisement Title:',
            'startDate' => 'Start Date:',
            'endDate' => 'End Date:',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('timestamp', $this->timestamp, true);
        $criteria->compare('page', $this->page, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('subcategory_id', $this->subcategory_id, true);
        $criteria->compare('advertisement_id', $this->advertisement_id, true);
        $criteria->compare('favorite', $this->favorite);
        $criteria->compare('device_id', $this->device_id, true);
        $criteria->compare('client_timestamp', $this->client_timestamp, true);
        $criteria->compare('client_id', $this->client_id, true);
        $criteria->compare('version', $this->version, true);
        $criteria->compare('banner_id', $this->banner_id, true);
        $criteria->compare('ecard_id', $this->ecard_id, true);
        $criteria->compare('redeemed', $this->redeemed);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

//analytics filter function (filter by date range, advertisement id, advertisement tilte)
    public function getAnalyticsFlterDetails($startDate, $endDate, $addId, $AddTitle) {

        $criteria = new CDbCriteria;
        $criteria->with = "advertisement";
        $criteria->together = true;
        if (!empty($startDate) && !empty($endDate)) {
            $criteria->addCondition("from_unixtime(timestamp,'%Y-%m-%d') >= :stdate AND from_unixtime(timestamp,'%Y-%m-%d') <= :enddate");
            $criteria->params = array(':stdate' => $startDate, ':enddate' => $endDate);
        }
        if (!empty($AddTitle) && !is_null($AddTitle)) {
            $criteria->addCondition("advertisement.offer_title =:offtitle");
            $criteria->params = $criteria->params + array(':offtitle' => $AddTitle);
        }
        if (!empty($addId) && !is_null($addId)) {
            $criteria->addCondition("advertisement.id =:cpid");
            $criteria->params = $criteria->params + array(':cpid' => $addId);
        }

        if (!empty($startDate) || !empty($endDate) || !empty($AddTitle) || !empty($addId)) {

            $filteredData = Analytic::model()->findAll($criteria);
        } else {
            $filteredData = array();
        }


        return $filteredData;




        //$data = 2013-12-09
    }

}