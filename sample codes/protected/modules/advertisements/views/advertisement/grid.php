
<?php

//set page size for data provider
$dp = $advertisement->search();

$dp->pagination->pageSize = 25;
 
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'advertisement-grid',
    //'pager'=>'LinkPager',
    'dataProvider'=>$dp,
       'columns'=>array(
           'id',
        array(
            'name'=>'AdvertisementName',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::encode($data->offer_title), array("create", "id"=>$data->id))',            
        ),
        array(
            'header'=>'Store Name',
            'name'=>'store_name',
            'value'=>'$data->store_name',
        ),
        array(
            'name'=>'Vendor',
            'value'=>'$data->vendor->description',
        ),         
        'exp_date:text:Expiration Date',
        /*array(
            'name'=>'CreatedBy',
            'value'=>'$data->user->name',
        ),  */      
        'status:text:Status'
    ),
    'cssFile'=>false
));
?>