<?php
namespace shiyang\qqlogin;

class QqConnect{

    public static function config(){
        session_start();
        define("ROOT",dirname(__FILE__)."/");
        define("CLASS_PATH",ROOT."class/");
        require_once 'lib\Qc.php';
    }

}


