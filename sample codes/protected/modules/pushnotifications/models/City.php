<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property string $id
 * @property string $country_id
 * @property string $name
 * @property integer $enabled
 */
class City extends AppModel {
   public $country;

   /**
    * Returns the static model of the specified AR class.
    * @return City the static model class
    */
   public static function model($className = __CLASS__) {
      return parent::model($className);
   }

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'city';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
          array('country_id, name', 'required'),
          array('name', 'checkUnique'),
          array('enabled', 'numerical', 'integerOnly'=>true),
          array('country_id', 'length', 'max'=>20),
          array('name, country', 'length', 'max'=>200),
          // The following rule is used by search().
          // Please remove those attributes that should not be searched.
          array('id, country_id, name, enabled', 'safe', 'on'=>'search'),
          array('id, country_id, name, enabled, created_date, updated_date', 'safe'),
      );
   }

   public function checkUnique() {
      if (!empty($this->name) && !empty($this->country_id) && $this->id == null) {
         $city = $this->model()->find('name = :name AND country_id = :country_id', array(':name'=>$this->name, ':country_id'=>$this->country_id));
         if ($city != null) {
            $this->addError($this->name, 'City \'' . '\' already exists under the selected Country');
         }
      }
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

   public function getCities() {
      $cities = City::model()->findAll('enabled = \'1\'');
      return $cities;
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
          'id'=>'ID',
          'country_id'=>'Country Name',
          'name'=>'City Name',
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
      $criteria->select = 't.id, t.country_id, c.name country, t.name, t.enabled';
      $criteria->join = 'INNER JOIN country c ON t.country_id = c.id';
      $criteria->order = 't.name ASC';
      $criteria->compare('c.name', $this->country, true);
      $criteria->compare('t.name', $this->name, true);
      $criteria->compare('t.enabled', $this->enabled);
      if (Yii::app()->user->checkAccess('corporate_user') || Yii::app()->user->checkAccess('super_admin')) {
         $user = User::model()->findByPk(Yii::app()->user->getId());
         $criteria->compare('t.country_id', $user->country_id, false);
      }

      return new CActiveDataProvider($this, array(
                  'criteria'=>$criteria,
              ));
   }
}