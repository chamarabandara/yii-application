<?php

/**
 * Description of PushManager
 *
 * @author dasun
 */
require_once 'DataUsers.php';
require_once 'DataMessages.php';
/*require_once 'RabbitMQ.php';*/
class PushManager {
    const NONE = 0;
    const DISTANCE = 1;
    const ECARD = 2;
    const PLACE = 3;
    
    const DEVICES_IOS = 1;
    const DEVICES_ANDROID = 2;
    const DEVICES_BOTH = 3;
    
    const PAYLOAD_MAXIMUM_SIZE = 256; /**< @type integer The maximum size allowed for a notification payload. */
    const APPLE_RESERVED_NAMESPACE = 'aps'; /**< @type string The Apple-reserved aps namespace. */

    protected $_filters;
    protected $_filterType;
    protected $_user_id;
    protected $_user_type;
    protected $_devices;
    protected $_message;
    protected $_sound;
    protected $_publishTime;
    protected $_badge;
    protected $_data;
    protected $_merchant;
    
    
    public function __construct($user_id){
        if(is_numeric($user_id))
        {
            $user = DataUsers::getInstance()->getUserByID($user_id);
            if(is_object($user))
            {
                $this->_user_id = $user_id;
                $this->_user_type = $user->Type;
                $this->_publishTime = null;
            } else throw new Exception('Invalid or missing parameter(s).');
        } else  throw new Exception('Invalid or missing parameter(s).');
    }
    
    public function setDevices($devices)
    {
        if(is_numeric($devices))
        {
            if ($devices==1 || $devices==2 || $devices==3)
                $this->_devices  = $devices;
            else  throw new Exception('Invalid or missing parameter(s).');
        } else  throw new Exception('Invalid or missing parameter(s).');
    }
    
    public function setMessage($message,$sound=null,$badge=null,$data=null){
        if(!is_null($message)){
            if(trim($message)=="") throw new Exception("Message parameter is empty.");
            if(!is_null($data) && !is_array($data)) throw new Exception("Data parameter shoud be an array.");
            $this->_message  = $message;
            $this->_sound = $sound;
            $this->_badge  = $badge;
            $this->_data = $data;
        } 
    }
    
    public function setFilters($filterType,$filters=null){
        if($filterType==self::ECARD){
            if(is_array($filters))
            {
                $this->_filters = $filters;
                $this->_filterType = $filterType;
            }else throw new Exception("Invalid or missing parameter(s).");
        }else if($filterType==self::DISTANCE){
            if(is_array($filters))
            {
                if(array_key_exists('distance',$filters) && array_key_exists('latitude',$filters) && array_key_exists('longitude',$filters))
                {
                    if(is_numeric($filters['distance']) && is_numeric($filters['latitude']) && is_numeric($filters['longitude']))
                    {
                        $this->_filters = $filters;
                        $this->_filterType = $filterType;
                    }
                    else throw new Exception("Invalid or missing parameter(s).");
                } else throw new Exception("Invalid or missing parameter(s).");
            }else throw new Exception("Invalid or missing parameter(s).");
        }else if($filterType==self::PLACE){
            if(is_array($filters))
            {
                if(array_key_exists('country',$filters) && array_key_exists('city',$filters))
                {
                    if(!is_null($filters['country']))
                    {
                        $this->_filters = $filters;
                        $this->_filterType = $filterType;
                    }
                    else throw new Exception("Invalid or missing parameter(s).");
                } else throw new Exception("Invalid or missing parameter(s).");
            }else throw new Exception("Invalid or missing parameter(s).");
        }else if($filterType==self::NONE){
            $this->_filterType = $filterType;
        } else {
            throw new Exception("Invalid or missing parameter(s).");
        }
    }
    
    public function submit()
    {
        if(!$this->isValid()) throw new Exception("Message exceeded the maximum length.");
        if(is_null($this->_filterType)) throw new Exception("The Filter Type is not defined.");
        $options = array('date'=> $this->_publishTime,'merchant'=>$this->_merchant);
        $filters=$this->_filters;
        if($this->_filterType==self::NONE)
        {
            $res=DataMessages::getInstance()->submitToAll($this->_user_id,$this->_devices,$this->_message,$this->_data,$this->_sound,$this->_badge,$options);
            if (is_numeric($res))
                if ($res>0)
                    return $res;
                else throw new Exception("DB Exception.");
            else throw new Exception("DB Exception.");
        }else if($this->_filterType==self::PLACE)
        {
            $res=DataMessages::getInstance()->filterByPlace($this->_user_id,$this->_devices,$this->_message,$this->_data,$this->_sound,$this->_badge,$filters['country'],$filters['city'],$options);
            if (is_numeric($res))
                if ($res>0)
                    return $res;
                else throw new Exception("DB Exception.");
            
            else throw new Exception("DB Exception.");
        }else if($this->_filterType==self::DISTANCE)
        {
            $res=DataMessages::getInstance()->filterByDistance($this->_user_id,$this->_devices,$this->_message,$this->_data,$this->_sound,$this->_badge,$filters['longitude'],$filters['latitude'],$filters['distance'],$options);
            if (is_numeric($res))
                if ($res>0)
                    return $res;
                else throw new Exception("DB Exception.");
            else throw new Exception("DB Exception.");
        }else if($this->_filterType==self::ECARD)
        {
            $res=DataMessages::getInstance()->filterByEcard($this->_user_id,$this->_devices,$this->_message,$this->_data,$this->_sound,$this->_badge,$filters,$options);
            if (is_numeric($res))
                if ($res>0)
                    return $res;
                else throw new Exception("DB Exception.");
            else throw new Exception("DB Exception.");
        }  else throw new Exception("Unhandled Exception.");
    }
    
