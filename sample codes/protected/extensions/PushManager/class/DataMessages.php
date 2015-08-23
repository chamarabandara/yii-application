<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApplePushDB
 *
 * @author dasun
 */
include_once 'DataService.php';

class DataMessages extends DataService {

    public function filterByEcard($userID,$devices,$message,$extra_data,$sound,$badge,$ECardNos,$options) {
        
        // begin transaction
        $this->dbh->beginTransaction();

        try {
            if(isset($options['merchant'])){
                $muserid=$options['merchant']['MUserID'];
                $mrole=$options['merchant']['MRole'];
            } else {
                $mrole=null;
                $muserid=null;
            }
            $sql = "INSERT INTO `MessageBatch`"
                    ."(`UserID`,`Devices`,`Message`,`Sound`,`Badge`,`KeyValue`,`ECardNos`,`PublishDate`,`MUserID`,`MRole`)"
                    ."VALUES"
                    ."(:UserID, :Devices, :Message,:Sound,:Badge,:KeyValue,:ECardNos,:Date,:MUserID,:MRole);";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':UserID' =>$userID, ':Devices' => $devices, ':Message' => $message, 
                ':Sound' => $sound, ':Badge' => $badge, ':KeyValue' => $extra_data==null?null:json_encode($extra_data),
                ':ECardNos' => implode(',',$ECardNos),':Date'=>$options['date'], ':MUserID'=>$muserid,':MRole'=>$mrole));
            
            $lastInsertID = $this->dbh->lastInsertId();
            
