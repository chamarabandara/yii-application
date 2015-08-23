<?php
//set page size for data provider
//Coupon::model()->findAll('status=:status', array(':status'=> 'Inactive')); 
$dp = $advertisement->searchInactive(); 
$dp->pagination->pageSize = 25;
$dd = true;
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dp,
    'columns'=>array( 
        array(
            'name'=>'',
            'type'=>'raw',
            'value'=>'CHtml::CheckBox("Advertisement[selection][]", false, array("value"=>$data->id))',            
        ),
        
        array(
            'name'=>'AdvertisementName',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::encode($data->offer_title), array("create", "id"=>$data->id))',            
        ),
        array(
            'name'=>'Vendor',
            'value'=>'$data->description',
        ),
        array(
            'name'=>'Location',
            'type'=>'raw',
            'value'=>'$data->location',
        ),
        //'store_address:text:Location',         
        'city:text:City',         
        'exp_date:text:Expiration Date',               
        'updated_date:text:Last Updated',
    ),
    'cssFile'=>false
));
?>