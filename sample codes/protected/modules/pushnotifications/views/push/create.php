
<?php
//Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/jquery.ui.datepicker.css');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/js/modules/push/push.js');
?>
<div>
    <?php
    $form = $this->beginWidget('ActiveForm', array(
        'id' => 'push-create-form',
        'enableAjaxValidation' => TRUE,
    ));
    ?>
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody>
            <tr>
                <td class="tab-content-left ver-bg"></td>
                <td class="tab-content tab-border-paddin-bottom-0">
                    <?php
                    if (empty($city->id)) {
                        echo '<div class="page-title">Create New Push Notification</div>';
                    } else {
                        echo '<div class="page-title">Edit Push Notification</div>';
                    }
                    ?>
                    <?php if (Yii::app()->user->hasFlash('success')): ?>
                        <div class="success-msg errorSummary-ok">
                            <?php echo Yii::app()->user->getFlash('success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (Yii::app()->user->hasFlash('error')) { ?>
                        <div class="error-msg errorSummary-error">
                            <?php echo Yii::app()->user->getFlash('error'); ?>
                        </div>
                    <?php } ?>
                    <div class="row container-1">
                        <div class="inner-frame">
                            <?php echo CHtml::errorSummary($push,'','',array('class'=>'errorSummary-error')); ?>
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" class="tbl-form">
                                <tbody>
                                    <tr>
                                        <td width="200" class="bold-text">
                                            <?php echo $form->labelEx($push, 'method', array('class' => 'bold-text')); ?>
                                        </td>
                                        <td>
                                            <?php echo $form->dropDownList($push, 'method', array('1' => 'Send to all'), array('class' => 'txt-common')); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="200" class="bold-text">
                                            <?php echo $form->labelEx($push, 'mobile_type', array('class' => 'bold-text')); ?></td>
                                        <td>
                                            <?php echo $form->dropDownList($push, 'mobile_type', array('1' => 'iPhone', '2' => 'Android', '3' => 'Both'), array('empty' => '- - Select - -', 'class' => 'txt-common')); ?>
                                    </tr>

                                    <tr>
                                        <td width="200" class="bold-text">
                                            <?php echo $form->labelEx($push, 'merchant', array('style' => 'width:auto;')); ?></td>
                                        <td>
                                            <?php echo $form->dropDownList($push, 'merchant', CHtml::listData($merchant, 'id', 'description'), array('empty' => '- - Select - -', 'class' => 'txt-common')); ?>
                                    </tr>
                                    <tr>
                                        <td width="200" class="bold-text">
                                            <?php echo $form->labelEx($push, 'offer', array('style' => 'width:auto;')); ?></td>
                                        <td>
                                            <?php echo $form->dropDownList($push, 'offer', CHtml::listData($offer, 'id', 'offer_title'), array('empty' => '- - Select - -', 'class' => 'txt-common')); ?>
                                    </tr>


                                    <tr>
                                        <td class="bold-text">
                                            <?php echo $form->labelEx($push, 'message', array('style' => 'width:auto;')); ?></td>                                           
                                        <td>
                                            <?php echo $form->textArea($push, 'message', array('class' => 'txt-common')); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bold-text"></td>
                                        <td><?php echo CHtml::activeCheckBox($push, 'is_offer_title') ?>Use offer description as message.</td>
                                    </tr>

                                    <tr id="favourite" style="display: <?php
                                            if ($push->method != 1)
                                                echo '';
                                            else
                                                echo 'none';
                                            ?>">
                                        <td class="bold-text"></td>
                                        <td><?php echo CHtml::activeCheckBox($push, 'is_favourite') ?>Send by favorite.</td>
                                    </tr>
                                    <tr id="gender" style="display: <?php
                                    if ($push->method != 1)
                                        echo '';
                                    else
                                        echo 'none';
                                            ?>">
                                        <td class="bold-text"><b>Gender</b></td>
                                        <td>
                                            <?php echo CHtml::activeCheckBox($push, 'is_male') ?>Male&nbsp;&nbsp;
                                            <?php echo CHtml::activeCheckBox($push, 'is_female') ?>Female</td>
                                    </tr>
                                    <tr>
                                        <td class="bold-text">Delivery Date/Time:<span style='color: red;'>*</span></td>
                                        <td>
                                            <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'PushNotification[start_date]',
                                                'model' => $push,
                                                'attribute' => 'start_date',
                                                // additional javascript options for the date picker plugin
                                                'options' => array(
                                                    'showAnim' => 'fold',
                                                    'changeMonth' => true,
                                                    'changeYear' => true,
                                                    'dateFormat' => 'yy-mm-dd',
                                                ),
                                                'htmlOptions' => array(
                                                    'class' => 'date'
                                                ),
                                            ));
                                            ?>&nbsp;<?php
                                            $this->widget(
                                                    'ext.jui.EJuiDateTimePicker', array(
                                                'model' => $push,
                                                'attribute' => 'start_time',
                                                'language' => 'en', //default Yii::app()->language
                                                'mode' => 'time', //'datetime' or 'time' ('datetime' default)
                                                'options' => array(
                                                    //'dateFormat' => 'dd.mm.yy',
                                                    'timeFormat' => 'h:mm TT', //'hh:mm tt' default
                                                ),
                                                    )
                                            );
                                            ?>
                                        </td>
                                    </tr>
                                    <tr id="e-card" style="display: <?php
                                            if ($push->method == 2)
                                                echo '';
                                            else
                                                echo 'none';
                                            ?>">
                                        <td class="bold-text"><?php echo CHtml::activeLabel($push, 'ecard', array('style' => 'width:auto;')); ?><span style='color: red;'>*</span></td>
                                        <td><?php echo CHtml::activeTextArea($push, 'ecard', array('class' => 'txt-common', 'placeholder' => 'Enter comma separated ecard numbers')); ?></td>
                                    </tr>
                                    <tr id="country" style="display: <?php
                                        if ($push->method == 3)
                                            echo '';
                                        else
                                            echo 'none';
                                            ?>">
                                        <td class="bold-text"><?php echo CHtml::activeLabel($push, 'country', array('style' => 'width:auto;')); ?><span style='color: red;'>*</span></td>
                                        <td><?php echo CHtml::activeDropDownList($push, 'country', CHtml::listData($countries, 'id', 'name'), array('empty' => '- - Select - -', 'style' => 'width:200px')); ?></td>
                                    </tr>
                                    <tr id="city" style="display: <?php
                                        if ($push->method == 3)
                                            echo '';
                                        else
                                            echo 'none';
                                            ?>">
                                        <td class="bold-text"><?php echo CHtml::activeLabel($push, 'city', array('style' => 'width:auto;')); ?><span style='color: red;'>*</span></td>
                                        <td><?php echo CHtml::activeDropDownList($push, 'city', CHtml::listData($cities, 'id', 'name'), array('style' => 'width:200px', 'empty' => '- - Select - -')); ?></td>
                                    </tr>

                                    <tr id="location" style="display: <?php
                                        if ($push->method == 4)
                                            echo '';
                                        else
                                            echo 'none';
                                            ?>">
                                        <td class="bold-text">Location:<span style='color: red;'>*</span></td>
                                        <td><?php echo CHtml::activeTextField($push, 'long', array('maxlength' => '11', 'class' => 'input-small', 'placeholder' => 'Longitude')) ?> 
                                        <?php echo CHtml::activeTextField($push, 'lat', array('maxlength' => '11', 'class' => 'input-small', 'placeholder' => 'Latitude')) ?> 

                                            Distance
                                            <span style='color: red;'>*</span>
                                            &nbsp;

                                            <div id="PushNotification_distance_slider" 
                                                 style="width:200px;display:inline-block;">
                                            </div>
                                            &nbsp;
