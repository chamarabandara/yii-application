
<?php
//Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery-1.6.2.min.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.ui.core.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.ui.widget.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.ui.dialog.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.ui.position.js');

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/modules/advertisement/create.js');

//Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/le-frog/jquery-ui-1.8.16.custom.css');
//Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/jquery.ui.dialog.css');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/modules/advertisement/create.css');

//Choozen extention
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/chosen.jquery.min.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/chosen.min.css');

//check user status
$active = empty($advertisement->status) ? false : $advertisement->status == 'Active' ? true : false;
?>
<!-- sub category popup -->
<div id="pop_category_dialog" style="display:none" >
    <div class="bold-text" id="pop-sure" style="display:none">Are you sure you need to Delete this sub category?</div>
    <div class="bold-text row" >Sub Category Name:</div>
    <div><input type="text" maxlength="50" size="50" id="pop_sub_category_name"/><span id="pop-error" class="txt-error" style="display:none">please provide a valid Sub Category Name</span></div>
</div>


<!-- sub category create/update and delete -->
<script type="text/javascript">

    $("#Advertisement_sub_category_id").live('change', function(e) {
        $(".sub-category").val($(this).val());
    });
    $('#check_in_air').change(function() {
        showInAir($('#check_in_air').val());
    });

</script>

<!-- loading gif-->
<div id="loader"><?php echo CHtml::image('http://localhost/west4th/images/preloader.gif', 'preloader'); ?></div> 

