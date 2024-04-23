<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if(isset($_POST['SEARCH_DATA'])){
        $auth = $kali->getAuthority();
        $kali->kaliReply($auth);
    }

}catch(Exception $e){
    die('Error Caught '.$e->getMessage());
}   
