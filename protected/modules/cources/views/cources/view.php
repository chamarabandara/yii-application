<?php
/* @var $this CourcesController */
/* @var $model Cources */

$this->breadcrumbs=array(
	'Cources'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Cources', 'url'=>array('index')),
	array('label'=>'Create Cources', 'url'=>array('create')),
	array('label'=>'Update Cources', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cources', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cources', 'url'=>array('admin')),
);
?>

<h1>View Cources #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'create_by',
		'price',
	),
)); ?>
