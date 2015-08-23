<div>
  <?php
       $this->beginWidget('ActiveForm', array(
                'id' => 'advertisement-preview',
                'enableAjaxValidation' => false,
                'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            ));
            ?>  <table cellspacing="0" cellpadding="0" border="0" width="100%">
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
                                                Redeem</a> | <a href="<?php echo Yii::app()->params['hostname'] . "/index.php/advertisements/advertisement/create/id/" . $advertisement->id . "/mapview/yes" ?>">Map</a></div>
                                <div class="row container-2">
                                    <div class="inner-frame">
                                        <div class="phone-bg">
                                            <div class="phone-content"><table cellspacing="0" cellpadding="0" border="0" width="320px" height="436px" >
                                                    <tbody>                               
                                                        <tr>                               
                                                            <td class="header"><?php echo $advertisement->store_name; ?></td>
                                                        </tr> 
                                                        <tr>                               
                                                            <td class="sub-header"><?php echo $advertisement->subCategory->name; ?></td>
                                                        </tr>                             
                                                        <tr>
                                                            <td>
                                                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                                                    <tr><td>
                                                                            <table>
                                                                                <tr>
                                                                                    <td align="left" class="title"><?php echo $advertisement->store_name; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="bold-text" align="left"><?php if ($advertisement->in_airport) echo 'Councourse ' . $advertisement->concourse;
                                                                                        else
                                                                                            echo 'Distance 0000.00 miles';
                                                                                        ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="bold-text"  align="left">
                                                                                        <?php
                                                                                        $coupnAddress = $advertisement->store_address;
                                                                                        $coupnAddress .= (empty($advertisement->address2) ? '' : ', ' . $advertisement->address2);
                                                                                        $coupnAddress .= (empty($advertisement->city) ? '' : ', ' . $advertisement->city);
                                                                                        $coupnAddress .= (empty($advertisement->state) ? '' : ', ' . $advertisement->state);
                                                                                        $coupnAddress .= (empty($advertisement->zip) ? '' : ', ' . $advertisement->zip);
                                                                                        ?>
                                                                                                                                                                                <?php if ($advertisement->in_airport)
                                                                                            echo 'Gate ' . $advertisement->gate;
                                                                                        else
                                                                                            echo 'Address ' . $coupnAddress;
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="bold-text break-word"  align="left"><div style="word-break:break-all;"><?php echo $advertisement->url ?></div></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="bold-text"  align="left"><div class=" offer-contact-bg"><?php echo $advertisement->store_phone ?></div></td>
                                                                                </tr>
                                                                            </table>

                                                                        </td>
                                                                        <td>
                                                                            <table>
                                                                                <tr>
                                                                                    <td align="right" class="map"><?php echo CHtml::image(Yii::app()->params['hostname'] . '/images/admin/img-map.png', ''); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="right" class="socal-network"><?php echo CHtml::image(Yii::app()->params['hostname'] . '/images/admin/social-networking-icons.png', ''); ?></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>                                      
                                                                </table>
                                                            </td>
                                                        </tr>  
                                                        <tr>
                                                            <td class="offer-desc"><?php echo $advertisement->offer_desc ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table>
                                                                    <tr>
                                                                        <td><?php echo CHtml::image(Yii::app()->params['hostname'] . $advertisement->image_url, '', array('width' => '136px')); ?></td>
                                                                        <td valign="top">
                                                                            <table>
                                                                                <tr>
                                                                                    <td class="title"><?php echo $advertisement->offer_title ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="bold-text"><?php echo 'At ' . $advertisement->store_name ?></td>                                                  
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="bold-text"><?php echo 'Exp ' . $advertisement->exp_date ?></td>  
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>                                      
                                                                </table>                                   
                                                            </td>                          
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