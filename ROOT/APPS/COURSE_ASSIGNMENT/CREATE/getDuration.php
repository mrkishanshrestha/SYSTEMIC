<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

    if(isset($_POST['SELECT_OPTION'])){
        
        $sql = 'SELECT `periods`, `based_on` FROM `faculty` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$_POST['FACULTY_ID']]);
        if($data){
            $kali->kaliReply($data);
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found','TARGET'=>['FACULTY']]);
        }
    }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>




