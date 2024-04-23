<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$APPLICATION="BRANCH";
$kali->checkAccess($APPLICATION,'VIEW');

try{

    if(isset($_POST['SEARCH_DATA'])){

        $fACULTY = [];
        $sql = 'SELECT `short_name` FROM `college` WHERE `user_refid`=:user_refid';
        $data = $kali->kaliPulls($sql,['user_refid'=>$_SESSION['KOHOMAH']]);
        if($data){
            $ReplyData=[];
            foreach($data as $rows){
                array_push($ReplyData,$rows['short_name']);
            }
            $kali->kaliReply($ReplyData);
        }
    }

}catch(Exception $e){
    die('Error Caught '.$e->getMessage());
}   
