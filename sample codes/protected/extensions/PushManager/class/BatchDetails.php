<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BatchDetails
 *
 * @author dasun
 */
include_once 'DataService.php';
class BatchDetails extends DataService {
        
    const DEVICES_IOS = 1;
    const DEVICES_ANDROID = 2;
    const DEVICES_BOTH = 3;
    const DEVICES_ANY = 0;
    
    const STATUS_PENDING = 0;
    const STATUS_REVIEWED = 1;
    const STATUS_SENDING = 2;
    const STATUS_SENT = 3;
    const STATUS_ANY = -1;
    
    protected $_filters;
    protected $_pagesize;
    protected $_user_id;
    protected $_user_type;
    protected $_devices;
    protected $_status;
    
    
    public function setUser($user_id)
    {
        if(is_numeric($user_id))
        {
            $user = DataUsers::getInstance()->getUserByID($user_id);
            if(is_object($user))
            {
                $this->_user_id = $user_id;
                $this->_user_type = $user->Type;
                $this->_devices = self::DEVICES_ANY;
                $this->_filters = array();
                $this->_status = self::STATUS_ANY;
            } else throw new Exception('Invalid or missing parameter(s).');
        } else  throw new Exception('Invalid or missing parameter(s).');
    }
    
    public function setDevices($devices = self::DEVICES_ANY)
    {
        if(is_numeric($devices))
        {
            if ($devices==1 || $devices==2 || $devices==3 || $devices==0)
                $this->_devices  = $devices;
            else  throw new Exception('Invalid or missing parameter(s).');
        } else  throw new Exception('Invalid or missing parameter(s).');
    }
    
    public function setStatus($status = self::STATUS_ANY)
    {
        if(is_numeric($status))
        {
            if ($status==0 || $status==1 || $status==2 || $status == 3)
                $this->_status  = $status;
            else  throw new Exception('Invalid or missing parameter(s).');
        } else  throw new Exception('Invalid or missing parameter(s).');
    }
    
    public function setDateRange($strat,$end=null)
    {
      if($strat){
        $date = DateTime::createFromFormat('m/d/Y H:i', $strat);
        if ($date == false || !(date_format($date,'m/d/Y H:i') == $strat) ) 
         throw new Exception('Invalid or missing parameter(s).');
        else
          $start=$date->format('Y-m-d H:i:s');
      }
      
      if($end){
        $date = DateTime::createFromFormat('m/d/Y H:i', $end);
        if ($date == false || !(date_format($date,'m/d/Y H:i') == $end) ) 
         throw new Exception('Invalid or missing parameter(s).');
        else
          $end=$date->format('Y-m-d H:i:s');
      }
      $this->_filters['dates'] = array('start'=>$start,'end'=>$end);
    }
    
    public function setDate($thedate)
    {
      if($thedate){
        $date = DateTime::createFromFormat('m/d/Y', $thedate);
        if ($date == false || !(date_format($date,'m/d/Y') == $thedate) ) 
         throw new Exception('Invalid or missing parameter(s).');
      }
      $thedate=$date->format('m/d/Y 00:00');
      $date->add(new DateInterval('P1D'));
      $this->setDateRange($thedate,$date->format('m/d/Y 00:00'));
    }
    
    public function setMerchant($userID,$role){
        $this->_filters['merchant']= array('MUserID'=>$userID,'MRole'=>$role);
    }
    
    public function getCount(){
        
    }
           
    
    public function getResult(){
        if(!is_numeric($this->_user_id))  throw new Exception('Please set a user id using \'setUser\' before calling this function.');
        $filters=array();
        if(isset($this->_filters['merchant'])){
            if($this->_filters['merchant']['MUserID'])
                $filters[] ="`MUserID` = '". $this->_filters['merchant']['MUserID']."'";
            if($this->_filters['merchant']['MRole'])
                $filters[] ="`MRole`= '".$this->_filters['merchant']['MRole']."'";
        }
        if(isset($this->_filters['dates']))
        {
            if($this->_filters['dates']['end'])
                $filters[] ="`DateCreated` < '". $this->_filters['dates']['end']."'";
            if($this->_filters['dates']['start'])
                $filters[] ="`DateCreated` >= '". $this->_filters['dates']['start']."'";
        }
        
        if($this->_devices>0)
        {
            $filters[] ="`Devices` = '". $this->_devices."'";
        }
        
        if($this->_status > -1)
            $filters[] ="`Status`='".$this->_status."'";
        
        $filterstr = '';
            
        if($this->_user_type==1 || $this->_user_type==0){
            //$this->connectMe();   
            
            if(count($filters)>0)
                $filterstr =  ' WHERE '.implode(' AND ', $filters); 
                    
            $sql = "SELECT mb.`BatchID`, mb.`Devices`, mb.`Message`, mb.`Sound`, mb.`Badge`,mb.`Country`, `City`, `Longitude`, `Latitude`, `Distance`, u.UserID , u.Name,u.DisplayName,mb.MUserID,mb.MRole,mb.PublishDate,mb.DateCreated as CreatedDate FROM (SELECT * FROM MessageBatch $filterstr ) as mb join Users u on u.UserID=mb.UserID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
        }else {
            if(count($filters)>0)
                $filterstr = ' AND '. implode(' AND ', $filters);
            $sql = "SELECT mb.`BatchID`, mb.`Devices`, mb.`Message`, mb.`Sound`, mb.`Badge`,mb.`Country`, `City`, `Longitude`, `Latitude`, `Distance`, u.UserID, u.Name,u.DisplayName,mb.MUserID,mb.MRole,mb.PublishDate,mb.DateCreated as CreatedDate FROM (SELECT * FROM MessageBatch WHERE `UserID`=:UserID $filterstr) as mb join Users u on u.UserID=mb.UserID;";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array(':UserID'=>$this->_user_id));
        }

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
