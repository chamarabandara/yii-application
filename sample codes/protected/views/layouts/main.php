<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $this->pageTitle; ?></title>
    <?php
        $cs = Yii::app()->getClientScript();
        //$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/admin/modernizr.custom.87042.js');
        $cs->registerCssFile(Yii::app()->request->baseUrl . '/css/admin/atlanta.global.css');
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/admin/common.js');
    ?>  
 </head>
 
 <body style="position: relative;">
 	<div id="loader-wraper" style="height: 100%; display: none; width: 100%; background: black; position: absolute; z-index: 10000; opacity: 0.6"></div>
  <div class="wrapper">
    <div class="banner-pane">
      <div class="logo static-bg pull-left"></div>
      <div class="banner-bg hor-bg pull-left">&nbsp;</div>
      <div class="banner-right  static-bg pull-left">
        <div class="float-right"> 
        <?php if(!Yii::app()->user->isGuest) {?>      
        <span>Welcome <?php echo Yii::app()->user->getState('adminName'); ?></span>
          <a href="<?php echo Yii::app()->controller->createUrl('/admin/update') ?>">[Edit Profile]</a>
       |  <a href="<?php echo Yii::app()->controller->createUrl('/admin/logout') ?>">[Logout]</a>
       <?php }?>
     </div>
   </div>
   
    </div>
    <div class="content-pane " id="contain">
      <div class="container">  
        <div class="content-left" id="content-left-id">&nbsp;</div>
        <div class="banner-bottom-bdr shadow-l-r-ban-border"></div>
        <div class="content-middle shadow-l-r">         
          <div class="float-left tab-left-top-corner ver-bg"></div>
            <div class="inner-menu">
            <?php
            if (Yii::app()->user->getState('roleId') == 1):
  
                $this->widget('application.components.MainMenu', array('items' => array(
                        array('label' => 'Advertisements', 'url' => '/advertisements/advertisement/index',
                            'items' =>array(
                                array('label' => 'Manage Advertisements', 'url' => '/advertisements/advertisement/index'),
                                array('label' => 'Manage Main Category Advertisements', 'url' => '/advertisements/advertisement/categorylist'),
                                array('label' => 'Category Advertisements Order', 'url' => '/advertisements/advertisement/sequence'),
                                ),
                            ),
                        array('label' => 'Vendor', 'url' => '/vendor/vendor/index'),
                        array('label' => 'Manage Users', 'url' => '/users/user/index'),
                        array('label' => 'Url Manager', 'url' => '/urlmanager/urlManager/index'),
                        array('label' => 'Push Notification', 'url' => '/pushnotifications/push/index'),
                        array('label' => 'Analytics', 'url' => '/analytics/analytics/index'),
                       
                )));
            else:
                $this->widget('application.components.MainMenu', array('items' => array(
                        array('label' => 'Advertisement', 'url' => '/advertisements/advertisement/index')
                )));
            endif;
            ?>
            </div>
            <div class="tab-top-bdr hor-bg"></div>
            <div class="float-right tab-right-top-corner static-bg"></div>
            <div class="clear-both"></div>
  
              <?php echo $content; ?>
            <div class="clear-both"></div>
              <div class="wrap-bot-margin">
                  <div class="tab-bottom-corner-left static-bg float-left"></div>
                  <div class="tab-bottom-corner-right static-bg float-right"></div>
                  <div class="tab-bottom-bdr hor-bg"></div>
              </div>
            <div class="clear-both"></div>
        </div>
        <div class="content-right" id="content-right-id">&nbsp;</div>
        </div>
      </div>
      <div class="footer">
        <div class="footer-left ver-bg app-left-bg">
        </div>
                <div class="footer-content">
                  <div class="footer-inner-div">
                    ©2015 West4th | Solution by Dinalex Mobile Inc.
                  </div>
                </div>
                <div class="footer-right ver-bg">
                </div>
                <div class="footer-bottom-left footer-left-bg static-bg">
                </div>
                <div class="footer-center-bottom footer-bg hor-bg">
                </div>
                <div class="footer-right-bottom footer-right-bg static-bg">
                </div>
              </div>
          </div>
      </div>   
   </body>
</html>
