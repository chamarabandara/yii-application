<?php
/*
* Peachtree 
 * Vendor Grid
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'id' => 'vendor-grid',
    'columns' => array(
        array(
            'name' => 'VendorName',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->description), array("create", "id"=>$data->id))',
        ),
        'created_date:text:Created Date',
        'user.name:text:Created By',
        array(
            'name' => 'status',
            'header' => 'Status',
            'type' => 'raw',
            'value' => '($data->status)?"Active":"Inactive"',
        ),
    ),
    'cssFile' => false
));
?>
