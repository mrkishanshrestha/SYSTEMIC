<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        if(isset($_POST['APPLICATION_NAME'])){
            $sql = 'SELECT  `name` FROM `application_manifest` WHERE `name`=:name';
            $data = $kali->kaliPull($sql,['name'=>$_POST['APPLICATION_NAME']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['APPLICATION_NAME']]);
            }
        }
   

        die;
        
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>

