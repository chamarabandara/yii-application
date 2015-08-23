<?php
$this->breadcrumbs=array(
	'Analytics'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Analytic', 'url'=>array('index')),
	array('label'=>'Manage Analytic', 'url'=>array('admin')),
);
?>

<h1>Create Analytic</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>