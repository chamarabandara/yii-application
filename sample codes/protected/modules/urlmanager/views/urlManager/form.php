
<!--
Peachtree 
Vendor Create view
@author Chamara Bandara
@copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd.
-->


<div class="tab-border-inner">	
    
    <div class="clear-both"></div>
    
        <?php
        $form = $this->beginWidget('ActiveForm', array(
            'id' => 'url-create-form',
            'enableAjaxValidation' => false,
        ));
        ?> <?php
        if (empty($model->id)) {
            echo '<div class="page-title">Create New Url</div>';
        } else {
            echo '<div class="page-title">Edit Url</div>';
        }
        ?>
        <?php if (Yii::app()->user->hasFlash('success')): ?>
            <div class="success-msg errorSummary-ok">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php endif; ?>
        <div class="row container-1">
            <div class="inner-frame">
                <?php echo $form->errorSummary($model,'','',array('class'=>'errorSummary-error')); ?>
                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'bold-text')); ?>
                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'name', array('class' => 'col-12')); ?>
                    </div>

                </div> 

                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'url', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->textField($model, 'url', array('class' => 'col-12')); ?>      
                    </div>

                </div> 


                <div class="row-form">

                    <div class="col-3">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'bold-text')); ?>

                    </div>
                    <div class="col-4">

                        <?php echo $form->dropDownList($model, 'status', Url::model()->getURLStatus()); ?>

                    </div>
                </div>
            </div>
        </div>
       
        <div class="">
            <?php
            echo CHtml::submitButton('Save', array('id' => 'save_btn', 'class' => 'btn hor-bg', 'name' => 'Save'));
            ?>
            <?php
            if (!empty($model->id))
                echo CHtml::submitButton('Delete', array('id' => 'delete_btn', 'class' => 'btn hor-bg', 'name' => 'Delete'));
            ?>
            <?php echo CHtml::submitButton('Cancel', array('id' => 'cancel_btn', 'class' => 'btn hor-bg', 'name' => 'Cancel')); ?>
        </div>


   
    <div class="clear-both"></div>
    
    <div class="clear-both"></div>
</div>
<?php $this->endWidget(); ?>      