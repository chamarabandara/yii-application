<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/modules/analytics/search.css');
   Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/modules/analytics/analytics.js');
?>

<div class="tab-border">
   <?php echo $this->renderPartial('_search', array('analytic'=>$analytic)); ?>

    <div>
        <div class="grid-title">
            <div class="inner-bdr"> <span class="float-left bold-text">Analytics</span>
                <div class="clear-both"></div>
            </div>
            <div class="grid-bg">
                <div class="grid-bg-inner-bdr">
                    <div id="filtered-data">
                         <?php $this->renderPartial('_ajaxcontent',array('myValue'=>$myValue)); ?> 
                    </div>
                   	
		
                </div>
            </div>
        </div>
    </div>
  

</div>
 