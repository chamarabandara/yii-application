<?php
/* @var $this CourcesController */
/* @var $model Cources */

$this->breadcrumbs=array(
	'Cources'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cources', 'url'=>array('index')),
	array('label'=>'Manage Cources', 'url'=>array('admin')),
);
?>

<h1>Create Cources</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>