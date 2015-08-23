<?php

/**
 * TK class file
 *
 * @author Malith
 * @copyright Copyright&copy; 2011 SoNET Systems
 */

/**
 * Toolkit class for shortcut methods
 *
 * @package am.admin.helpers
 */
class TK {

   /**
    * returns xml for extjs form pre loading
    *
    * @param array $elements
    * @return string
    */
   public static function generateXML($elements, $root) {
      header("content-type: text/xml");
      echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
      echo "<message success=\"true\">";
      echo "<".$root.">";
      foreach ($elements as $key=>$value) {
         echo "<".$key.">".$value."</".$key.">";
      }
      echo "</".$root.">";
      echo "</message>";
   }

   /**
    * checks the special $_POST variable for the specified key handling
    * null cases and optionally returning a default value
    *
    * @param string $key the key to look for
    * @param mixed $default a default value to return if the key is not set
    * @param boolean $checkTextNull whether to treat the string "null" as a null value
    * @return mixed
    */
   public static function post($key, $default = NULL, $checkTextNull = false) {
      $res = isset($_POST[$key]) ? $_POST[$key] : $default;
      return $checkTextNull && $res == 'null' ? $default : $res;
   }

   /**
    * checks the special $_GET variable for the specified key handling
    * null cases and optionally returning a default value
    *
    * @param string $key the key to look for
    * @param mixed $default a default value to return if the key is not set
    * @param boolean $checkTextNull whether to treat the string "null" as a null value
    * @return mixed
    */
   public static function get($key, $default = NULL, $checkTextNull = false) {
      $res = isset($_GET[$key]) ? $_GET[$key] : $default;
      return $checkTextNull && $res == 'null' ? $default : $res;
   }

}
