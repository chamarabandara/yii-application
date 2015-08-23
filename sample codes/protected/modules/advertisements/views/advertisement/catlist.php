<div>
    <?php
    $this->beginWidget('ActiveForm', array(
        'id' => 'advertisement-catlist',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>    <table cellspacing="0" cellpadding="0" border="0" width="100%">
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
                                                            <td class="header"><?php echo $advertisement->subCategory->category->name; ?></td>
                                                        </tr> 
                                                        <tr>
                                                            <td valign="top">
                                                                <?php
                                                                if ($advertisement->in_airport) {
                                                                    if (isset($advertisement->subCategory->category->featured_coupon) && $advertisement->subCategory->category->featured_coupon == $advertisement->id) {
                                                                        echo "<table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                <tr>
                                                   <td width='68' class='sub-cat-list'>" . CHtml::image(Yii::app()->params['hostname'] . $advertisement->thumb_url, '', array('width' => '68px')) . "</td>
                                                   <td class='featured-coupon-bg sub-cat-list' >
                                                      <table cellspacing='0' cellpadding='0' border='0' width='100%' class='tbl-form'>
                                                         <tr>
                                                            <td class='bold-text'>" . $advertisement->store_name . "</td>
                                                            <td align='right'>" . $advertisement->concourse . "</td>
                                                         </tr>
                                                         <tr>
                                                            <td class='txt-error'>" . $advertisement->offer_title . "</td>
                                                            <td align='right'>" . $advertisement->gate . "</td>
                                                         </tr>
                                                         <tr>
                                                            <td>" . $advertisement->tag_line . "</td>
                                                            <td align='right'></td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                                </table>";
                                                                    } else {
                                                                        echo "<table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                <tr> 
                                                <td>
                                                <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                   <tr>
                                                      <td class='content-header hor-bg '>" . $advertisement->subCategory->name . "</td>
                                                      <td class='content-header hor-bg ' align=right>Concourse</td>
                                                   </tr>
                                                </table>
                                                </td>  
                                                </tr>
                                                <tr>
                                                   <td class='sub-cat-list'>
                                                   <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                   <tr>
                                                      <td width='68'>" . CHtml::image(Yii::app()->params['hostname'] . $advertisement->thumb_url, '', array('width' => '68px')) . "</td>
                                                      <td class='cat-list-info'>
                                                         <table cellspacing='0' class='tbl-form' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                               <td class='bold-text'>" . $advertisement->store_name . "</td>
                                                               <td align='right'>" . $advertisement->concourse . "</td>
                                                            </tr>
                                                            <tr>
                                                               <td class='green-text bold-text'>" . $advertisement->offer_title . "</td>
                                                               <td align='right'>" . $advertisement->gate . "</td>
                                                            </tr>
                                                            <tr>
                                                               <td>" . $advertisement->tag_line . "</td>
                                                               <td align='right'></td>
                                                            </tr>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                   </table>
                                                   </td>
                                                </tr>
                                                </table>";
                                                                    }
                                                                } else {
                                                                    if (isset($advertisement->subCategory->category->featured_coupon_nearby) && $advertisement->subCategory->category->featured_coupon_nearby == $advertisement->id) {
                                                                        echo "<table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                <tr>
                                                   <td width='68' class='sub-cat-list'>" . CHtml::image(Yii::app()->params['hostname'] . $advertisement->thumb_url, '', array('width' => '68px')) . "</td>
                                                   <td class='featured-coupon-bg sub-cat-list' >
                                                      <table cellspacing='0' cellpadding='0' border='0' width='100%' class='tbl-form'>
                                                         <tr>
                                                            <td class='bold-text'>" . $advertisement->store_name . "</td>
                                                            <td align='right'>0000.00</td>
                                                         </tr>
                                                         <tr>
                                                            <td class='txt-error'>" . $advertisement->offer_title . "</td>
                                                            <td align='right'>miles</td>
                                                         </tr>
                                                         <tr>
                                                            <td>" . $advertisement->tag_line . "</td>
                                                            <td align='right'></td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                                </table>";
                                                                    } else {
                                                                        echo "<table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                <tr> 
                                                <td>
                                                <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                   <tr>
                                                      <td class='content-header hor-bg '>" . $advertisement->subCategory->name . "</td>
                                                      <td class='content-header hor-bg ' align=right>Distance</td>
                                                   </tr>
                                                </table>
                                                </td>  
                                                </tr>
                                                <tr>
                                                   <td class='sub-cat-list'>
                                                   <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                   <tr>
                                                      <td width='68'>" . CHtml::image(Yii::app()->params['hostname'] . $advertisement->thumb_url, '', array('width' => '68px')) . "</td>
                                                      <td class='cat-list-info'>
                                                         <table cellspacing='0' class='tbl-form' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                               <td class='bold-text'>" . $advertisement->store_name . "</td>
                                                               <td align='right'>0000.00</td>
                                                            </tr>
                                                            <tr>
                                                               <td class='green-text bold-text'>" . $advertisement->offer_title . "</td>
                                                               <td align='right'>miles</td>
                                                            </tr>
                                                            <tr>
                                                               <td>" . $advertisement->tag_line . "</td>
                                                               <td align='right'></td>
                                                            </tr>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                   </table>
                                                   </td>
                                                </tr>
                                                </table>";
                                                                    }
                                                                }
                                                                ?>
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