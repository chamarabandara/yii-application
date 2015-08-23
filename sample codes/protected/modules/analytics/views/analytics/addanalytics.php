



<div>
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody><tr>
                <td class="tab-content-left ver-bg"></td>
                <td class="tab-content">
                     <div class="float-left tab-left-top-corner ver-bg"></div>
                    <?php
                    if (Yii::app()->user->getState('roleId') == 1):

                        $this->widget('application.components.MainMenu', array('items' => array(
                                array('label' => 'Manage Advertisements', 'url' => '/admin/coupon/index', 'class' => 'active'),
                                array('label' => 'Manage Main Category Advertisements', 'url' => '/admin/advertiser/index')
                        )));
                    else:
                        $this->widget('application.components.MainMenu', array('items' => array(
                                array('label' => 'Advertisement', 'url' => '/admin/coupon/index')
                        )));
                    endif;
                    ?>
                    <div class="tab-top-bdr hor-bg"></div>
                     <div class="float-right tab-right-top-corner static-bg"></div>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td class="tab-content-left ver-bg"></td>
                            <td  class="tab-content">
                              
                                                              
                            </td>
                            <td class="tab-content-right ver-bg"></td>
                        </tr>
        </tbody>
    </table>
  
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
<style>
    .fetured-add-readiobutton {
        margin-left: -47px;
        margin-bottom: 8px;
    }
    #Coupon_is_featured label {
        width: 300px;
    }
    .large_image_hint {
        font-size: 9px;
        /*        margin-left: -30px;*/
    }
    .thumb_image_hint {
        font-size: 9px;
        /*        margin-left: -30px;*/
    }
    .image-extention{
        font-size: 10px;
    }

    .analytics-link {
        margin-left: 193px;
        margin-top: -34px;
        text-decoration: none;
        border: 1px solid yellow;
        width: 119px;
        background-color: yellow;
    }
</style>
