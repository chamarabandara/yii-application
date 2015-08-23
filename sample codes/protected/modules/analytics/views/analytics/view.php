<?php
$this->breadcrumbs=array(
	'Analytics'=>array('index'),
	$model->logid,
);

$this->menu=array(
	array('label'=>'List Analytic', 'url'=>array('index')),
	array('label'=>'Create Analytic', 'url'=>array('create')),
	array('label'=>'Update Analytic', 'url'=>array('update', 'id'=>$model->logid)),
	array('label'=>'Delete Analytic', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->logid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Analytic', 'url'=>array('admin')),
);
?>

<h1>View Analytic #<?php echo $model->logid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'logid',
		'timestamp',
		'page',
		'category_id',
		'subcategory_id',
		'coupon_id',
		'favorite',
		'device_id',
		'client_timestamp',
		'client_id',
		'version',
		'banner_id',
		'ecard_id',
		'redeemed',
	),
)); ?>
