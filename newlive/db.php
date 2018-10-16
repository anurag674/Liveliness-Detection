<?php
class Database 
{
    private static $dbName = 'disq' ; 
    private static $dbHost = 'localhost' ;
    //private static $dbUsername = 'root';
    private static $dbUsername = 'root';
     private static $dbUserPassword = 'hithere';

    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {      
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);  
        }
        catch(PDOException $e) 
        {
          die($e->getMessage());  
        }
       } 
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }

 }

   // function timedisplay($timevalue)
//    {
//       //$timevalue = new date($timevalue);
////          return $timevalue = date('H:i',$timevalue);
//        //return $timevalue =  date('H:i', $timevalue);
//
//
//    }
?>
