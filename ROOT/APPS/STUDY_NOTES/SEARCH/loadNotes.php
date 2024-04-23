<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        $sql = 'SELECT course.id, course.course_name, course.course_code, SN.document FROM `study_notes` as SN
        INNER JOIN `course`as course ON course.id = SN.course_id
        WHERE SN.course_id = (SELECT `id` FROM `course` WHERE course_code=:course_code)';
        $data = $kali->kaliPulls($sql,['course_code'=>$_POST['COURSE']]);
        if($data){
            $kali->kaliReply($data);
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found ','TARGET'=>['FACULTY']]);
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>




