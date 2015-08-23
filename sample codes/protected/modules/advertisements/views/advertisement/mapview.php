<div>
    <?php
    $this->beginWidget('ActiveForm', array(
        'id' => 'advertisement-mapview',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>      <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody>
            <tr>
                <td class="tab-content-left ver-bg"></td>
                <td class="tab-content">

                    <div class="tab-top-bdr hor-bg"></div>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td class="tab-content-left ver-bg"></td>
                            <td  class="tab-content">
                                <div class="page-title">Preview Advertisement</div>
                                <div class="row">Preview: <a href="<?php echo Yii::app()->params['hostname'] . "/index.php/advertisements/advertisement/create/id/" . $advertisement->id . "/catlist/yes" ?>">
                                        Category List</a> | <a href="<?php echo Yii::app()->params['hostname'] . "/index.php/advertisements/advertisement/create/id/" . $advertisement->id . "/preview/yes" ?>" class="preview-active">
                                        Advertisement Preview</a> | <a href="<?php echo Yii::app()->params['hostname'] . "/index.php/advertisements/advertisement/create/id/" . $advertisement->id . "/redeem/yes" ?>">
                                        Redeem</a> | <a href="<?php echo Yii::app()->params['hostname'] . "/index.php/advertisements/advertisement/create/id/" . $advertisement->id . "/mapview/yes" ?>">Map</a></div>                                <div class="row container-2">
                                    <div class="inner-frame">
                                        <div class="phone-bg">
                                            <div class="phone-content"><table cellspacing="0" cellpadding="0" border="0" >
                                                    <tbody>
                                                        <tr>
                                                            <td class="header"><?php echo $coupons->store_name; ?></td>
                                                        </tr> 
                                                        <tr>
                                                            <td><?php
                                                                if ($coupons->in_airport == '1') {
                                                                    echo CHtml::image(Yii::app()->params['hostname'] . $coupons->map_url, '', array('width' => '320px', 'height' => '436px'));
                                                                } else {
                                                                    echo CHtml::image(Yii::app()->params['hostname'] . '/images/admin/map_nearby.png', '', array('width' => '320px'));
                                                                }
                                                                ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <input type="button" onclick="goTo('<?php echo Yii::app()->params['hostname'] . '/index.php/advertisements/advertisement/index' ?>')" value="Save" class="btn hor-bg">
                                </div></td>
                            <td class="tab-content-right ver-bg"></td>
                        </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>  
</div>
<div class="clear-both"></div>
<div>
    <div class="tab-bottom-corner-left static-bg float-left"></div>
    <div class="tab-bottom-corner-right static-bg float-right"></div>
    <div class="tab-bottom-bdr hor-bg"></div>
</div>
<div class="clear-both"></div>

</td>
<td class="tab-content-right ver-bg"></td>
</tr>

</table>   