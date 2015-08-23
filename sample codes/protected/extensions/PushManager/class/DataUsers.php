<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataUsers
 *
 * @author dasun
 */
include_once 'DataService.php';

class DataUsers extends DataService {
    
    public function createUser($username,$password,$display,$devices=0,$type=1) {
        $type = $type==0 ? 1:$type;
        
        $sql = "INSERT INTO `Users` (`Name`,`Password`,`Type`,`Devices`,`DisplayName`) VALUES (:username,:password,:type,:devices,:display);";
        $sth = $this->dbh->prepare($sql);
        
        $rt = $sth->execute(array(':username' => $username,':password'=>md5($password),':type'=>$type,':devices'=>$devices,':display'=> $display));
        return $rt;
    }
    
    
    public function getUser($username,$password) {
        $password=md5($password);
        $username=strtolower($username);
        $sql = "SELECT `Users`.`UserID`, `Users`.`Name`, `Users`.`DisplayName`, `Users`.`Type`, `Users`.`Devices` FROM `Users` WHERE `IsActive`='1' AND Name=:username AND Password=:password";
        //echo $sql;
        $sth = $this->dbh->prepare($sql);
        
        if($sth->execute(array(':username' => $username,':password'=>$password)))
        {
            if ($sth->rowCount()==1)
                return $sth->fetch(PDO::FETCH_OBJ);
            else return false;
        } else false;
    }
    
    public function getUserByID($userid) {
        $sql = "SELECT `Users`.`UserID`, `Users`.`Name`, `Users`.`DisplayName`, `Users`.`Type`, `Users`.`Devices`, `Users`.`IsActive` FROM `Users` WHERE `UserID`=:userid";
        //echo $sql;
        $sth = $this->dbh->prepare($sql);
        
        if($sth->execute(array(':userid' => $userid)))
        {
            if ($sth->rowCount()==1)
            {
                return $sth->fetch(PDO::FETCH_OBJ);
            }
            else return false;
        } else false;
    }
    
    public function userCount($username) {
        $sql = "SELECT `Users`.`UserID`, `Users`.`Name`, `Users`.`DisplayName`, `Users`.`Type`, `Users`.`Devices`, `Users`.`IsActive` FROM `Users` WHERE `Type`!=0 AND `Name`=:username";
        //echo $sql;
        $sth = $this->dbh->prepare($sql);
        
        if($sth->execute(array(':username' => strtolower($username))))
        {
            return $sth->rowCount();
        } else {
            return -1;
        }
        
    }
    
    public function updateUser($userid,$display,$type,$devices,$isactive) {
        $sql = "UPDATE `push`.`Users` SET `DisplayName` = :display, `Type` = :type, `Devices` = :devices, `IsActive` = :isactive WHERE UserID=:userid;";
        $sth = $this->dbh->prepare($sql);
        
        if($sth->execute(array(':userid' => $userid,':display' => $display,':type'=>$type,':devices'=>$devices, ':isactive' => $isactive)))
        {
            return true;
        } else false;
    }
    
    public function getAllUser() {
        $sql = "SELECT `Users`.`UserID`, `Users`.`Name`, `Users`.`DisplayName`, `Users`.`IsActive`, `Users`.`Type`, `Users`.`Devices` FROM `Users` WHERE Type!='0'";
        $sth = $this->dbh->prepare($sql);
        if($sth->execute())
        {
                return $sth->fetchAll(PDO::FETCH_OBJ);
        } else return false;
    }
    
    /*
    set @lat=8;
    set @lon=55.30001;
    SELECT
        DeviceId,
        (6371 * acos(cos(radians(@lat)) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(@lon)) + sin(radians(@lat)) * sin(radians(Latitude)))) AS distance
    FROM
    AndroidDevices;
     */

}

?>