<?php
echo CHtml::activeTextField($push, 'distance', array(
    'maxlength' => '2',
    'value' => !empty($push->distance) ? $push->distance : '',
    'class' => 'input-small',
    'style' => 'width:28px;',
    'title' => 'Selected radius for the push nortification',
    'readonly' => true
));
?>

                                            Km.
                                            <br/>
                                            (<?php
                                            echo CHtml::link("Click here to use the Longitude / Latitude Generator", "http://myportal.savezapp.com/resources/longitude-latitude-generator/", array(
                                                'target' => 'new',
                                            ));
?>)
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="">
<?php echo CHtml::submitButton('Create', array('id' => 'save_btn', 'class' => 'btn hor-bg', 'name' => 'Save')); ?>
                        <input type="button" onclick="goTo('<?php echo Yii::app()->params['hostname'] . '/index.php/pushnotifications/push/index' ?>')" class="btn hor-bg" value="Cancel" />
                    </div>
                </td>
                <td class="tab-content-right ver-bg"></td>
            </tr>
        </tbody>
    </table>
<?php echo CHtml::hiddenField('timezoneoffset', ''); ?>
    <?php $this->endWidget(); ?>
    <?php echo CHtml::hiddenField('hdnCityUrl', Yii::app()->request->baseUrl . '/index.php/admin/coupon/loadcities'); ?>
    <?php echo CHtml::hiddenField('hdnCouponLoadUrl', Yii::app()->request->baseUrl . '/index.php/advertisements/advertisement/LoadAdvertisement'); ?>
    <?php echo CHtml::hiddenField('hdnCouponDescUrl', Yii::app()->request->baseUrl . '/index.php/advertisements/advertisement/GetAdvertisementDescription'); ?>
    <?php echo CHtml::hiddenField('hdnMerchantLogoUrl', Yii::app()->params['hostname'] . '/index.php/admin/vendor/getmerchantlogo'); ?>


    <script>
                            $(document).ready(function() {
                                var datePickerImgUrl = "<?php echo Yii::app()->request->baseUrl; ?>/images/admin/calendar.gif";
                                var vendorUrl = "<?php echo Yii::app()->params['hostname'] ?>/index.php/admin/vendor/create/id/";
                                initPushNortificationForm(datePickerImgUrl, vendorUrl);
                            });
    </script>
