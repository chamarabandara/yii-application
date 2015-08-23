<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ActiveForm extends CActiveForm {

    public function init() {
        CHtml::$afterRequiredLabel = '';
        CHtml::$afterRequiredLabel = '<span class="required" style="color:red;">*</span> ';
        return parent::init();
    }

}

?>
