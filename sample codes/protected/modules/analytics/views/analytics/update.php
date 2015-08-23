<?php
$this->breadcrumbs=array(
	'Analytics'=>array('index'),
	$model->logid=>array('view','id'=>$model->logid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Analytic', 'url'=>array('index')),
	array('label'=>'Create Analytic', 'url'=>array('create')),
	array('label'=>'View Analytic', 'url'=>array('view', 'id'=>$model->logid)),
	array('label'=>'Manage Analytic', 'url'=>array('admin')),
);
?>

<h1>Update Analytic <?php echo $model->logid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>