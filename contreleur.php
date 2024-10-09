<?php 
include 'connect.php';
class Contreleur{
    public function ajouter( $name, $phone, $email, $address){
        $c=new Connect();
        $e=$c->updatedata("INSERT INTO member (name, phone, email, address) VALUES ( $name, $phone, $email, $address)");
        return $e;
    }
}
?>