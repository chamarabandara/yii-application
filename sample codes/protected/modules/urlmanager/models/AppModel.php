<?php

class AppModel extends CActiveRecord {
   protected $errorsArr; //errors array from model

   public static function newByPk($pk, $scenario='update') {
      $className = get_called_class();
      $model = new $className($scenario);
      $model->setIsNewRecord(false);
      $model->setPrimaryKey($pk);
      return $model;
   }

   public function getLastError() {
      $errorsArr = $this->getErrors();
      $this->errorsArr = $errorsArr;
      if (count($errorsArr) > 0) {
         $errors = array_values($errorsArr);

         return $errors[0][0];
      }
      return '';
   }

   /**
    * returns list of errors in a string
    * @param <string> $seperator
    * @return <string>
    */
   public function getErrorsList($seperator='<br/>') {
      $errorsArr = $this->getErrors();
      $errorsSingleAr = array();
      $errorsStr = '';
      if (count($errorsArr) > 0) {

         foreach ($errorsArr as $errAr) {
            $errorsSingleAr[] = $errAr[0];
         }
         $errorsStr = implode($seperator, $errorsSingleAr);
      }
      return $errorsStr;
   }

   /**
    * converts empty string values to proper null
    */
   public function afterValidate() {
      $attr = $this->getAttributes();

      foreach ($attr as $name=>$value) {
         $this->$name = trim($value);

         if ($this->$name === '')
            $this->$name = null;
      }
      return parent::afterValidate();
   }

   public function setStateAttributes() {
      $attrState = array();
      foreach ($this->getAttributes() as $key=>$value) {
         if (!empty($value))
            $attrState[$key] = $value;
      }
     
       Yii::app()->user->setState('searchFields',$attrState);
   }
}