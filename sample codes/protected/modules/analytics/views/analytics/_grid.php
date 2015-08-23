<?php
//set page size for data provider
$dp = $analytic->search();
$dp->pagination->pageSize = 25;
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dp,
    'id'=>'analytics-id',
    'columns'=>array(
		array(
			'name'=>'timestamp',
			'value'=>'date("Y-m-d H:i:s", $data->timestamp)',
		),
		'page',
		array(
			'name'=>'category_id',
			'value'=>'Category::model()->getCategoryName($data->category_id);',
		),
		array(
			'name'=>'sub_category',
			'value'=>'SubCategory::model()->getCategoryName($data->category_id);',
		),
		array(
			'name'=>'coupon_id',
			'value'=>'Advertisement::model()->getAdvertisementName($data->coupon_id);',
		),
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
    ),
    'cssFile'=>false
));
?>

