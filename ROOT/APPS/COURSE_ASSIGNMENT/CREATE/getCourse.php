<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

    if(isset($_POST['SELECT_OPTION'])){
        
        $sql = 'SELECT  `course_name`, `id` FROM `course` WHERE `faculty_id`=:faculty_id AND `faculty_period`=:faculty_period';
        $data = $kali->kaliPulls($sql,['faculty_id'=>$_POST['FACULTY_ID'],'faculty_period'=>$_POST['FACULTY_PERIOD']]);
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





