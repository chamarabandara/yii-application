<div class="tab-border-inner">	
    <div class="float-left tab-left-top-corner-inner ver-bg"></div>
    <div class="tab-top-bdr-inner hor-bg"></div>
    <div class="float-right tab-right-top-corner-inner static-bg"></div>
    <div class="clear-both"></div>
    <div class="tab-border">
        <div class="row container-1">
            <div class="inner-frame">

                <span class="bold-text">Select the Category:</span>

                <?php
                echo CHtml::dropDownList('category_id', isset($_GET['id']) ? $_GET['id'] : '', $category, array(
                    'empty' => array('prompt' => '-- Select Category--')
                        )
                );
                ?>  

            </div> </div>
        <div>
            <div class="grid-title">
                <div class="inner-bdr"> <span class="float-left bold-text">Advertisement List</span>
                    <div class="clear-both"></div>
                </div>
                <div class="grid-bg">
                    <div class="grid-bg-inner-bdr">
                        <?php echo $this->renderPartial('_ajaxContent', array('categoryList' => $categoryList)); ?>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="clear-both"></div>
    <div>
        <div class="tab-bottom-corner-left static-bg float-left"></div>
        <div class="tab-bottom-corner-right static-bg float-right"></div>
        <div class="tab-bottom-bdr hor-bg"></div>
    </div>
    <div class="clear-both"></div>
</div>



<style>
    .advertiser-list {
        padding: 5px 10px;
        text-decoration: underline !important;
    }
    .td-advertiser-link {
        height: 20px;
        width: 170px;
    }
</style>

<script>
    $(document).ready(function() {
        //advertisement  type change function

        $("#category_id").change(function(e) {
             var cat_id = $(this).val();
            goTo('<?php echo Yii::app()->params['hostname'] . '/index.php/advertisements/advertisement/categorylist/id/' ?>' + cat_id);
        });
    });
</script>
