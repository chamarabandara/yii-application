<!--
Peachtree 
Users Create view
@author Chamara Bandara
@copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd

-->


<div class="tab-border-inner">	
    
    <div class="clear-both"></div>
    
        <?php
        if (empty($users->id)) {
            echo '<div class="page-title">Create New User</div>';
        } else {
            echo '<div class="page-title">Edit User</div>';
        }
        if (Yii::app()->user->hasFlash('success')):
            ?>
            <div class="success-msg errorSummary-ok">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php endif; ?>

        <?php
        $form = $this->beginWidget('ActiveForm', array(
            'id' => 'user-create-form',
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="row container-1">
            <div class="inner-frame">
                <?php echo $form->errorSummary($users,'','',array('class'=>'errorSummary-error')); ?>
                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($users, 'name', array('class' => 'bold-text')); ?>
                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($users, 'name', array('class' => 'col-12')); ?>
                    </div>

                </div> 

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($users, 'username', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($users, 'username', array('class' => 'col-12')); ?>      
                    </div>

                </div> 

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($users, 'email', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($users, 'email', array('class' => 'col-12')); ?>

                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($users, 'password', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->passwordField($users, 'password', array('class' => 'col-12')); ?>

                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($users, 'confPassword', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->passwordField($users, 'confPassword', array('class' => 'col-12')); ?>

                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($users, 'role_id', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->dropDownList($users, 'role_id', UserRole::model()->getRoleList(), array('empty' => '- - Select - -'), array('class' => 'col-12')); ?>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="">
            <?php echo CHtml::submitButton('Save', array('id' => 'save_btn', 'class' => 'btn hor-bg', 'name' => 'Save')); ?>
            <?php
            if (!empty($users->id)) {
                echo CHtml::submitButton('Delete', array('id' => 'delete_btn', 'class' => 'btn hor-bg', 'name' => 'Delete'));
            }
            ?>
            <?php echo CHtml::submitButton('Cancel', array('id' => 'cancel_btn', 'class' => 'btn hor-bg', 'name' => 'Cancel')); ?>
        </div>

    
    <div class="clear-both"></div>
    
</div>
<?php $this->endWidget(); ?>      