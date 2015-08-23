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

class DataOperations extends DataService {

    public function getCity($where) {
        $where = str_replace("'", "''", $where);
        $sql = "select DISTINCT * from ((Select DISTINCT City From AndroidDevices Where `City` Like '%$where%' Limit 500) Union (Select DISTINCT City From AppleDevices Where `City` Like '%$where%' Limit 500)) as ss ;";
        //echo $sql;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        $array = $sth->fetchAll(PDO::FETCH_COLUMN);

        $bulk['city'] =  $array;
        
        return $bulk;
    }
    public function getCountry($where) {
        $where = str_replace("'", "''", $where);
        $sql = "select DISTINCT * from ((Select DISTINCT Country From AndroidDevices Where `Country` Like '%$where%' Limit 500) Union (Select DISTINCT Country From AppleDevices Where `Country` Like '%$where%' Limit 500)) as ss ;";
        //echo $sql;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        $array = $sth->fetchAll(PDO::FETCH_COLUMN);

        $bulk['city'] =  $array;
        
        return $bulk;
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
