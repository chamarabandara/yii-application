<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property integer $role_id
 * @property string $name
 * @property string $email
 */
class User extends CActiveRecord {

    public $confPassword;
    public $oldPassword;
    public $name;
    public $role;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, username,email, password, confPassword,role_id', 'required'),
            array('role_id', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 20),
            array('password', 'length', 'max' => 32),
            array('name', 'length', 'max' => 25),
            array('email', 'length', 'max' => 50),
            array('username', 'usernameExists'),
            array('email', 'emailExists'),
            array('password', 'compare', 'compareAttribute' => 'confPassword', 'message' => 'Confirm password need to be matched with password.'), // here you say that the password must be the same as conf_password
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, role_id, confPassword, name, email', 'safe'),
            array('id, username, password, role_id, confPassword, name, email', 'safe', 'on' => 'search'),
        );
    }

    public function usernameExists($attribute, $params) {
        $message = strtr('{attribute} already exists.', array('{attribute}' => $this->getAttributeLabel($attribute),));
        if (isset($this->id) && $this->id > 0) {
            if (User::model()->exists('username=:username and id<>:id', array('username' => $this->username, 'id' => $this->id))) {
                $this->addError($attribute, $message);
                return false;
            }
        } else if ($this->username !== null) {
            if (User::model()->count('username=' . "'$this->username'") > 0) {
                $this->addError($attribute, $message);
                return false;
            }
        }
    }

    public function emailExists($attribute, $params) {
        $message = strtr('{attribute} already exists.', array('{attribute}' => $this->getAttributeLabel($attribute),));
        if (isset($this->id) && $this->id > 0) {
            if (User::model()->exists('email=:email and id<>:id', array('email' => $this->email, 'id' => $this->id))) {
                $this->addError($attribute, $message);
                return false;
            }
        } else if ($this->email !== null) {
            if (User::model()->count('email=' . "'$this->email'") > 0) {
                $this->addError($attribute, $message);
                return false;
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'User Name:',
            'password' => 'Password:',
            'role_id' => 'User Role:',
            'name' => 'Name:',
            'email' => 'Email:',
            'confPassword' => 'Confirm Password:',
            'name'=>'Name:'
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
        $criteria->select = 't.id,t.username,r.role,t.name,t.email';
        $criteria->join = 'INNER JOIN user_role r ON t.role_id=r.id';
        $criteria->order = 't.name ASC';

        $criteria->compare('id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
         return $this->password = md5($this->password);
      
    }

    public static function getName($id) {
        return self::model()->findByPk($id)->name;
    }

}