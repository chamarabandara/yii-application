<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'analytic-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>
		<?php echo $form->textArea($model,'timestamp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'page'); ?>
		<?php echo $form->textField($model,'page',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'page'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subcategory_id'); ?>
		<?php echo $form->textField($model,'subcategory_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'subcategory_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_id'); ?>
		<?php echo $form->textField($model,'coupon_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'coupon_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'favorite'); ?>
		<?php echo $form->textField($model,'favorite'); ?>
		<?php echo $form->error($model,'favorite'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'device_id'); ?>
		<?php echo $form->textField($model,'device_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'device_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'client_timestamp'); ?>
		<?php echo $form->textArea($model,'client_timestamp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'client_timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'client_id'); ?>
		<?php echo $form->textField($model,'client_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'client_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'version'); ?>
		<?php echo $form->textField($model,'version',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'version'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'banner_id'); ?>
		<?php echo $form->textField($model,'banner_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'banner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ecard_id'); ?>
		<?php echo $form->textField($model,'ecard_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'ecard_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'redeemed'); ?>
		<?php echo $form->textField($model,'redeemed'); ?>
		<?php echo $form->error($model,'redeemed'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->