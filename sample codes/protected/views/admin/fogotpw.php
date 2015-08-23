<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/admin/common.js');
?>
<div class="errormsg-pane"><?php if (Yii::app()->user->hasFlash('error')) : ?>
        <div class="errorSummary"><?php echo Yii::app()->user->getFlash('error'); ?></div>
    <?php elseif (Yii::app()->user->hasFlash('success')) : ?>
        <div class="success-msg"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php endif; ?>
    <?php echo CHtml::errorSummary($user); ?></div>
<div>
    <?php
    $form = $this->beginWidget('ActiveForm', array(
        'id' => 'Forgot Password',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="page-title">Forgot Password</div>
    <div class="row ">
        <div class="inner-frame">
            <table cellspacing="0" cellpadding="0" border="0" width="100%" class="tbl-form">
                <tbody>
                    <tr>
                        <td class="bold-text"> Email:</td>
                        <td><?php echo CHtml::activeTextField($user, 'email', array('class' => 'txt-common')); ?></td>
                    </tr>
                </tbody></table>

        </div>
    </div>
    <div class="">
        <?php echo CHtml::submitButton('Send', array('id' => 'save_btn', 'class' => 'btn hor-bg', 'name' => 'Send')); ?>
        <input type="button" onclick="goTo('login')" value="Back" class="btn hor-bg">
    </div>
   <?php $this->endWidget(); ?> 
</div>