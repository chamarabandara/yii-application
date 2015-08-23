<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once "class/PushManager.php";
require_once "class/BatchDetails.php";
try{
    
    /*
     echo "Create PushManager from systemadmin user account<br />";
    $pushManager = new PushManager(1);
    
    
    echo 'Set a messsage to send<br />';
    $pushManager->setMessage('Hi, This is a test message', 'soundfile.wav', 7, array('kev'=>'value'));
    
    echo 'Set a Delivery Time (UTC)<br />';
    //$pushManager->setDeliveryTime(date('m/d/Y H:i'));

    //This field is optional
    echo 'Set a user information for tracking.<br />';
    $pushManager->setMerchant(3,'leader'); // user_id and user_role respectively. 
     
    
    
    echo 'Set filter to none<br />';
    $pushManager->setFilters(PushManager::NONE);
    
    //#Filter by Place. Set city value to null if you want to filter by only the county
    //$pushManager->setFilters(PushManager::PLACE,array('country'=>'Sri Lanka','city'=>null));
    
    //#Filter by Distance, All three parameters are mandatory
    //$pushManager->setFilters(PushManager::DISTANCE,array('longitude'=>80.5,'latitude'=>6.55,'distance'=>10));
    
    //#Filter by ECARD Numbers
    //$pushManager->setFilters(PushManager::ECARD,array('ECHARDNO1','ECHARDNO2','ECHARDNO3'));
    
    echo 'Set devices to both (android and ios)<br />';
    $pushManager->setDevices(PushManager::DEVICES_BOTH);
    
    echo 'Check the validity of push message<br />';
    echo $pushManager->isValid() ? 'Push message is valid<br />':'Push message is invalid<br />';

    //    echo 'submit message<br />';
    //    $BatchID =  $pushManager->submit();
    //    echo 'BatchID:'.$BatchID.'<br />'; 
    //    echo 'send message<br />';
    //    $pushManager->approveBatch($BatchID);

     */
    
    echo "<br /><br />Create BatchDetails from systemadmin user account<br />";
    $batches =  BatchDetails::getInstance();
    $batches->setUser(8);

    //This field is optional
    echo 'Set a user information.<br />';
    //$batches->setMerchant(3,'leader'); // user_id and user_role respectively. 
     
    //This field is optional
    echo 'Set a date range.<br />';
    //$batches->setDateRange('11/30/2012 23:56','12/08/2012 23:56'); // set date using m/d/Y H:i format
    
    //This field is optional
    //or you can set one date only
    $batches->setDate('12/08/2012'); // set date using m/d/Y format
    
    //This field is optional
    echo 'Set devices to both, android or ios<br />';
    $batches->setDevices(BatchDetails::DEVICES_ANY);
    
    echo 'get results<br />';
    /*this will return asoc array with followning keys.
     * `BatchID`, `UserID`, `ReviewedBy`, `Devices`, `Message`
        `Sound`, `Badge`, `KeyValue`, `ECardNos`, `Country`
        `City`, `Longitude`, `Latitude`, `Distance`, `Status`
        `PublishDate`
     */
    $results =  $batches->getResult();
    var_dump($results);
    

}catch(Exception $ex){
    echo 'Exception: '.$ex->getMessage();
}

?>