    public function approveBatch($batchID){
        try{
         DataMessages::getInstance()->approveBatch($this->_user_id,$batchID, $this->_user_type);
         }catch(Exception $e) {
            throw $e;
        }
        /*try{
         $rb = new RabbitMQ();
         $rb->send('send');
        }catch(Exception $ex){   
        }*/
        
        try {
            $this->http_response('http://dt-notification.allioncloud.net/info.php');
        } catch (Exception $ex) {
            echo $ex;
        }

    }
    
    function http_response($url, $status = null) {

        // we fork the process so we don't have to wait for a timeout 
            // we are the parent 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $head = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (!$head) {
                return FALSE;
            }

            if ($status === null) {
                if ($httpCode < 400) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($status == $httpCode) {
                return TRUE;
            }

            return FALSE;
        
    }

    //Optional: Set a date and time to deliver messages using m/d/Y H:i(12/30/2012 22:56) format.
    public function setDeliveryTime($time){
      $date = DateTime::createFromFormat('m/d/Y H:i', $time);
      if ($date == false || !(date_format($date,'m/d/Y H:i') == $time) ) 
       return false;
      else
        $this->_publishTime=$date->format('Y-m-d H:i:s');
    }
    
    public function setMerchant($userID,$role){
        $this->_merchant= array('MUserID'=>$userID,'MRole'=>$role);
    }
    
    protected function _getPayload()
    {
            $aPayload[self::APPLE_RESERVED_NAMESPACE] = array();

            if (isset($this->_message)) {
                    $aPayload[self::APPLE_RESERVED_NAMESPACE]['alert'] = (string)$this->_message;
            }
            if (isset($this->_badge) && $this->_badge > 0) {
                    $aPayload[self::APPLE_RESERVED_NAMESPACE]['badge'] = (int)$this->_badge;
            }
            if (isset($this->_sound)) {
                    $aPayload[self::APPLE_RESERVED_NAMESPACE]['sound'] = (string)$this->_sound;
            }

            if (is_array($this->_data)) {
                    foreach($this->_data as $sPropertyName => $mPropertyValue) {
                            $aPayload[$sPropertyName] = $mPropertyValue;
                    }
            }

            return $aPayload;
    }

    /**
     * Convert the message in a JSON-encoded payload.
     *
     * @throws ApnsPHP_Message_Exception if payload is longer than maximum allowed
     *         size and AutoAdjustLongPayload is disabled.
     * @return @type string JSON-encoded payload.
     */
    private function isValidPushPayload()
    {
            $sJSONPayload = str_replace(
                    '"' . self::APPLE_RESERVED_NAMESPACE . '":[]',
                    '"' . self::APPLE_RESERVED_NAMESPACE . '":{}',
                    json_encode($this->_getPayload())
            );
            $nJSONPayloadLen = strlen($sJSONPayload);

            if ($nJSONPayloadLen > self::PAYLOAD_MAXIMUM_SIZE) {
                   return false;
            } else return true;
    }
    
    private function isValidGCMPayload()
    {
        
        $data = array();
        if (isset($this->_badge))
            $data['badge'] = $this->_badge;
        if (isset($this->_message))
            $data['message'] = $this->_message;
        if (isset($this->_data))
            $data['extradata'] = $this->_data;
        $json = json_encode($data);
        if (strlen($json)>4000)
        {
            return false;
        } else return true;
    }
    
    public function isValid()
    {
        if(is_null($this->_devices)) throw new Exception("Target devices are not set.");
        if(is_null($this->_message)) throw new Exception("The message is not set.");
        
        if($this->_devices==self::DEVICES_BOTH || $this->_devices==self::DEVICES_IOS)
        {
            return $this->isValidPushPayload();
        }  else {
            return $this->isValidGCMPayload();
        }
    }
}

?>
