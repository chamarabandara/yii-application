<?php

/* Peachtree 
 * User Grid
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */ 


$dp = $users->search();

//set page size
$dp->pagination->pageSize = 25;
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dp,
    'columns'=>array(        
        array(
            'name'=>'Name',
            'type'=>'raw',
            'value'=>'$data->name',
        ),
         array(
            'name'=>'Email',
            'type'=>'raw',
            'value'=>'$data->email',
        ),
          array(
            'name'=>'User Name',
            'type'=>'raw',
            'value'=>'CHtml::encode($data->username)',
        ),
         array(
            'name'=>'User Role',
            'type'=>'raw',
            'value'=>'CHtml::encode($data->role)',
        ),
         array(
            'name'=>'Actions',
            'type'=>'raw',
            'value'=>'CHtml::link(\'Edit\', array("create", "id"=>$data->id))',
        ),
      
    ),
    'cssFile'=>false
));
?>
