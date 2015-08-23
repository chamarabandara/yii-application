<!--
* Peachtree 
 * search view
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */
-->

<!-- search-form -->
<div class="row-form container-1">
    <div class="inner-frame">
        <div class="row-form">
            <div class="col-12">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'post',
                    'id' => 'search-form',
                    'enableAjaxValidation' => true,
                ));
                ?>
                <div class="col-5">
                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($model, 'description', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">
                            <?php echo $form->textField($model, 'description', array('class' => 'col-12')); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($model, 'created_date', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'Vendor[created_date]',
                                'model' => $model,
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'yy-mm-dd',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'col-12'
                                ),
                            ));
                            ?>            
                        </div>
                    </div>


                </div>
                <div class="col-5">

                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($model, 'status', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">
                            <?php echo $form->dropDownList($model, 'status', Vendor::model()->getVendorStatus(), array('class' => 'col-12', 'empty' => '- - Select - -')); ?>

                        </div>
                    </div>
                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($model, 'created_by', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">
                            <?php echo $form->dropDownList($model, 'created_by', CHtml::listData($users, 'id', 'name'), array('class' => 'col-12', 'empty' => '- - Select - -')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row buttons">
    <?php echo CHtml::submitButton('Search', array('class' => 'btn hor-bg')); ?>
    <?php echo CHtml::button('Clear Search Fields', array('id' => 'update-grid-button', 'class' => 'btn hor-bg')); ?>
</div>

<?php $this->endWidget(); ?>
