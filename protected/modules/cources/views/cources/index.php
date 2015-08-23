<?php
/* @var $this CourcesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cources',
);

$this->menu=array(
	array('label'=>'Create Cources', 'url'=>array('create')),
	array('label'=>'Manage Cources', 'url'=>array('admin')),
);
?>

<h1>Cources</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
