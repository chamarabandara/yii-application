<?php
/* @var $this CourcesController */
/* @var $model Cources */

$this->breadcrumbs=array(
	'Cources'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cources', 'url'=>array('index')),
	array('label'=>'Create Cources', 'url'=>array('create')),
	array('label'=>'View Cources', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cources', 'url'=>array('admin')),
);
?>

<h1>Update Cources <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>