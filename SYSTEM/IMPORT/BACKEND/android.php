<?php 

require_once 'kali.php';

class Android extends kali{
    

    function userSearch($aData){

        if(!isset($aData["USER_REFID"])){

        }

        return ['MSG'=>'KISHAN'];


    } 
}


$andro = new Android();
