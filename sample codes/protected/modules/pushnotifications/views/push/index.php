
<!--
Peachtree 
Vendor grid view
@author Chamara Bandara
@copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd

-->


<div class="tab-border tab-border-paddin-bottom-0">
    <?php $this->renderPartial('_search', array('push' => $push)); ?>

    <div>
        <div class="grid-title">
            <div class="inner-bdr"> <span class="float-left bold-text">Push Notification List</span>
                <div class="clear-both"></div>
            </div>
            <div class="grid-bg">
                <div class="grid-bg-inner-bdr">
                    <?php echo $this->renderPartial('grid', array('batches' => $batches)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <?php echo CHtml::button('Create Push Notification', array('id' => 'btn_add_img', 'class' => 'btn hor-bg btn-margin', 'name' => 'Add image')); ?>
    </div>

</div>



<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_add_img').click(function(event) {
            document.location.href = '<?php echo Yii::app()->params['hostname'] . '/index.php/pushnotifications/push/create/' ?>';
        });

    });


</script>