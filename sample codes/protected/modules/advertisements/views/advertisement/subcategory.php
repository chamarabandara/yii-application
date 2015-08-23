<?php echo CHtml::activeDropDownList($coupons, 'sub_category_id', CHtml::listData($subCategories, 'id', 'name'), array( 
'options'=>array($noneAttr['id']=>array('selected'=>'selected')),'disabled' => $active ? 'disabled' : '')); ?>