<?php
$this->beginWidget('ActiveForm', array(
    'id' => 'coupon-create',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>   
<div class="tab-border-inner tab-border-paddin-bottom-0">	
    <div class="float-left tab-left-top-corner-inner ver-bg"></div>
    <div class="tab-top-bdr-inner hor-bg"></div>
    <div class="float-right tab-right-top-corner-inner static-bg"></div>
    <div class="clear-both"></div>
    <div class="tab-border tab-border-paddin-bottom-0">
        <?php
        if (empty($advertisement->id)) {
            echo '<div class="page-title">Create New Advertisement</div>';
        } else {
            if (!$active) {
                echo '<div class="page-title">Edit Advertisement</div>';
            } else {
                echo '<div class="page-title">View Advertisement</div>';
            }
        }
        ?>
        <div class="success-text success-msg errorSummary-ok" style="display: none;"></div>
        <div class="error-text error-msg errorSummary-error" style="display: none;"></div>
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
        <div id="loader"><img src="http://localhost/west4th/images/preloader.gif"></div>
        <div class="row container-1">
            <div class="inner-frame">
                <?php echo CHtml::errorSummary($advertisement,'','',array('class'=>'errorSummary-error')); ?>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Vendor Name:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activeDropDownList($advertisement, 'vendor_id', CHtml::listData($venders, 'id', 'description'), array('empty' => '- - Select - -', 'disabled' => $active ? 'disabled' : ''));
                        ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Store Name:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activeTextField($advertisement, 'store_name', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?></td>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Tagline:</label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activeTextField($advertisement, 'tag_line', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">FB URL:</label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activeTextField($advertisement, 'fb_url', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Twitter URL:</label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activeTextField($advertisement, 'twitter', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Website URL:</label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activeTextField($advertisement, 'url', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Advertisement Type:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-4">
                        <?php echo CHtml::activeDropDownList($advertisement, 'is_featured', array('1' => 'Category Featured', '2' => 'Sub Category Featured ', '0' => 'Normal'), array('prompt' => '- - Select Type - -', 'class' => 'txt-common', 'disabled' => $active ? 'disabled' : '')); ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Category Name:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> <?php
                            echo CHtml::activeDropDownList($advertisement, 'category_id', CHtml::listData($categories, 'id', 'name'), array('data-placeholder' => '- - Select - -', 'class' => 'txt-common', 'multiple' => ($advertisement->hasErrors() && $advertisement->is_featured == Advertisement::CATEGORY_FEATURED_ADD) ? true : false, 'id' => 'Advertisement_category_id', 'disabled' => $active ? 'disabled' : ''));
                            ?></div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>

                <div class="row-form">
                    <?php if (isset($_GET['id']) && $advertisement->is_featured == 1) { ?> 
                        <style>
                            .hide-sub-cat{
                                display: none;
                            }
                        </style>
                    <?php } ?>
                    <div class="col-3" style="display: <?php echo ($advertisement->validate_category == FALSE) ? '' : 'none'; ?>">
                        <label class="bold-text col-12"><div class="hide-sub-cat">Sub Category Name:</div></label>
                    </div>
                    <div class="col-7">

                        <div class="hide-sub-cat" style="display: <?php echo ($advertisement->validate_category == FALSE) ? '' : 'none'; ?>"><table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td width="10%" id="sub_cat_td">
                                        <div id="divAdvancedSearcch" class="float-left">
                                            <?php echo CHtml::activeDropDownList($advertisement, 'sub_category_id', CHtml::listData($subCategories, 'id', 'name'), array('class' => 'txt-common', 'id' => 'Advertisement_sub_category_id', 'disabled' => $active ? 'disabled' : '')); ?>

                                        </div>
                                        <?php echo CHtml::activehiddenField($advertisement, 'sub_category_id', array('class' => 'sub-category')) ?>
                                        <div id="divAdvacedSearchLoading" style="display: none; text-align: center;">
                                            <img src="<?php echo Yii::app()->params['hostname'] . '/images/loading.gif' ?>" alt="Loading" height="40" />
                                        </div>

                                    </td>
                                    <td allign="left">
                                        <?php if (!$active) {
                                            ?>
                                            <div style="margin: 0 0 0 10px" class="float-left" ><a id="add_cat" href="#">Add</a>&nbsp; | &nbsp;<a id="edit_cat" href="">Edit</a>&nbsp; | &nbsp;<a id="del_cat" href="">Delete</a> </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table></div>

                    </div>
                    <div class="col-1">
                    </div>


                </div>



                <div class="row-form" id="tr2">

                    <div class="col-3">
                        <label class="bold-text col-12">Location:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-5">
                        <div id="cat-list">  Lat:<?php echo CHtml::activeTextField($locations, 'latitude', array('readonly' => $active ? 'readonly' : '')) ?>Long:<?php echo CHtml::activeTextField($locations, 'longitude', array('readonly' => $active ? 'readonly' : '')) ?></div>
                    </div>
                    <div class="col-3">
                        <label class="example-label"><strong>Example</strong> :(xx.xxxxxx)</label>

                    </div>
                </div>


                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Store Phone Number:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-5">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextField($advertisement, 'store_phone', array('class' => 'store-list', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="example-label"><strong>Example</strong> :(x-xxx-xxx-xxxx)</label>
                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Address 1:</label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextArea($advertisement, 'store_address', array('class' => 'txt-desc', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Address 2:</label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextArea($advertisement, 'address2', array('class' => 'txt-desc', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">City:</label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextField($advertisement, 'city', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">State:</label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextField($advertisement, 'state', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Zip:</label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextField($advertisement, 'zip', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Offer Title:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextField($advertisement, 'offer_title', array('class' => 'col-12', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Offer Description:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextArea($advertisement, 'offer_desc', array('class' => 'txt-desc', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
                
                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Promo Text:</label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextField($advertisement, 'promo_text', array('class' => 'col-12','maxlength' => '9',  'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Expiration Date:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'Advertisement[exp_date]',
                                'model' => $advertisement,
                                'value' => $advertisement->exp_date,
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'yy-mm-dd',
                                ),
                                'htmlOptions' => array(
                                //'class' => 'col-12'
                                ),
                            ));
                            ?>    

                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>

                <div class="row-form">

                    <div class="col-3">
                        <label class="bold-text col-12">Terms:</label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php echo CHtml::activeTextArea($advertisement, 'terms', array('class' => 'txt-desc', 'readonly' => $active ? 'readonly' : '')) ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>   
                <div class="row-form">

                    <div class="col-3 margin-bottom">
                        <label class="bold-text col-12"> <?php if (!$active): ?><?php endif; ?>Thumbnail Image:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-8">
                        <div class="col-12 margin-bottom">
                            <div id="cat-list"> 
                                <?php if (!$active): ?><input type="file" name="thumb_image" id="thumb_image"/><?php endif; ?>
                                <?php
                                echo CHtml::activeHiddenField($advertisement, 'tumb_text');
                                ?>

                                <?php if (isset($_GET['id'])): ?>
                                    <div>
                                        <img id="avatar-preview" src="<?php echo yii::app()->baseUrl . $advertisement->thumb_url ?>">
                                    </div> <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 margin-bottom">
                            <span class="image-extention bold-text">(Allowed file extensions to upload: jpg, jpeg, png)</span>
                        </div>
                        <div class="col-12">
                            <span class="thumb_image_hint bold-text">
                                <?php
                                if (isset($advertisement->tumb_text) && !is_null($advertisement->tumb_text)) {
                                    echo (strlen($advertisement->tumb_text) != 0) ? $advertisement->tumb_text : '(Upload image size for Normal Advertisement- 136px X 136px)';
                                } else {
                                    switch ($advertisement->is_featured) {
                                        case 1:
                                            echo '(Upload image size for Category Featured Advertisement 540px X 136px)';
                                            break;
                                        case 2:
                                            echo '(Upload image size for Sub Category Featured Advertisement 136px X 136px)';
                                            break;
                                        case 0:
                                            echo '(Upload image size for Normal Advertisement- 136px X 136px)';
                                            break;
                                    }
                                }
                                ?></span>
                        </div>
                    </div>


                </div>   



                <div class="row-form">

                    <div class="col-3 margin-bottom">
                        <label class="bold-text col-12"> <?php if (!$active): ?><?php endif; ?>Large Image:<span class='error-addvert'>*</span></label>
                    </div>
                    <div class="col-8">
                        <div class="col-12 margin-bottom">
                            <div id="cat-list"> 
                                <?php if (!$active): ?><input type="file" name="large_image" id="large_image" /><?php endif; ?>
                                <?php
                                echo CHtml::activeHiddenField($advertisement, 'lag_text');
                                ?>

                                <?php if (isset($_GET['id'])): ?>
                                    <div>
                                        <img id="avatar-preview" src="<?php echo yii::app()->baseUrl . $advertisement->image_url ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 margin-bottom">
                            <span class="image-extention bold-text">(Allowed file extensions to upload: jpg, jpeg, png)</span>
                        </div>
                        <div class="col-12 margin-bottom">
                            <span class="large_image_hint bold-text">
                                <?php
                                if (isset($advertisement->lag_text) && !is_null($advertisement->lag_text)) {
                                    echo (strlen($advertisement->lag_text) != 0) ? $advertisement->lag_text : '(Upload image size for Normal Advertisement- 260px x 260px)';
                                } else {
                                    switch ($advertisement->is_featured) {
                                        case 1:
                                            echo '(Upload image size for Category Featured Advertisement 600px X 260px)';
                                            break;
                                        case 2:
                                            echo '(Upload image size for Sub Category Featured Advertisement 260px X 260px)';
                                            break;
                                        case 0:
                                            echo '(Upload image size for Normal Advertisement- 260px X 260px)';
                                            break;
                                    }
                                }
                                ?>    
                            </span>
                        </div>
                    </div>

                </div> 


                <div class="row-form" style="display: none">

                    <div class="col-3">
                        <label class="bold-text col-12">Terminal map:</label>
                    </div>
                    <div class="col-4">
                        <div id="cat-list"> 
                            <?php if (!$active): ?><input type="file" name="map_image" id="map_image" /><?php endif; ?>
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                </div>


            </div>
        </div>
        <div class="row row-margin-0 buttons btngroup">
             <?php echo CHtml::hiddenField('baseURL', Yii::app()->baseUrl, array('class' => 'baseUrl')); ?> 
            <?php echo CHtml::hiddenField('getId', (isset($_GET['id'])) ? 1 : 0); ?>
            <?php echo CHtml::hiddenField('hdnBaseUrl', Yii::app()->request->baseUrl . '/index.php/advertisements/advertisement/LoadSubCats'); ?>
            <?php echo CHtml::hiddenField('hdnBaseUrlCategory', Yii::app()->request->baseUrl . '/index.php/advertisements/advertisement/loadsubcategory'); ?>
            <?php echo CHtml::hiddenField('hdnCouponId', empty($advertisement->id) ? 0 : $advertisement->id, array('id' => 'hdnCouponId')) ?>
            <?php
            if (!$active)
                echo CHtml::submitButton('Save for later', array('id' => 'save_btn', 'class' => 'btn hor-bg', 'name' => 'Save'));
            ?>
            <?php
            if (!$active)
                echo CHtml::submitButton('Save for later & Preview', array('id' => 'save_btn_preview', 'class' => 'btn hor-bg', 'name' => 'SavePreview'));
            ?>
            <?php
            if ($active)
                echo CHtml::submitButton('Preview', array('id' => 'btn_preview', 'class' => 'btn hor-bg', 'name' => 'Preview'));
            ?>
            <?php
            if (($advertisement->status == "Active"))
                echo CHtml::submitButton('Deactivate', array('id' => 'btn_deactivate', 'class' => 'btn hor-bg', 'name' => 'Deactivate'));
            else if (($advertisement->status == "Inactive"))
                echo CHtml::submitButton('Activate', array('id' => 'btn_activate', 'class' => 'btn hor-bg', 'name' => 'Activate'));
            ?>
            <input type="button" onclick="goTo('<?php echo Yii::app()->params['hostname'] . '/index.php/advertisements/advertisement/index' ?>')" value="Cancel" class="btn hor-bg">
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
<?php $this->endWidget(); ?> 
<!--end-->  

<style>
    .error-addvert{
        color: red;
    }

</style>


