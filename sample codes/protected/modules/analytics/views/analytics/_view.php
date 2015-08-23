<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('logid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->logid), array('view', 'id'=>$data->logid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('page')); ?>:</b>
	<?php echo CHtml::encode($data->page); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subcategory_id')); ?>:</b>
	<?php echo CHtml::encode($data->subcategory_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coupon_id')); ?>:</b>
	<?php echo CHtml::encode($data->coupon_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('favorite')); ?>:</b>
	<?php echo CHtml::encode($data->favorite); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('device_id')); ?>:</b>
	<?php echo CHtml::encode($data->device_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->client_timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_id')); ?>:</b>
	<?php echo CHtml::encode($data->client_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('version')); ?>:</b>
	<?php echo CHtml::encode($data->version); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('banner_id')); ?>:</b>
	<?php echo CHtml::encode($data->banner_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ecard_id')); ?>:</b>
	<?php echo CHtml::encode($data->ecard_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('redeemed')); ?>:</b>
	<?php echo CHtml::encode($data->redeemed); ?>
	<br />

	*/ ?>

</div>