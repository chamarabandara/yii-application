<?php
require_once __DIR__ . "/../include/config.php";
abstract class DataService
{
    //database connection handler
    protected $dbh;
    

    protected function __construct(){

         $this->connectMe();

    }
    public function connectMe(){
        $dbHost = DBHOST;
        $dbName = DBNAME;
        $dbUser = DBUSERNAME;
        $dbPass = DBPASSWORD;
        $this->dbh=null;
        try {

            $this->dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

            //echo "<br/>Connected to database";
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }
    final public static function getInstance()
    {
        static $instances = array();
        $calledClass = get_called_class();

        if (!isset($instances[$calledClass]))
        {
            $instances[$calledClass] = new $calledClass();
        }
        $theClass=$instances[$calledClass];
        if ($theClass->dbh) {
            $theClass->connectMe();
        }
        return $theClass;
    }

    // Prevent users to clone the singleton instance
    final private function __clone() {
        trigger_error('\nClone is not allowed.', E_USER_ERROR);
    }
    
    protected function destruct(){
        //close the DB connection
        $this->dbh = null;
    }
}
?>
