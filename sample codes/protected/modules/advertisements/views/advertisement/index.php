<?php 
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/modules/advertisement/search.css');
?>
<?php
//Advance search for URL
Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
   $.fn.yiiGridView.update('advertisement-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<script>
$('#update-grid-button').live('click',function()
{
 // var inputSelector=$('#Advertisement_status').val('');
        var id='advertisement-grid';
   var inputSelector='#Advertisement_offer_title,'+'#Advertisement_category_id,'+'#Advertisement_is_featured,'+'#Advertisement_status,'+'#Advertisement_created_by,'+'#Advertisement_store_name';
  
   console.log(inputSelector);
   $(inputSelector).each( function(i,o) {
        $(o).val('');
   });
   var data=$.param($(inputSelector));
   
   $.fn.yiiGridView.update(id, {data: data});
   return false;
});
</script>

<div class="tab-border-inner ">	
    <div class="float-left tab-left-top-corner-inner ver-bg"></div>
    <div class="tab-top-bdr-inner hor-bg"></div>
    <div class="float-right tab-right-top-corner-inner static-bg"></div>
  <div class="clear-both"></div>
  <div class="tab-border tab-border-paddin-bottom-0">
  
    <?php $this->renderPartial('_search', array('model' => $model, 'users' => $users)); ?>
  
      <div>
          <div class="grid-title">
              <div class="inner-bdr"> <span class="float-left bold-text">Advertisement List</span>
                  <div class="clear-both"></div>
              </div>
              <div class="grid-bg">
                  <div class="grid-bg-inner-bdr">
                        <?php echo $this->renderPartial('grid', array('advertisement' => $model)); ?>
                  </div>
              </div>
          </div>
      </div>
      <div class="">
           <input type="button" onclick="goTo('<?php echo Yii::app()->params['hostname'] . '/advertisements/advertisement/create' ?>')" class="btn hor-bg btn-margin" value="Add New Advertisement" />
           <input type="button" onclick="goTo('<?php echo Yii::app()->params['hostname'] . '/advertisements/advertisement/review' ?>')" class="btn hor-bg btn-margin" value="Edit Advertisements" />
                             
      </div>
      
  </div>
  <div class="clear-both"></div>
    <div class="wrap-bot-margin">
        <div class="tab-bottom-corner-left static-bg float-left"></div>
        <div class="tab-bottom-corner-right static-bg float-right"></div>
        <div class="tab-bottom-bdr hor-bg"></div>
    </div>
    <div class="clear-both"></div>
</div>

<style>
    form .col-1,
.col-2,
.col-3,
.col-4,
.col-5,
.col-6,
.col-7,
.col-8,
.col-9,
.col-10,
.col-11,
.col-12 {
  position: relative;
  min-height: 1px;
  padding-right: 0px;
  padding-left: 5px;
}
</style>