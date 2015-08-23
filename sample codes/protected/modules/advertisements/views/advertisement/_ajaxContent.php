
<?php

$dp->pagination->pageSize = 24;
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $categoryList,
   // 'filter'=>$model,
    'id'=>'category-grid',
    'columns' => array(
        array(
            'header'=>'Number',
            'name'=>'rowNumber',
            'htmlOptions'=>array('style' => 'text-align: center;',),
           ),
        
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
    'cssFile' => false
));
?>
