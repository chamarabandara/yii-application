<!--
* Peachtree 
 * Vendor Create view
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */
-->


<div class="tab-border-inner">	
    
    <div class="clear-both"></div>
    
        <?php
        if (empty($model->id)) {
            echo '<div class="page-title">Create New Vendor</div>';
        } else {
            echo '<div class="page-title">Edit Vendor</div>';
        }
        ?>
        <?php if (Yii::app()->user->hasFlash('success')): ?>
            <div class="success-msg errorSummary-ok">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php endif; ?>

        <?php
        $form = $this->beginWidget('ActiveForm', array(
            'id' => 'vendor-vendor-form',
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="row container-1">
            <div class="inner-frame">
                <?php echo $form->errorSummary($model,'','',array('class'=>'errorSummary-error')); ?> 
                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'description', array('class' => 'bold-text')); ?>
                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'description', array('class' => 'col-12')); ?>
                    </div>

                </div> 

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'phone', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'phone', array('class' => 'col-12')); ?>      
                    </div>

                </div> 

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'address', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textArea($model, 'address', array('class' => 'txt-desc')); ?>

                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'address2', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textArea($model, 'address2', array('class' => 'txt-desc')); ?>

                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'city', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'city', array('class' => 'col-12')); ?>

                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'state', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'state', array('class' => 'col-12')); ?>

                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'zip', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'zip', array('class' => 'col-12')); ?>

                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'contact_person', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'contact_person', array('class' => 'col-12')); ?>

                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'email', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'email', array('class' => 'col-12')); ?>

                    </div>
                </div>


                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->dropDownList($model, 'status', Vendor::model()->getVendorStatus()); ?>

                    </div>
                </div>
            </div>
        </div>


        <div class="">
            <?php echo CHtml::submitButton('Save', array('id' => 'save_btn', 'class' => 'btn hor-bg', 'name' => 'Save')); ?>
            <?php
            if (!empty($model->id)) {
                echo CHtml::submitButton('Delete', array('id' => 'delete_btn', 'class' => 'btn hor-bg', 'name' => 'Delete'));
            }
            ?>
            <?php echo CHtml::submitButton('Cancel', array('id' => 'cancel_btn', 'class' => 'btn hor-bg', 'name' => 'Cancel')); ?>
        </div>

    
    
    <div class="clear-both"></div>
</div>
<?php $this->endWidget(); ?>      