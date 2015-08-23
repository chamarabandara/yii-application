<?php

$results = json_decode($batches, true);

$dataProvider = new CArrayDataProvider(
        !empty($results['response']) ? $results['response'] : array(), array(
    'keyField' => 'BatchID',
    'id' => 'BatchID',
    'sort' => array(
        'attributes' => array(
            'BatchID',
            'Message',
            'CreatedDate',
            'PublishDate',
            'Devices',
            'Name'
        ),
    ),
    'pagination' => array(
        'pageSize' => 20,
    ),
        ));

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'id' => 'push-grid',
    'columns' => array(
        array(
            'header'=>'Batch ID',
            'name' => 'BatchID',
            'htmlOptions'=>array('style' => 'text-align: center; width:60px',),
        ),
        array(
            'name' => 'Message',
            'htmlOptions'=>array('width'=>'400px'),
        ),
        array(
            'header'=>'Created Date',
            'name' => 'CreatedDate',
            'type' => 'raw',
            'value' => 'date(\'Y-m-d g:i A\', strtotime($data[\'CreatedDate\']))',
            'htmlOptions' => array('class' => 'utc-date'),
        ),
        array(
              'header'=>'Publish Date',
            'name' => 'PublishDate',
            'type' => 'raw',
            'value' => 'date(\'Y-m-d g:i A\', strtotime($data[\'PublishDate\']))',
            'htmlOptions' => array('class' => 'utc-date'),
        ),
        array(
             'header'=>'Device',
            'name' => 'Devices',
            'value' => 'PushNotification::getMobileType($data[\'Devices\'])',
        ),
        array(
              'header'=>'Created By',
            'name' => 'Name',
            'type' => 'raw',
            'value' => '$data[\'MRole\']',
        ),
    ),
    'cssFile' => false
));
