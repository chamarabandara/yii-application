<?php

/**
 * This is the model class for table "concourse".
 *
 * The followings are the available columns in table 'concourse':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $advertisement_id
 *
 * The followings are the available model relations:
 * @property Advertisement $advertisement
 * @property ConcourseAdvertisement[] $concourseAdvertisements
 */
class Concourse extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Concourse the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'concourse';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('advertisement_id', 'required'),
            array('name', 'length', 'max'=>64),
            array('description', 'length', 'max'=>1024),
            array('advertisement_id', 'length', 'max'=>20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, advertisement_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'advertisement' => array(self::BELONGS_TO, 'Advertisement', 'advertisement_id'),
            'concourseAdvertisements' => array(self::HAS_MANY, 'ConcourseAdvertisement', 'concourse_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'advertisement_id' => 'Advertisement',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('advertisement_id',$this->advertisement_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}