
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'updateprofile-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="tab-border-inner">	
    <div class="float-left tab-left-top-corner-inner ver-bg"></div>
    <div class="tab-top-bdr-inner hor-bg"></div>
    <div class="float-right tab-right-top-corner-inner static-bg"></div>
    <div class="clear-both"></div>
    <div class="tab-border">
       
        <div class="page-title">Edit Profile</div> 
       
         <?php if (Yii::app()->user->hasFlash('error')) : ?>
            <div class="errorSummary"><?php echo Yii::app()->user->getFlash('error'); ?></div>
        <?php elseif (Yii::app()->user->hasFlash('success')) : ?>
            <div class="success-msg"><?php echo Yii::app()->user->getFlash('success'); ?></div>
        <?php endif; ?>
            
        <?php echo CHtml::errorSummary($user); ?>
            
        <div class="row container-1">
            <div class="inner-frame">
                <div class="row-form">
                    <div class="col-3">
                        <label class="bold-text col-12">Email :</label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activeTextField($user, 'email', array('class' => 'col-12')); ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">
                    <div class="col-3">
                        <label class="bold-text col-12">Old Password :</label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activePasswordField($user, 'oldPassword', array('class' => 'txt-common')); ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">
                    <div class="col-3">
                        <label class="bold-text col-12">Password :</label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activePasswordField($user, 'password', array('class' => 'txt-common')); ?>                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">
                    <div class="col-3">
                        <label class="bold-text col-12">Confirm Password :</label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activePasswordField($user, 'confPassword', array('class' => 'col-12')); ?>                    </div>
                    <div class="col-4">
                    </div>
                </div>



            </div>
        </div>
        <div class="">
            <?php echo CHtml::submitButton('Save', array('id' => 'save_btn', 'class' => 'btn hor-bg', 'name' => 'Save')); ?>
            <?php echo CHtml::submitButton('Cancel', array('id' => 'cancel_btn', 'class' => 'btn hor-bg', 'name' => 'Cancel')); ?>

        </div>
    </div>
    <div class="clear-both"></div>
    <div>
        <div class="tab-bottom-corner-left static-bg float-left"></div>
        <div class="tab-bottom-corner-right static-bg float-right"></div>
        <div class="tab-bottom-bdr hor-bg"></div>
    </div>
    <div class="clear-both"></div>
</div>

<?php $this->endWidget(); ?>  