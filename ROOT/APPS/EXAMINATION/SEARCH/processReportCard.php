<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{
 
        if(isset($_POST['COURSE_REFID'])){

            $sql = 'SELECT exam_details.id, exam_details.examination_refid, exam_details.course_refid, exam_details.full_marks, exam_details.pass_marks,
            exam_record.obtained_marks, exam_record.status, exam_record.remarks,
            course.course_name, course.course_code 
            FROM `examination_details` as exam_details
            INNER JOIN `course` course ON course.id = exam_details.course_refid
            INNER JOIN `examination_record` as exam_record ON exam_record.examination_details_refid = exam_details.id && exam_record.user_refid = :USER_REFID
            WHERE exam_details.examination_refid = :EXAMINATION_REFID';
            $bind = ['USER_REFID'=>$_POST['USER_REFID'],'EXAMINATION_REFID'=>$_POST['EXAMINATION_REFID']];
            $data = $kali->kaliPulls($sql,$bind);
            if($data){
                $kali->kaliReply($data);
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found ','TARGET'=>['COURSE_REFID']]);
            }
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>





