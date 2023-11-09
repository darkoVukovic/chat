<?php namespace App\Libraries;

use stdClass;

class Errors {
    CONST INFO = 1;
    CONST ERROR = 2;
    public $output;
    public static $instance;

    public static function getInstance() {
        if(self::$instance == null) self::$instance = new self;
         return self::$instance;
    }


    public  function error($obj, $type) {
        if($type == 1) {
            $message = "\033[34m".$obj->msg."\n";
        }

        else if($type == 2) {
            $message = 'red';
        }

        return ;
       
    } 

   
}

?>