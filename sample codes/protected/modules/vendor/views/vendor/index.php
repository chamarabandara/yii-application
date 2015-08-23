<!--
* Peachtree 
 * Vendor Index
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */
-->

<?php 
    Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/modules/vendor/index.js');
?>


<?php
//Advance search for URL
Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
   $.fn.yiiGridView.update('vendor-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<!-- refresh Vendor grid-->
<script>
$('#update-grid-button').live('click',function()
{
    var id='vendor-grid';
    var inputSelector='#Vendor_description,'+'#Vendor_created_date,'+'#Vendor_created_by,'+'#Vendor_status';
   $(inputSelector).each( function(i,o) {
        $(o).val('');
   });
   var data=$.param($(inputSelector));
   
   $.fn.yiiGridView.update(id, {data: data});
   return false;
});
</script>

<div class="tab-border tab-border-paddin-bottom-0">
    <?php $this->renderPartial('_search', array('model' => $model,'users'=>$users)); ?>
    <div>
        <div class="grid-title">
            <div class="inner-bdr"> <span class="float-left bold-text">Vendor List</span>
                <div class="clear-both"></div>
            </div>
            <div class="grid-bg">
                <div class="grid-bg-inner-bdr">
                    <?php echo $this->renderPartial('grid', array('model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <input type="button" onclick="goTo('<?php echo $this->createUrl('vendor/create') ?>')" class="btn hor-bg btn-margin" value="Add New Vendor" />
    </div>

</div>