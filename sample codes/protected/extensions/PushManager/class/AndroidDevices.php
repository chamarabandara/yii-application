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

class AndroidDevices extends DataService {

    /**
     * Gets an array of devices
     * 
     * @param <int> $appId
     * @param <bool> $status
     * @return <array>
     */
    public function getDevices() {

        $sql = "SELECT * FROM AppleDevices WHERE Status='1'";

        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        $devicesArray = $sth->fetchAll(PDO::FETCH_OBJ);

        return $devicesArray;
    }

    private function isTokenValid($deviceToken) {
        //TODO: add validation method
        return true;
    }

    /**
     * Registers a device if it doesnt exist. Returns false if the deviceToken is not valid.
     *
     * @param <string> $deviceToken
     * @return <bool>
     */
    public function registerDevice($registrationID, $parameter_list) {
        try{
        $isTokenValid = $this->isTokenValid($registrationID);
        if (!$isTokenValid) {
            return false;
        }
        $fields = implode("`, `", array_keys($parameter_list));
        $fields = "`" . $fields . "`";
        $values = implode(", ", $parameter_list);
        $update='';
        foreach ($parameter_list as $key => $value) {
            $update.=", `$key`=$value";
        }
        $update=trim($update,',');

        $sql = "INSERT INTO AndroidDevices (`RegistrationID`,$fields) VALUES (:RegID,$values) ON DUPLICATE KEY UPDATE $update;";
        $sth = $this->dbh->prepare($sql);
        $sth->execute(array(':RegID'=>$registrationID));
        }catch (PDOException $e){
            return false;
        }

        return true;
    }
    
    public function removeDevice($registrationID) {
        try{
            $sql = "DELETE FROM `push`.`AndroidDevices` WHERE RegistrationID=:RegID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':RegID'=>$registrationID));
        }catch (PDOException $e){
            return false;
        }
        return true;
    }
    
    public function updateRegistrationID($oldRegID,$newRegID) {
        try{
            $sql = "UPDATE `push`.`AndroidDevices` SET `RegistrationID` =:NewRegID WHERE `RegistrationID` = :OldRegID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':NewRegID'=>$newRegID,':OldRegID'=>$oldRegID));
        }catch (PDOException $e){
            return false;
        }
        return true;
    }

    public function setFailedMessage($registrationID) {
        try{
            $sql = "UPDATE `MessageQueue` SET `Status` = 5 WHERE RegistrationID=:RegID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':RegID'=>$registrationID));
        }catch (PDOException $e){
            return false;
        }
        return true;
    }
    /**
     * Adds a message to the Queue
     * 
     * @param <int> $certificateId
     * @param <int> $deviceId
     * @param <string> $message
     * @param <int> $badge
     * @param <string> $sound
     */
    public function addMessage($certificateId, $deviceId, $message, $badge = NULL, $sound = NULL) {

        $timestamp = gmdate('Y-m-d H:i:s', time());

        $sql = "INSERT INTO MessageQueue (CertificateId, DeviceId, Message, Badge, Sound, DateAdded) VALUES (%d, %d, %s, %d, %s, %s)";
        $sql = sprintf($sql, (int) $certificateId, (int) $deviceId, $this->dbh->quote($message), (int) $badge, $this->dbh->quote($sound), $this->dbh->quote($timestamp));

        //echo '<br/>'. $sql;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
    }

}

?>
