<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if(isset($_POST['SEARCH_DATA'])){
        return ['kishan','shrestha'];
        $kali->kaliReply(['kishan','shrestha']);
    }

}catch(Exception $e){
    die('Error Caught '.$e->getMessage());
}   
