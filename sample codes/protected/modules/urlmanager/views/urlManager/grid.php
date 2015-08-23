<!--
Peachtree 
Grid view
@author Chamara Bandara
@copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
-->

<?php
//model search
$dp = $model->search();

//set page size for data provider
$dp->pagination->pageSize = 25;

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dp,
    'id' => 'url-grid',
    'columns' => array(
        array(
            'header' => 'Name',
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("update", "id"=>$data->id))',
            'htmlOptions'=>array('width'=>'120px'),
        ),
        array(
            'header' => 'Url',
            'name' => 'url',
            'type' => 'raw',
             'htmlOptions'=>array('width'=>'400px'),
        ),
        array(
            'header' => 'Created Date',
            'name' => 'created_date',
            'type' => 'raw',
        ),
        array(
            'header' => 'Created By',
            'name' => 'created_by',
            'value' => 'User::getName($data->created_by)',
        ),
        array(
            'header' => 'Status',
            'name' => 'status',
            'type' => 'raw',
            'value' => 'Url::getStatus($data->status)',
        ),
//        array(
//            'header' => 'Actions',
//            'class' => 'CButtonColumn',
//            'template' => '{update}{delete}',
//        ),
    ),
    'cssFile' => false
));
?>
