<?php

Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/admin/login/login.css');

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<div class="form">
    <?php
    $form = $this->beginWidget('ActiveForm', array(
        'id' => 'login-form',
        //'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>

    <div class="row-form">
    		<div class="col-3">
        	<label class="bold-text  float-left"><?php echo $form->labelEx($model, 'username'); ?></label>
        </div>
        <div class="col-8">
        	<?php echo $form->textField($model, 'username', array('class' => 'input-block-level col-12', 'placeholder' => ($model->haserrors()) ? 'Username can not be blank' : '')); ?>
				</div>
    </div>

    <div class="row-form">
    		<div class="col-3">
        <label class="bold-text  float-left"><?php echo $form->labelEx($model, 'password'); ?></label>
        </div>
        <div class="col-8">
        <?php echo $form->passwordField($model, 'password', array('class' => 'input-block-level col-12', 'placeholder' => ($model->haserrors()) ? 'Password can not be blank' : '')); ?>
        </div>

    </div>

    <div class="row-form">
    		<div class="col-7">
          <div class="float-left"><?php echo $form->checkBox($model, 'rememberMe'); ?>
              <?php echo $form->label($model, 'rememberMe'); ?>
  
          </div>
        </div>
        <div class="col-4">
          <div class="float-right"><?php echo CHtml::submitButton('Login', array('class' => 'hor-bg')); ?></div><div class="clear-both"></div>
        </div>
     </div>
     <div class="row-form">
        <div class="col-12">
          <div class="row forgotpsw"><a href="<?php echo Yii::app()->controller->createUrl('admin/ForgotPassword') ?>">Forgot password</a>
  
              <?php if ($model->haserrors() && !empty($model->username) && !empty($model->password)) { ?>
                  <span style="color: red;float: right;"><?php echo 'Invalid Username or Password'; ?></span>
              <?php } ?>
  
          </div>
        </div>
    	</div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
