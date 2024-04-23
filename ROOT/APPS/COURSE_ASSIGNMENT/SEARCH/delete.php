<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

if(isset($_POST['DELETE']) && $_POST['DELETE']=="JACKX_DELETE"){

    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'NUMBER','NOTREQUIRED']);

    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }
    
    $sql = 'SELECT  `id` FROM `user` WHERE `id`=:id';
    $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
    if($data){
        
        $sql = 'DELETE FROM `faculty_finance` WHERE `id`=:id';
        $data3 = $kali->kaliDel($sql,['id'=>$MY_ID]);

        if($data3){
            $kali->kaliReply(['ERROR'=>false,'MSG'=>'Data Deletion Complete']);
        }

    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

}
 