            if(count($ECardNos)>0)
            {
                if ($devices==3)
                        $sql="INSERT INTO `MessageQueue`"
                            ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                            ."(SELECT :BatchID,null, `RegistrationID` FROM `AndroidDevices` where `EcardNo`=:EcardNo and `Activate`=1)"
                            ."union"
                            ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` where `EcardNo`=:EcardNo and `Activate`=1);";
                else if ($devices==1)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` where `EcardNo`=:EcardNo and `Activate`=1);";
                else if ($devices==2)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,null, `RegistrationID` FROM `AndroidDevices` where `EcardNo`=:EcardNo and `Activate`=1)";
                $sth = $this->dbh->prepare($sql);
                foreach($ECardNos as $val)
                {
                    if(!$sth->execute(array(':BatchID' =>$lastInsertID, ':EcardNo' => $val)))
                    {
                        $this->dbh->rollback();
                        return -1;
                    }
                }
            }
            $this->dbh->commit();
            return $lastInsertID;
        }catch (PDOException $e) {
            // roll back transaction
            $this->dbh->rollback();
            return -1;
        }
    }
    
    public function filterByPlace($userID,$devices,$message,$extra_data,$sound,$badge,$country,$city,$options) {
        
        $this->dbh->beginTransaction();

        try {
            if(isset($options['merchant'])){
                $muserid=$options['merchant']['MUserID'];
                $mrole=$options['merchant']['MRole'];
            } else {
                $mrole=null;
                $muserid=null;
            }
            $sql = "INSERT INTO `MessageBatch`"
                    ."(`UserID`,`Devices`,`Message`,`Sound`,`Badge`,`KeyValue`,`Country`,`City`,`PublishDate`,`MUserID`,`MRole`)"
                    ."VALUES"
                    ."(:UserID, :Devices, :Message,:Sound,:Badge,:KeyValue,:Country,:City,:Date,:MUserID,:MRole);";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':UserID' =>$userID, ':Devices' => $devices, ':Message' => $message, 
                ':Sound' => $sound, ':Badge' => $badge, ':KeyValue' => $extra_data==null?null:json_encode($extra_data),
                ':Country' => $country,':City' =>$city,':Date'=>$options['date'], ':MUserID'=>$muserid,':MRole'=>$mrole));
            
            $lastInsertID = $this->dbh->lastInsertId();
            if(empty($country)==false && empty($city))
            {
                if ($devices==3)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,null, `RegistrationID` FROM `AndroidDevices` where `Country`=:Country and `Activate`=1)"
                        ."union"
                        ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` where `Country`=:Country and `Activate`=1);";
                else if ($devices==1)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` where `Country`=:Country and `Activate`=1);";
                else if ($devices==2)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,null, `RegistrationID` FROM `AndroidDevices` where `Country`=:Country and `Activate`=1)";
                $sth = $this->dbh->prepare($sql);
                if (!$sth->execute(array(':BatchID' =>$lastInsertID, ':Country' => $country)))
                {
                    $this->dbh->rollback();
                    return -1;
                }
            }else if(!empty($city) && empty($country))
            {
                if ($devices==3)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,null, `RegistrationID` FROM `AndroidDevices` where `City`=:City and `Activate`=1)"
                        ."union"
                        ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` where `City`=:City and `Activate`=1);";
                else if ($devices==1)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` where `City`=:City and `Activate`=1);";
                else if ($devices==2)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,null, `RegistrationID` FROM `AndroidDevices` where `City`=:City and `Activate`=1)";
                $sth = $this->dbh->prepare($sql);
                if(!$sth->execute(array(':BatchID' =>$lastInsertID, ':City' => $city))){
                    $this->dbh->rollback();
                    return -1;
                }
            }else if(!empty($city) && !empty($country))
            {
                if ($devices==3)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,null, `RegistrationID` FROM `AndroidDevices` where `Country`=:Country and `City`=:City and `Activate`=1)"
                        ."union"
                        ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` where `Country`=:Country and `City`=:City and `Activate`=1);";
                else if ($devices==1)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` where `Country`=:Country and `City`=:City and `Activate`=1);";
                else if ($devices==2)
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,null, `RegistrationID` FROM `AndroidDevices` where `Country`=:Country and `City`=:City and `Activate`=1)";
                $sth = $this->dbh->prepare($sql);
                if(!$sth->execute(array(':BatchID' =>$lastInsertID, ':City' => $city, ':Country' => $country))){
                    $this->dbh->rollback();
                    return -1;
                }
            }
            
            $this->dbh->commit();
            return $lastInsertID;
        }catch (PDOException $e) {
            // roll back transaction
            $this->dbh->rollback();
            return -1;
        }
    }
    
    public function filterByDistance($userID,$devices,$message,$extra_data,$sound,$badge,$longitude,$latitude,$distance,$options) {
        $this->dbh->beginTransaction();
        try {
            if(isset($options['merchant'])){
                $muserid=$options['merchant']['MUserID'];
                $mrole=$options['merchant']['MRole'];
            } else {
                $mrole=null;
                $muserid=null;
            }
            $sql = "INSERT INTO `MessageBatch`"
                    ."(`UserID`,`Devices`,`Message`,`Sound`,`Badge`,`KeyValue`,`Longitude`,`Latitude`,`Distance`,`PublishDate`,`MUserID`,`MRole`)"
                    ."VALUES"
                    ."(:UserID, :Devices, :Message,:Sound,:Badge,:KeyValue, :Longitude,:Latitude,:Distance,:Date,:MUserID,:MRole);";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':UserID' =>$userID, ':Devices' => $devices, ':Message' => $message,
                ':Sound' => $sound, ':Badge' => $badge, ':KeyValue' => $extra_data==null?null:json_encode($extra_data), 
                 ':Longitude' => $longitude, ':Latitude' => $latitude, ':Distance' => $distance,':Date' => $options['date'], ':MUserID'=>$muserid,':MRole'=>$mrole));
            
            $lastInsertID = $this->dbh->lastInsertId();
            
            if(is_numeric($longitude) && is_numeric($latitude) && is_numeric($distance))
            {
                    $sql="INSERT INTO `MessageQueue`"
                        ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                        ."(SELECT :BatchID,null, `RegistrationID` FROM AndroidDevices WHERE  (6371 * acos(cos(radians(:Latitude)) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(:Longitude)) + sin(radians(:Latitude)) * sin(radians(Latitude)))) < :Distance OR (Latitude=:Latitude and Longitude=:Longitude) AND `Activate`=1)"
                        ."union"
                        ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` WHERE  (6371 * acos(cos(radians(:Latitude)) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(:Longitude)) + sin(radians(:Latitude)) * sin(radians(Latitude)))) < :Distance OR (Latitude=:Latitude and Longitude=:Longitude) AND `Activate`=1)";
                    $sth = $this->dbh->prepare($sql);
                    if(!$sth->execute(array(':BatchID' =>$lastInsertID, ':Distance' => $distance,':Latitude' => $latitude,':Longitude' => $longitude))){
                        $this->dbh->rollback();
                        return -1;
                   }
                            
            }  else {
                return 0;
            }
            
            $this->dbh->Commit();
            return $lastInsertID;
        }catch (PDOException $e) {
            $this->dbh->rollback();
            return -1;
        }
    }
    
    public function submitToAll($userID,$devices,$message,$extra_data,$sound,$badge,$options) {
        
        $this->dbh->beginTransaction();
        try {
            if(isset($options['merchant'])){
                $muserid=$options['merchant']['MUserID'];
                $mrole=$options['merchant']['MRole'];
            } else {
                $mrole=null;
                $muserid=null;
            }
            $sql = "INSERT INTO `MessageBatch`"
                    ."(`UserID`,`Devices`,`Message`,`Sound`,`Badge`,`KeyValue`,`PublishDate`,`MUserID`,`MRole`)"
                    ."VALUES"
                    ."(:UserID, :Devices, :Message,:Sound,:Badge,:KeyValue,:Date,:MUserID,:MRole);";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':UserID' =>$userID, ':Devices' => $devices, ':Message' => $message,
                ':Sound' => $sound, ':Badge' => $badge, ':KeyValue' => $extra_data==null?null:json_encode($extra_data),':Date'=>$options['date'], ':MUserID'=>$muserid,':MRole'=>$mrole));
            
            $lastInsertID = $this->dbh->lastInsertId();
            
            if ($devices==3)
                $sql="INSERT INTO `MessageQueue`"
                    ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                    ."(SELECT :BatchID, null, `RegistrationID` FROM AndroidDevices WHERE `Activate`=1)"
                    ."union"
                    ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` WHERE  `Activate`=1)";
            else if ($devices==1)
                $sql="INSERT INTO `MessageQueue`"
                    ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                    ."(SELECT :BatchID,`DeviceToken`, null FROM `AppleDevices` WHERE  `Activate`=1)";
            else if ($devices==2)
                $sql="INSERT INTO `MessageQueue`"
                    ."(`BatchID`,`DeviceToken`,`RegistrationID`)"
                    ."(SELECT :BatchID, null, `RegistrationID` FROM AndroidDevices WHERE `Activate`=1)";
            
            $sth = $this->dbh->prepare($sql);
            if($sth->execute(array(':BatchID' =>$lastInsertID))){
                $this->dbh->commit();
                return $lastInsertID;
            }
            else {
                $this->dbh->rollback();
                return -1;
            }
            
        }catch (PDOException $e) {
            $this->dbh->rollback();
            return -1;
        }
    }    

    public function getBatchDetails($userID,$batchID,$type){
        if($type==1 || $type==0){
            $sql = "SELECT mb.Status,mb.`PublishDate`, mb.`BatchID`, mb.`Devices`, mb.`Message`, mb.`Sound`, mb.`Badge`,mb.KeyValue,mb.ECardNos, mb.`Country`, `City`, `Longitude`, `Latitude`, `Distance`, u.Name , u.DisplayName, (select count(*) from MessageQueue where `BatchID`=:BatchID and `DeviceToken` is not null) as AppleCount,(select count(*) from MessageQueue where `BatchID`=:BatchID and `RegistrationID` is not null) as AndroidCount FROM (SELECT * FROM MessageBatch WHERE BatchID=:BatchID) as mb join Users u on u.UserID=mb.UserID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':BatchID'=>$batchID));
        }else {
            $sql = "SELECT mb.Status,mb.`PublishDate`, mb.`BatchID`, mb.`Devices`, mb.`Message`, mb.`Sound`, mb.`Badge`,mb.KeyValue,mb.ECardNos, mb.`Country`, `City`, `Longitude`, `Latitude`, `Distance`, u.Name , u.DisplayName, (select count(*) from MessageQueue where `BatchID`=:BatchID and `DeviceToken` is not null) as AppleCount,(select count(*) from MessageQueue where `BatchID`=:BatchID and `RegistrationID` is not null) as AndroidCount FROM (SELECT * FROM MessageBatch WHERE `UserID`=:UserID and BatchID=:BatchID ) as mb join Users u on u.UserID=mb.UserID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':UserID'=>$userID,':BatchID'=>$batchID));
        }

            $rs= $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($rs)>0)
                return $rs[0];
            else throw new Exception('Invalid batch ID or user do not have permitions to do this operation');
    }
    
    public function approveBatch($userID,$batchID,$type){
        try
        {
            $batch=$this->getBatchDetails($userID,$batchID,$type);
            if($batch['Status']==0){
                if($type==1 || $type==0){
                    $sql = "UPDATE `MessageBatch` SET `Status` = 1, `ReviewedBy`=:UserID WHERE BatchID=:BatchID;";
                    $sth = $this->dbh->prepare($sql);
                    $sth->execute(array(':UserID'=>$userID,':BatchID'=>$batchID));
                }else {
                    $sql = "UPDATE `MessageBatch` SET `Status`, `ReviewedBy`=:UserID = 1 WHERE BatchID=:BatchID AND UserID=:UserID;";
                    $sth = $this->dbh->prepare($sql);
                    $sth->execute(array(':UserID'=>$userID,':BatchID'=>$batchID));
                }
                $rs= $sth->fetchAll(PDO::FETCH_ASSOC);
                return $rs;
            } else {
                throw new Exception('Batch is already sent');
            }
            
        }catch (PDOException $ex)
        {
            throw new Exception('DB Exception. User might not have permitions to do this operation');
        }
    }
    
    public function getAllPendingBatches($userID,$type){
        /* Response Parameters
        `BatchID`
        `UserID`
        `ReviewedBy`
        `Devices`
        `Message`
        `Sound`
        `Badge`
        `KeyValue`
        `ECardNos`
        `Country`
        `City`
        `Longitude`
        `Latitude`
        `Distance`
        `Status`
        `DateCreated`
        `DatePublished`
         */
        if($type==1 || $type==0){
            $sql = "SELECT mb.`BatchID`, mb.`Devices`, mb.`Message`, mb.`Sound`, mb.`Badge`,mb.`Country`, `City`, `Longitude`, `Latitude`, `Distance`, u.Name,u.DisplayName,mb.MUserID,mb.MRole,mb.PublishDate FROM (SELECT * FROM MessageBatch WHERE `Status`=0) as mb join Users u on u.UserID=mb.UserID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
        }else {
            $sql = "SELECT `BatchID`, `Devices`, `Message`, `Sound`, `Badge`, `KeyValue`, `ECardNos`,`Country`, `City`, `Longitude`, `Latitude`, `Distance`, u.Name,u.DisplayName,mb.MUserID,mb.MRole,mb.PublishDate FROM (SELECT * FROM MessageBatch WHERE `UserID`=:UserID `Status`=0) as mb join Users u on u.UserID=mb.UserID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':UserID'=>$userID));
        }

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllReviewedBatches(){
        $date=gmdate('Y-m-d H:i:s');
        $sql = "SELECT * FROM MessageBatch WHERE `Status`=1 and (`PublishDate` is null OR `PublishDate`<='$date')";
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getReviewedAppleDevices($batchID){
        $sql = "SELECT MQ.DeviceToken FROM (SELECT * FROM MessageQueue WHERE `Status`= 0 and (DeviceToken is not null) and BatchID=:BatchID) MQ JOIN (SELECT * FROM AppleDevices WHERE (NoAlertTimeStart is null OR NoAlertTimeEnd is null) OR (NoAlertTimeStart <= utc_timestamp() and NoAlertTimeEnd >= utc_timestamp()) ) AD on AD.DeviceToken=MQ.DeviceToken;";
        $sth = $this->dbh->prepare($sql);
        $sth->execute(array(':BatchID'=>$batchID));
        return $sth->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    
    public function getReviewedAndroidDevices($batchID){
        $sql = "SELECT MQ.RegistrationID FROM (SELECT * FROM MessageQueue WHERE `Status`= 0 and (RegistrationID is not null) and BatchID=:BatchID) MQ JOIN (SELECT * FROM AndroidDevices WHERE (NoAlertTimeStart is null OR NoAlertTimeEnd is null) OR (NoAlertTimeStart <= utc_timestamp()  and NoAlertTimeEnd >= utc_timestamp()) ) AD on AD.RegistrationID=MQ.RegistrationID;";
        $sth = $this->dbh->prepare($sql);
        $sth->execute(array(':BatchID'=>$batchID));
        return $sth->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    
    public function finishBatch($batchID){
        try
        {
            if (!is_numeric($batchID)) Exception('Invalid Batch ID');
            $sql = "UPDATE `MessageBatch` SET `Status` = 3 WHERE BatchID=:BatchID;";
            $sth = $this->dbh->prepare($sql);
            if($sth->execute(array(':BatchID'=>$batchID)))
            {
                $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
                return true;
            } else throw new Exception('DB Exception. User might not have permitions to do this operation');
        }catch (PDOException $ex)
        {
            throw new Exception('DB Exception. User might not have permitions to do this operation');
        }
    }
    
    public function setWorkingBatch($batchID){
        try
        {
            if (!is_numeric($batchID)) Exception('Invalid Batch ID');
            $sql = "UPDATE `MessageBatch` SET `Status` = 2 WHERE BatchID=:BatchID;";
            $sth = $this->dbh->prepare($sql);
            if($sth->execute(array(':BatchID'=>$batchID)))
            {
                $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
                return true;
            } else throw new Exception('DB Exception. User might not have permitions to do this operation');
        }catch (PDOException $ex)
        {
            throw new Exception('DB Exception. User might not have permitions to do this operation');
        }
    }
}

?>
