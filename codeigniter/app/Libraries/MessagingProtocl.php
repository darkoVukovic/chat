<?php namespace App\Libraries;

use stdClass;

class MessagingProtocl {
    CONST INFO = 1;
    CONST ERROR = 2;
    public $output;
    public static $instance;

    public static function getInstance() {
        if(self::$instance == null) self::$instance = new self;
         return self::$instance;
    }


    public  function error($msgConstruct) {

        echo $msgConstruct->msg;
       
    } 


   
}

?>