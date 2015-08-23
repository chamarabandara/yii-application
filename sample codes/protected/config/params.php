<?php

// Defined parameters for PeachTree Application
return array(
   
    'hostname' => "http://localhost/west4th",
    'img_path' => "",
    'max_category_count' => "24",
    'max_subcategory_count' => "1",
    'adminEmail' => 'webmaster@example.com',
    'init' => 'http://' . $hostname . '/index.php/site/init',
    'validate' => 'http://' . $hostname . '/index.php/site/validate/token/1',
    'couponlist' => 'http://' . $hostname . '/index.php/site/GetAdvertisementList',
    'coupondetail' => 'http://' . $hostname . '/index.php/site/GetAdvertisementDetail',
    'redeemcoupon' => 'http://' . $hostname . '/index.php/site/RedeemCoupon',
    'couponlocations' => 'http://' . $hostname . '/index.php/site/GetAdvertisementLocations',
    'terminalmap' => 'http://' . $hostname . '/index.php/site/GetTerminalMap',
    'uploadPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data',
    'hd_coded_map_url' => '/images/640x872/107428681.jpg',
    'weatherpages' => 'http://' . $hostname . '/index.php/site/GetWeatherPages',
    'couponalldetail' => 'http://' . $hostname . '/index.php/site/GetAdvertisementAllDetail',
    'max_width_large_image'=>'1440',
    'min_width_large_image' => '750',
    'fetured_add_width_thumb'=>'',
    'fetured_add_height_thumb'=>'',
    'normal_add_width_thumb'=> '',
    'normal_add_height_thumb'=> '',
    'system_user'=>1,
    'merchant_user'=>2,


    //'push_notification_user' => 9,
    //'getAllPushDetails' => 'http://hh.devterra.com/MMSCP/WebService/?GetBatchDetails',
    //'createPushMessage' => 'http://hh.devterra.com/MMSCP/WebService/?CreatePushMessage',
    //'push_key' => '462f965c-b273-11e3-a411-000c2914ecd6',
    'img_path'=>$hostname,
    'mailer' => array(
        'smtp_auth' => true,
        'mail_host' => 'smtp.qrvaluesllc.com', //smtp server
        'mail_from' => 'ptcapp@qrvaluesllc.com', //mail from address
        'mail_reply' => 'ptcapp@qrvaluesllc.com', //mail reply to address
        'smtp_username' => 'ptcapp@qrvaluesllc.com',
        'smtp_password' => 'hgyF423#',
        'port' => 25,
        'from_name' => 'HiltonHead Admin'
    )
);
