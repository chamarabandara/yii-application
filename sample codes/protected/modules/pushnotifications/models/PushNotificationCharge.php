<?php

/**
 * This is the model class for table "push_notification_charge".
 *
 * The followings are the available columns in table 'push_notification_charge':
 * @property integer $id
 * @property string $created_at
 * @property integer $created_by
 * @property integer $is_vendor_logo
 * @property integer $is_monthly
 * @property double $charge
 */
class PushNotificationCharge extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PushNotificationCharge the static model class
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
		return 'push_notification_charge';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_at, created_by', 'required'),
			array('created_by, is_vendor_logo, is_monthly', 'numerical', 'integerOnly'=>true),
			array('charge', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created_at, created_by, is_vendor_logo, is_monthly, charge', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'is_vendor_logo' => 'Is Vendor Logo',
			'is_monthly' => 'Is Monthly',
			'charge' => 'Charge',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('is_vendor_logo',$this->is_vendor_logo);
		$criteria->compare('is_monthly',$this->is_monthly);
		$criteria->compare('charge',$this->charge);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}