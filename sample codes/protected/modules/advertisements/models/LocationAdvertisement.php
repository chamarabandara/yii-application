
<?php

/**
 * This is the model class for table "location_advertisement".
 *
 * The followings are the available columns in table 'location_advertisement':
 * @property string $id
 * @property string $location_id
 * @property string $advertisement_id
 *
 * The followings are the available model relations:
 * @property Location $location
 * @property Advertisement $advertisement
 */
class LocationAdvertisement extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LocationAdvertisement the static model class
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
        return 'location_advertisement';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('location_id, advertisement_id', 'required'),
            array('location_id, advertisement_id', 'length', 'max'=>20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, location_id, advertisement_id', 'safe', 'on'=>'search'),
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
            'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
            'advertisement' => array(self::BELONGS_TO, 'Advertisement', 'advertisement_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'location_id' => 'Location',
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
        $criteria->compare('location_id',$this->location_id,true);
        $criteria->compare('advertisement_id',$this->advertisement_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}