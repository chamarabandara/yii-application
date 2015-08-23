<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $name
 * @property integer $featured_coupon
 * @property integer $featured_coupon_nearby
 *
 * The followings are the available model relations:
 * @property SubCategory[] $subCategories
 */
class Category extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Category the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('featured_advertisement, featured_advertisement_nearby', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, featured_advertisement, featured_advertisement_nearby', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'advertisements' => array(self::HAS_MANY, 'Advertisement', 'category_id'),
            'analytics' => array(self::HAS_MANY, 'Analytic', 'category_id'),
            'subCategories' => array(self::HAS_MANY, 'SubCategory', 'category_id'),
            'categoryHasSubCategories' => array(self::HAS_MANY, 'CategoryHasSubCategory', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'featured_advertisement' => 'Featured Advertisement',
            'featured_advertisement_nearby' => 'Featured Advertisement Nearby',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('featured_advertisement', $this->featured_advertisement, true);
        $criteria->compare('featured_advertisement_nearby', $this->featured_advertisement_nearby, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public function getCategoryName($categoryId) {
        $model = Category::model()->findByPk($categoryId);
        if (null != $model) {
            return $model->name;
        }
        return "";
    }

    public function getCategoryList() {
        //set status for the URL
        $list = Category::model()->findAll();
        return CHtml::listData($list, 'id', 'name');
    }

}