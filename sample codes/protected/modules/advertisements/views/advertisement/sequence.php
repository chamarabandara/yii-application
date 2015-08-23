<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/le-frog/jquery-ui-1.8.16.custom.css');
//Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/jquery-ui-1.8.16.custom.css');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/jquery.ui.dialog.css');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery-1.6.2.min.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.ui.core.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.ui.widget.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.ui.position.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.ui.dialog.js');
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
    .grid-bg {
        background: none !important;
        border: solid 1px #2c7440;
        border-right: 0;
        border-left: 0;
    }
    #ballot {
        margin: 10px;
    }
    .ranking {
        width: 768px;
    }
    .sequence-bg {
        background-color: #CEE3EA;
    }
</style>
<script>
    $(function() {
        $("#sortable").sortable({axis: "y", containment: "#ballot", scroll: false});
        $("#sortable").disableSelection();

        $('form').submit(function() {

            $('#thedata').val($("#sortable").sortable("serialize"));
            return true;
        });
    });
</script>


<div class="tab-border-inner">	
    <div class="float-left tab-left-top-corner-inner ver-bg"></div>
    <div class="tab-top-bdr-inner hor-bg"></div>
    <div class="float-right tab-right-top-corner-inner static-bg"></div>
    <div class="clear-both"></div>
    <div class="tab-border">
        <?php if (Yii::app()->user->hasFlash('success')): ?>
            <div class="success-msg errorSummary-ok">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('error')): ?>
            <div class="error-msg errorSummary-error">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php endif; ?>
        <div class="row container-1">
            <div class="inner-frame">
                <span class="bold-text">Select the category:</span>

                <?php
                echo CHtml::dropDownList('category_id', isset($_GET['id']) ? $_GET['id'] : '', $category, array(
                             
                    'empty' => array('prompt' => '-- Select Category--')
                        )
                );
                ?>


            </div> </div>
       
           
                <div>
                    <div class="grid-title">
                        <div class="inner-bdr"> <span class="float-left bold-text">To set the advertisement sequence, drag the the list items below up or down.</span>

                            <div class="clear-both"></div>
                        </div>
                        <div class="grid-bg">
                            <?php
                            $this->beginWidget('ActiveForm', array(
                                'id' => 'coupon-create',
                                'enableAjaxValidation' => FALSE,
                                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                            ));
                            ?> 
                            <input type='hidden' name='thedata' id='thedata'>
                            <div id="ballot" class="center">
                                <ol id="sortable" class="rankings">
                                    <?php
                                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                                        foreach ($categoryList as $key => $value) {
                                            ?>
                                            <li id='ranking_<?php echo $value['id']; ?>' class="ranking row container-1 sequence-bg"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $value['offer_title']; ?></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ol>
                            </div>

                        </div> 
                    </div>
                    <?php if (isset($_GET['id']) && !empty($categoryList)) { ?>
                        <?php echo CHtml::submitButton('Save', array('id' => 'save_btn', 'class' => 'btn hor-bg', 'name' => 'save')); ?>

                    <?php } ?>
                    <?php $this->endWidget(); ?> 
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




<script>
    $(document).ready(function() {
        //advertisement  type change function

        $("#category_id").change(function(e) {

            var cat_id = $(this).val();
            goTo('<?php echo Yii::app()->params['hostname'] . '/index.php/advertisements/advertisement/sequence/id/' ?>' + cat_id);
        });
    });
</script>
