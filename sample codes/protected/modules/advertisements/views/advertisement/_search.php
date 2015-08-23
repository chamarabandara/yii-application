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
                    'id' => 'search-form',
                    'enableAjaxValidation' => true,
                   // 'enableClientValidation' => true,
                ));
                ?>
            <div class="col-5">
                <div class="row-form search-row-form">
                    <div class="col-5">
                          <?php echo $form->label($model, 'offer_title', array('class' => 'bold-text col-12')); ?>
                    </div>
                    <div class="col-5">
                         <?php echo $form->textField($model, 'offer_title', array('class'=>'col-12')); ?>
                    </div>
                </div>
                  <div class="row-form">
                    <div class="col-5">
                         <?php echo $form->label($model, 'category_id', array('class' => 'bold-text col-12')); ?>
                    </div>
                    <div class="col-5">
                        <?php echo $form->dropDownList($model, 'category_id', Category::model()->getCategoryList(), array('class'=>'col-12','empty' => '- - Select - -')); ?>
                    </div>
                </div>
                  <div class="row-form">
                    <div class="col-5">
                          <?php echo $form->label($model, 'is_featured', array('class' => 'bold-text col-12')); ?>
                    </div>
                    <div class="col-5">
                         <?php echo $form->dropDownList($model, 'is_featured', Advertisement::model()->getFeatuedList(), array('class'=>'col-12','empty' => '- - Select - -')); ?>

                    </div>
                </div>

            </div>
             <div class="col-5">

                   <div class="row-form">
                    <div class="col-5">
                          <?php echo $form->label($model, 'status', array('class' => 'bold-text col-12')); ?>
                    </div>
                    <div class="col-5">
                          <?php echo $form->dropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive'), array('class'=>'col-12','empty' => '- - Select - -')); ?>

                    </div>
                </div>
                  <div class="row-form">
                    <div class="col-5">
                          <?php echo $form->label($model, 'created_by', array('class' => 'bold-text col-12')); ?>
                    </div>
                    <div class="col-5">
                        <?php echo $form->dropDownList($model, 'created_by', CHtml::listData($users, 'id', 'name'), array('class'=>'col-12','empty' => '- - Select - -')); ?>
                    </div>
                </div>
                  <div class="row-form search-row-form">
                    <div class="col-5">
                           <?php echo $form->label($model, 'store_name', array('class' => 'bold-text col-12')); ?>
                    </div>
                    <div class="col-5">
                            <?php echo $form->textField($model, 'store_name', array('class'=>'col-12')); ?>
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


<!-- search-form -->