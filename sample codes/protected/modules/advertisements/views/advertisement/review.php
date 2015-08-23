
<div class="tab-border-inner">	
    <div class="float-left tab-left-top-corner-inner ver-bg"></div>
    <div class="tab-top-bdr-inner hor-bg"></div>
    <div class="float-right tab-right-top-corner-inner static-bg"></div>
    <div class="clear-both"></div>
    <div class="tab-border tab-border-paddin-bottom-0">
      
       
            <?php
                            $this->beginWidget('ActiveForm', array(
                                'id' => 'advertisement-review',
                                'enableAjaxValidation' => FALSE,
                                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                            ));
                            ?>  
                <div>
                    <div class="row">
                                    <div><?php if (Yii::app()->user->hasFlash('error')) : ?>
                                            <div class="errorSummary errorSummary-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
                                        <?php elseif (Yii::app()->user->hasFlash('success')) : ?>
                                            <div class="success-msg errorSummary-ok"><?php echo Yii::app()->user->getFlash('success'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                    <div class="grid-title">
                        <div class="inner-bdr"> <span class="float-left bold-text">Advertisement List</span>

                            <div class="clear-both"></div>
                        </div>
                        <div class="grid-bg">
                         <div class="grid-bg-inner-bdr">

                                            <?php echo $this->renderPartial('reviewGrid', array('advertisement' => $advertisement)); ?>

                                        </div>

                        </div> 
                    </div>
                     <div class="">
                                <?php echo CHtml::submitButton('Approve Selected', array('id' => 'btnApproveSelected', 'class' => 'btn hor-bg btn-margin', 'name' => 'ApproveSelected')); ?>
                                <?php echo CHtml::submitButton('Delete Selected', array('id' => 'btnDeleteSelected', 'class' => 'btn hor-bg btn-margin', 'name' => 'DeleteSelected')); ?>
                                <input type="button" onclick="goTo('<?php echo Yii::app()->params['hostname'] . '/index.php/advertisements/advertisement/index' ?>')" value="Back" class="btn hor-bg btn-margin">
                            </div>
                            <?php $this->endWidget(); ?>  
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