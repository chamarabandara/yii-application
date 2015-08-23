<?php

/**
 * This is the model class for table "vendor".
 *
 * The followings are the available columns in table 'vendor':
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $description
 * @property string $fb_url
 * @property string $phone
 * @property string $twitter
 * @property string $url
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Advertisement[] $Advertisement
 */
class Vendor extends AppModel {

    public $vendorName;

    /**
     * Returns the static model of the specified AR class.
     * @return Vendor the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'vendor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('description, status', 'required'),
            array('first_name, last_name', 'length', 'max' => 32),
            array('description', 'length', 'max' => 1024),
            array('fb_url, twitter, url, contact_person', 'length', 'max' => 128),
            array('phone', 'length', 'max' => 64),
            array('phone', 'match', 'pattern' => '/^[0-9]{1}-[0-9]{3}-[0-9]{3}-[0-9]{4}$/'),
            array('address, email', 'length', 'max' => 256),
            array('address2', 'length', 'max' => 400),
            array('city, state', 'length', 'max' => 30),
            array('zip', 'length', 'max' => 50),
            array('created_date,status, created_by, comments', 'safe'),
            array('email', 'email'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, first_name, last_name, description, fb_url, phone, twitter, url, address, address2, city, state, zip, comments, email, contact_person', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'advertisements' => array(self::HAS_MANY, 'Advertisement', 'vendor_id'),
            'user' => array(self::BELONGS_TO, 'User', 'created_by')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'description' => 'Vendor Name:',
            'fb_url' => 'Fb Url',
            'phone' => 'Telephone No:',
            'twitter' => 'Twitter',
            'url' => 'Url',
            'address' => 'Address 1:',
            'comments' => 'Comments',
            'address2' => 'Address 2:',
            'city' => 'City:',
            'state' => 'State:',
            'zip' => 'Zip:',
            'contact_person' => 'Contact Person:',
            'email' => 'Email:',
            'status' => 'Status:',
            'created_by' => 'Created By:',
            'created_date' => 'Created Date:',
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
        $sort->attributes = array('VendorName' => array('asc' => 'description', 'desc' => 'description desc',),
            'user.name' => array('asc' => 'user.name', 'desc' => 'user.name',),
            'created_date' => array('asc' => 'created_date', 'desc' => 'created_date'),
            'status' => array('asc' => 'status', 'desc' => 'status')
        );
        $criteria = new CDbCriteria;
        $criteria->with = array('user');
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('status', $this->status, true);
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    public function getVendorStatus() {
        //set status for the URL
        $statusList = array(
            array('id' => '1', 'name' => 'Active'),
            array('id' => '0', 'name' => 'Inactive')
        );

        return CHtml::listData($statusList, 'id', 'name');
    }

}