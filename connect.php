<?php
class Connect{
    static $host='localhost';
    static $user='root';
    static $pw='';
    static $db='qrcode';
    public function selectdata($r){
        $cnx=new PDO("mysql:host=".self::$host.";dbname=".self::$db."",self::$user."",self::$pw);
        $e=$cnx->query($r);
        return $e;
    }
    public function updatedata($r){
        $cnx=new PDO("mysql:host=".self::$host.";dbname=".self::$db."",self::$user."",self::$pw);
        $e=$cnx->exec($r);
        return $e;
    }
}
?>