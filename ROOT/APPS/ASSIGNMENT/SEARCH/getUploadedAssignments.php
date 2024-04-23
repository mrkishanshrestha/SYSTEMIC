<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION = "ASSIGNMENT";
$kali->checkAccess($APPLICATION,'SEARCH');

    if($_POST['COURSE_REFID']!=''){
        $sql = 'SELECT course.faculty_period,course.faculty_id, stud_data.user_refid,
        assignment.due_date,assignment.id AS assignmnet_refid,
        CONCAT(user.first_name," ", user.middle_name," ",user.last_name) as fullname, user.username,
        assi_record.id, assi_record.assignment_files_x, assi_record.mark_obtained, assi_record.submited_date, assi_record.submit_status
        FROM `course` course 
        INNER JOIN `student_data` stud_data ON stud_data.faculty_period = course.faculty_period && stud_data.faculty_refid = course.faculty_id
        INNER JOIN `user` user ON user.id = stud_data.user_refid 
        LEFT JOIN `assignment_record` assi_record ON assi_record.assignment_refid = :assignment_refid && assi_record.user_refid = stud_data.user_refid
        LEFT JOIN `assignment` assignment ON assignment.id = assi_record.assignment_refid
        WHERE course.id = :course_refid';
        $data = $kali->kaliPulls($sql,['assignment_refid'=>$_POST['ASSIGNMENT_REFID'],'course_refid'=>$_POST['COURSE_REFID']]);
        if(!$data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'You Havent Done Any Assignmnets ! Dooo Soon !!!']);
            die;
        }
    }     

    $kali->kaliReply($data);
?>


