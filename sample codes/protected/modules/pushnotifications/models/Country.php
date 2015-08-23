<?php

/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
 * @property string $id
 * @property string $name
 * @property integer $enabled
 */
class Country extends AppModel {

   /**
    * Returns the static model of the specified AR class.
    * @return Country the static model class
    */
   public static function model($className = __CLASS__) {
      return parent::model($className);
   }

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'country';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
          array('name', 'required'),
          array('name', 'uniqueCheck'),
          array('enabled', 'numerical', 'integerOnly'=>true),
          array('name', 'length', 'max'=>200),
          // The following rule is used by search().
          // Please remove those attributes that should not be searched.
          array('id, name, enabled, country_code', 'safe', 'on'=>'search'),
          array('id, name, enabled, country_code, created_date, updated_date', 'safe'),
      );
   }

   public function uniqueCheck() {
      if (!empty($this->name)) {
         $country = $this->model()->find('name = :name', array(':name'=>$this->name));
         if ($country != null && $this->id == null) {
            $this->addError($this->name, 'Country \'' . $this->name . '\' already exists.');
         }
      }
   }
   
   public function getCountries() {
      if (Yii::app()->user->checkAccess('corporate_user')) {
         $coutries = Country::model()->findAll('enabled = \'1\' AND id = :id ORDER BY name', array(':id'=>Yii::app()->user->getState('countryId')));
      } else {
         $coutries = Country::model()->findAll('enabled = \'1\' ORDER BY name');
      }
      return $coutries;
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      // NOTE: you may need to adjust the relation name and the related
      // class name for the relations automatically generated below.
      return array(
          'coupons'=>array(self::HAS_MANY, 'Coupon', 'id'),
          'advertisements'=>array(self::HAS_MANY, 'Advertisement', 'id'),
      );
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
          'id'=>'ID',
          'name'=>'Country Name',
          'enabled'=>'Enabled',
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
      $criteria->order = 'name';
      $criteria->compare('id', $this->id, true);
      $criteria->compare('name', $this->name, true);
      $criteria->compare('enabled', $this->enabled);

      return new CActiveDataProvider($this, array(
                  'criteria'=>$criteria,
              ));
   }
}