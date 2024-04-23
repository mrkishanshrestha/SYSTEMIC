<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{
 
        if(isset($_POST['COURSE_REFID'])){

            if($_SESSION['MY_AUTHORITY']=="STUDENT"){
                $sql = 'SELECT course.faculty_id, course.faculty_period,
                CONCAT(user.first_name," ",user.middle_name," ",user.last_name) as fullname, user.username, user.id as user_refid,
                exam_record.obtained_marks, exam_record.status,exam_record.remarks,
                exam_details.id, examination.id as exam_id
                FROM `course` course
                INNER JOIN `student_data` stud_data ON stud_data.user_refid=:user_refid && stud_data.faculty_refid = course.faculty_id && stud_data.faculty_period = course.faculty_period
                INNER JOIN `user` user ON user.id = :user_refid
                INNER JOIN `examination` examination ON examination.id = :EXAMINATION_REFID
                INNER JOIN `examination_details` exam_details ON exam_details.examination_refid = :EXAMINATION_REFID && exam_details.course_refid = :course_refid
                LEFT JOIN `examination_record` exam_record ON exam_record.examination_details_refid = exam_details.id && exam_record.user_refid = stud_data.user_refid
                WHERE course.id=:course_refid  ORDER BY exam_record.status DESC';
                $bind = ['course_refid'=>$_POST['COURSE_REFID'],'EXAMINATION_REFID'=>$_POST['EXAMINATION_REFID'],'user_refid'=>$_SESSION['KOHOMAH']];

            }else{
                $sql = 'SELECT  course.faculty_id, course.faculty_period,
                CONCAT(user.first_name," ",user.middle_name," ",user.last_name) as fullname, user.username, user.id as user_refid,
                exam_record.obtained_marks, exam_record.status,exam_record.remarks,
                exam_details.id, examination.id as exam_id
                FROM `course` course
                INNER JOIN `student_data` stud_data ON stud_data.faculty_refid = course.faculty_id && stud_data.faculty_period = course.faculty_period
                INNER JOIN `user` user ON user.id = stud_data.user_refid
                INNER JOIN `examination` examination ON examination.id = :EXAMINATION_REFID
                INNER JOIN `examination_details` exam_details ON exam_details.examination_refid = :EXAMINATION_REFID && exam_details.course_refid = :course_refid
                LEFT JOIN `examination_record` exam_record ON exam_record.examination_details_refid = exam_details.id && exam_record.user_refid = stud_data.user_refid
                WHERE course.id=:course_refid ORDER BY exam_record.status DESC';
                $bind = ['course_refid'=>$_POST['COURSE_REFID'],'EXAMINATION_REFID'=>$_POST['EXAMINATION_REFID']];
            }

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





