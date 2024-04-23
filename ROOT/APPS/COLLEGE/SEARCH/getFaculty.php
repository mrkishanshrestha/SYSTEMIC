<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="COLLEGE";
$kali->checkAccess($APPLICATION,'SEARCH');

try{

    if(isset($_POST['SEARCH_DATA'])){
        $fACULTY = [];
        $sql = 'SELECT  `short_name` FROM `faculty` ';
        $data = $kali->kaliPulls($sql,[]);
        if($data){
            
            foreach($data as $data){
                array_push($fACULTY,$data['short_name']);
            }
            $kali->kaliReply($fACULTY);
        }
    }

}catch(Exception $e){
    die('Error Caught '.$e->getMessage());
}   
