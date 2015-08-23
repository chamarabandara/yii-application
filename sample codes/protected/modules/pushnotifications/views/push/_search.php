<!--
Peachtree 
search view
@author Chamara Bandara
@copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd

-->

<div class="row-form container-1">
    <div class="inner-frame">
        <div class="row-form">
            <div class="col-12">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'post',
                ));

                ?>
                <div class="col-5">
                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($push, 'created_date', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">
                            <?php
                    
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'PushNotification[created_date]',
                                'model' => $push,
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'yy-mm-dd',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'col-12',
                                ),
                            ));
                        
                            ?>
                        </div>
                    </div>



                </div>
                <div class="col-5">


                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($push, 'mobile_type', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">

                            <?php echo $form->dropDownList($push, 'mobile_type', array('1' => 'iPhone', '2' => 'Android', '3' => 'Both'), array('class' => 'col-12')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row buttons">
    <?php echo CHtml::submitButton('Search', array('class' => 'btn hor-bg')); ?>
    <?php echo CHtml::submitButton('Clear Search Fields', array('id' => 'form-reset-button', 'class' => 'btn hor-bg')); ?>
</div>

<?php $this->endWidget(); ?>
