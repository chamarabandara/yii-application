<!--
* Peachtree 
 * search view
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */
-->


<div class="row-form container-1">
    <div class="inner-frame">
        <div class="row-form">
            <div class="col-12">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'analytic-search-form',
                    'enableAjaxValidation' => true,
                  
                ));
                ?>
                <div class="col-5">
                    <div class="row-form date-row-form">
                        <div class="col-5">
                            <?php echo $form->label($analytic, 'startDate', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'Analytic[startDate]',
                                'model' => $analytic,
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'yy-mm-dd',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'clo-12'
                                ),
                            ));
                            ?>                            </div>
                    </div>
                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($analytic, 'advertisementTitle', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">

                            <?php echo $form->textField($analytic, 'advertisementTitle', array('class' => 'col-12')); ?>

                        </div>
                    </div>


                </div>
                <div class="col-5">
                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($analytic, 'endDate', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'Analytic[endDate]',
                                'model' => $analytic,
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

                    <div class="row-form">
                        <div class="col-5">
                            <?php echo $form->label($analytic, 'advertisement_id', array('class' => 'bold-text col-12')); ?>
                        </div>
                        <div class="col-5">

                            <?php echo $form->textField($analytic, 'advertisement_id', array('class' => 'col-12')); ?>

                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>
</div>




<div class="row buttons">
    <?php echo CHtml::submitButton('Search', array('class' => 'btn hor-bg', 'id' => 'analytics-search')); ?>
    <?php echo CHtml::hiddenField('hdnBaseUrl', Yii::app()->request->baseUrl . '/analytics/analytics/filterAnalytics'); ?>
</div>

<?php $this->endWidget(); ?>


<!-- search-form -->