<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

if(isset($_POST['DELETE']) && $_POST['DELETE']=="JACKX_DELETE"){

    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'NUMBER','NOTREQUIRED']);

    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }
    
    $sql = 'SELECT  `id` FROM `client` WHERE `id`=:id';
    $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
    if($data){

        $sql = 'DELETE FROM `user_security` WHERE `user_id`=:user_id';
        $data3 = $kali->kaliDel($sql,['user_id'=>$MY_ID]);

        $sql = 'DELETE FROM `client` WHERE `id`=:id';
        $data2 = $kali->kaliDel($sql,['id'=>$MY_ID]);

        if($data2 && $data3){
            $kali->kaliReply(['ERROR'=>false,'MSG'=>'Data Deletion Complete']);
        }

    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

}
 