<?php
$this->breadcrumbs=array(
	'Analytics'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Analytic', 'url'=>array('index')),
	array('label'=>'Create Analytic', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('analytic-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Analytics</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'analytic-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'logid',
		'timestamp',
		'page',
		'category_id',
		'subcategory_id',
		'coupon_id',
		/*
		'favorite',
		'device_id',
		'client_timestamp',
		'client_id',
		'version',
		'banner_id',
		'ecard_id',
		'redeemed',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
