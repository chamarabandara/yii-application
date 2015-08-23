<?php

/**
 * This is the model class for table "url".
 *
 * The followings are the available columns in table 'url':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $status
 */
class Url extends AppModel {

    const MAX_RECORDS = 10;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Url the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'url';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, url, status', 'required'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('url', 'length', 'max' => 128),
            array('url', 'url'),
            array('url', 'unique', 'criteria' => array('condition' => 'status != :status', 'params' => array(':status' => 0))),
            array('status', 'length', 'max' => 2),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, url, created_date, created_by, updated_date, updated_by, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name:',
            'url' => 'Url:',
            'created_date' => 'Created Date:',
            'created_by' => 'Created By:',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'status' => 'Status:',
        );
    }

    public function beforeSave() {
        if ($this->getIsNewRecord()) {
            $this->created_by = Yii::app()->user->getState('loggedUserId');
            $this->created_date = date('Y-m-d H:i:s');
        }

        $this->updated_by = Yii::app()->user->getState('loggedUserId');
        $this->updated_date = date('Y-m-d H:i:s');
        return parent::beforeSave();
    }

    // To return the status in wording. i.e 'active'
    public static function getStatus($status) {
        $display = '';
        switch ($status) {
            case 0:
                $display = 'Deleted';
                break;
            case 1:
                $display = 'Active';
                break;
            case 2:
                $display = 'Inactive';
                break;
            default:
                break;
        }
        return $display;
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('status', $this->status, true);
        $criteria->addCondition('t.status != 0');// status 0:deleted, 1:active, 2:inactive 
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getURLStatus() {
        //get status for the URL
        $statusList = array(
            array('id' => '1', 'name' => 'Active'),
            array('id' => '2', 'name' => 'Inactive')
        );

        return CHtml::listData($statusList, 'id', 'name');
    }

}